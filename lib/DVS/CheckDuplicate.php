<?php
/*////////////////////////////////////////////////////////////////////////////
autoru/lib
------------------------------------------------------------------------------
���������� ��� ������ ���������� �������������
------------------------------------------------------------------------------
$Id: CheckDuplicate.php 70 2011-04-11 07:15:31Z xxserg@gmail.com $
////////////////////////////////////////////////////////////////////////////*/

class CheckExist
{

    /* ���� ��� ��������� */
    var $_optionPhoneFields = array('phone1', 'phone2', 'phone3');
    /* ���� ����� ��������� ���������� */
    var $_optionExpireDate = '';
    /* ����������� ������ */
    var $tableValues;
    /* ���� ����������� ������� */
    var $tableFields;
    /* ���� ��� �������� �� ������������ */
    var $_optionDuplicateFields = array();

    /**
    * �������������� ��������� ����������
    * @param $server - string ����� �������
    * @param $options - array ������ ����� � �������
    * @param $tableValues - array ������ ������ ��� ��������
    * @return true|false - true, ���� ��������� ������������, false - ������� ��� �������� � ������� �� ����������
    */
    function initOptions($server, $options = array(NULL), $tableValues = array(NULL))
    {
        // ������������� ����������
        $availableOptions = array(
            'MaxCount',
            'UserField',
            'ClientField',
            'SmsField',
            'PhoneFields',
            'DuplicateFields',
            'ExpireDate',
        );
        foreach ($options as $key => $value) {
            if (in_array($key, $availableOptions)) {
                $property = '_option'.$key;
                $this->$property = $value;
            }
        }

        // ���� ����������� �������
        $this->server = $server;
        $db_obj = $this->_createCheckTableObj();
        if ($db_obj === false) {
            return false;
        }
        $this->tableFields = $db_obj->table();

        // ��������� ����� ��������� ���������� �� ���������
        if ($this->_optionExpireDate == '') {
            $this->_optionExpireDate = date('Y-m-d', strtotime('+ 6 month'));
        }

        // ���� ��� �������� ������������
        if (!count($this->_optionDuplicateFields)) {
            foreach ($this->tableFields as $field => $type) {
                if ($field != 'id' && $field != $this->_optionClientField && $field != $this->_optionUserField) {
                    $this->_optionDuplicateFields[] = $field;
                }
            }
        }

        // ��������
        if ($this->_optionPhoneFields && !is_array($this->_optionPhoneFields)) {
            $this->_optionPhoneFields = array($this->_optionPhoneFields);
        }
        foreach ($this->_optionPhoneFields as $key => $phoneField) {
            if (!$this->tableFields[$phoneField]) {
                unset($this->_optionPhoneFields[$key]);
            }
        }

        // ����������� ������
        $this->tableValues = $tableValues;

        // email ������������
        $user_obj = DB_DataObject::factory('user');
        $user_obj->get($this->tableValues[$this->_optionUserField]);
        $this->tableValues['email'] = $user_obj->email;

        // �������� id ������
        if ($_GET['id'] && $this->tableValues['id'] != $_GET['id']) {
            $this->tableValues['id'] = $_GET['id'];
        }


        return true;
    }

    /**
    * �������� ������ �� ��������� ������, ���������� ��� ������
    * @param $action - string �������� (���������� === new ��� ��������������)
    * @param $server - string ����� �������
    * @param $options - array ������ ����� � �������
    * @param $tableValues - array ������ ������ ��� ��������
    * @return string - ��� ������
    */
    function checkValues($action, $server, $options = array(NULL), $tableValues = array(NULL))
    {
        // �������������� ���������
        if (!$this->initOptions($server, $options, $tableValues)) {
            return '';
        }

        if ($action == 'new') {
            // �������� �� ������������ ������������ ����������
            if (!$this->_checkDuplicate()) {
                return 'error_exist';
            }
            // �������� � ���������� �� ���������� ���-�� ������� �� ������ ������������
            if (!$this->_checkCountByUserId()) {
                return 'error_count';
            }
        }
        // �������� �� ���������� ���-�� ������� �� ��������
        if (!$this->_checkCountByPhone()) {
            return 'error_phone_count';
        }
        // �������� �� ������ blacklist'a ��� �������������� � ����������
        if (!$this->_checkInBlacklist()) {
            return 'error_blocked_phone';
        }
        return '';
    }

    /**
    * �������� ������������ ������ � ����������
    * @param
    * @return true|false
    */
    function sendLetter($to_email, $from_email)
    {
        /* ����������� ������� � ����������� �� SMS-�������� */
        require_once AUTORU_FOLDER.'conf/config_sms.inc';
        require_once 'HTML/Template/Sigma.php';
        $template_obj =& new HTML_Template_Sigma(AUTORU_FOLDER.TMPL_FOLDER, PROJECT_ROOT.CACHE_FOLDER.'tmpl');
        $template_obj->loadTemplateFile('blacklist_mail.tmpl', 1, 1);
        $template_obj->setVariable(array(
            'server'        => SERVER,
            'count_sale'    => $this->_optionMaxCount,
            'sms_format'    => str_replace('{user_id}', $this->tableValues[$this->_optionUserField], SMS_UNBLOCK),
            'sms_number'    => SMS_UB_NUMBER,
            'sms_price'     => SMS_UB_PRICE,
        ));
        require_once COMMON_LIB.'DVS/Mail.php';
        $mail_obj =& new DVS_Mail();
        $mail_obj->params = array(
            'body'      => $template_obj->get(),
            'from'      => $from_email ? $from_email : 'autoinfo@auto.ru',
            'to'        => $to_email,
            'subject'   => 'www.'.SERVER.'.auto.ru : Your sale was blocked',
        );
        $mail_obj->send();
    }

    /**
    * ������� ������ DB_DataObject ��� ������� �����������
    * @param $server - string ����� �������
    * @return object|false - object - ������ DB_DataObject, false - ��� ������� ��� �� ������� ������� � �������
    */
    function _createCheckTableObj()
    {
        // �������������� ������ � �� �������
        if (!isset($this->server_obj)) {
            $this->server_obj = DVS_Dynamic::dbFactory('servers');
            $this->server_obj->get('server', $this->server);

            if (!$this->server_obj->N) {
                return false;
            }

            global $_DB_DATAOBJECT;
            $_DB_DATAOBJECT['CONFIG']['database_'.$this->server_obj->db] = 'mysql://'.DB_USER.':'.DB_PASS.'@'.$this->server_obj->host.'/'.$this->server_obj->db;
            $_DB_DATAOBJECT['CONFIG']['table_'.$this->server_obj->table_sale] = $this->server_obj->db;
            $_DB_DATAOBJECT['CONFIG']['class_location_'.$this->server_obj->db] = PROJECT_ROOT.'../'.$this->server_obj->server.'/DataObjects/';
            $_DB_DATAOBJECT['CONFIG']['class_prefix_'.$this->server_obj->db] = $this->server_obj->class_prefix;
        }

        // ������ ������ DB_DataObject
        if ($this->server_obj->table_sale) {
            return DVS_Dynamic::dbFactory($this->server_obj->table_sale);
        }

        return false;
    }

    /**
    * �������� �� ������������ ������������ ����������
    * @param
    * @return true|false - true - ���������� �� �����������, false - �����������
    */
    function _checkDuplicate()
    {
        $db_obj = $this->_createCheckTableObj();

        if ($this->tableFields[$this->_optionClientField] && $this->tableValues[$this->_optionClientField]) {
            // �������� ��� �� ����
            $db_obj->{$this->_optionClientField} = $this->tableValues[$this->_optionClientField];
        } else {
            // �������� ��� ��� ����
            $db_obj->{$this->_optionUserField} = $this->tableValues[$this->_optionUserField];
        }

        // ��������� �������� ��� ��������
        foreach ($this->_optionDuplicateFields as $field) {
            $db_obj->$field = $this->tableValues[$field];
        }

        // ���������� �����������
        if ($db_obj->count()) {
            return false;
        }

        return true;
    }

    /**
    * �������� �� ���-�� ���������� �� user_id
    * @param
    * @return true|false - true - ���-�� ���������� �� ��������� ���������� ��������, false - ���������
    */
    function _checkCountByUserId()
    {
        $db_obj = $this->_createCheckTableObj();

        // ������ ��� ��� ���
        if ($this->tableFields[$this->_optionClientField]) {
            $db_obj->whereAdd($this->_optionClientField.'=0');
        }

        // ������ ������������ ����������
        if ($this->tableFields[$this->_optionSmsField]) {
            $db_obj->whereAdd($this->_optionSmsField.'=0');
        }

        // ��� ������������
        $db_obj->whereAdd($this->_optionUserField.'='.$this->tableValues[$this->_optionUserField]);

        // ���-�� ��������� ����������
        if ($db_obj->count() >= $this->_optionMaxCount) {
            return false;
        }

        return true;
    }

    /**
    * �������� �� ���-�� ���������� �� ��������
    * @param
    * @return true|false - true - ���-�� ���������� �� ��������� ���������� ��������, false - ���������
    */
    function _checkCountByPhone()
    {
        // ��� ��������� � �������
        if (!count($this->_optionPhoneFields)) {
            return true;
        }

        // �������� ������� ��� ������ ����������
        $templateQuery = '';
        foreach ($this->_optionPhoneFields as $phoneField) {
            $templateQuery .= $phoneField."='{phone}' OR ";
        }
        $templateQuery = substr($templateQuery, 0, -4);

        $query = '';
        foreach ($this->_optionPhoneFields as $phoneField) {
            if ($this->tableValues[$phoneField]) {
                $query .= str_replace('{phone}', $this->tableValues[$phoneField], $templateQuery).' OR ';
            }
        }

        // �����
        $db_obj = $this->_createCheckTableObj();
        // ������ ��� ��� ���
        if ($this->tableFields[$this->_optionClientField]) {
            $db_obj->whereAdd($this->_optionClientField.'=0');
        }
        // ������ ������������ ����������
        if ($this->tableFields[$this->_optionSmsField]) {
            $db_obj->whereAdd($this->_optionSmsField.'=0');
        }
        // ��� ������� ������
        if ($this->tableValues['id']) {
            $db_obj->whereAdd('id!='.$this->tableValues['id']);
        }
        $db_obj->whereAdd('('.substr($query, 0, -4).')');
        $db_obj->selectAdd();
        $db_obj->selectAdd($this->_optionUserField.','.implode(',', $this->_optionPhoneFields));
        $db_obj->find();

        // ������� ���-�� ���������� �� ������ �������
        $cnt_phone_arr = array();
        while ($db_obj->fetch()) {
            $row_phone_arr = array();
            foreach ($this->_optionPhoneFields as $phoneField) {
                if ($db_obj->{$phoneField} && !$row_phone_arr[$db_obj->{$phoneField}]) {
                    $cnt_phone_arr[$db_obj->{$phoneField}]++;
                    $row_phone_arr[$db_obj->{$phoneField}] = 1;
                }
            }
        }

        // �������� �� ���-��
        foreach ($cnt_phone_arr as $phone => $cnt) {
            if ($cnt >= $this->_optionMaxCount) {
                return false;
            }
        }
        return true;
    }

}
?>