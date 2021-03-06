<?php
/*////////////////////////////////////////////////////////////////////////////
lib2/DVS
------------------------------------------------------------------------------
����� �������� ��������� ������
------------------------------------------------------------------------------
$Id: CheckBlack.php 70 2011-04-11 07:15:31Z xxserg@gmail.com $
////////////////////////////////////////////////////////////////////////////*/

class DVS_CheckBlack
{
    // ���������� ���-�� ����������
    var $_maxCount = 3;
    // ������� ����������
    var $_checkTable = 'sale';
    // ���� user_id
    var $_userField = 'user_id';
    // ���� client_id
    var $_clientField = 'client_id';
    // ���� ��� ���������
    var $_phoneFields = array('phone1', 'phone2', 'phone3');
    // ������� ������ �����������
    var $_blacklistTable = 'blacklist';
    // ������� ����������
    var $reason_arr = array(
        1   => array('error_blocked', '����������'),
        2   => array('error_phone', '���������� �� ��������'),
        3   => array('error_exist', '������������ ������!'),
        4   => array('error_phone', '����������� � ������ ���������������'),
    );
    // ����������� ������
    var $values;
    // ���� ����������� �������
    var $checkTableFields;
    // ���� ��� �������� �� ������������
    var $_duplicateFields = array();

    function DVS_CheckBlack($values=array(NULL), $options=array(NULL))
    {
        // ������������� ����������
        $availableOptions = array(
            'maxCount',
            'checkTable',
            'userField',
            'clientField',
            'phoneFields',
            'blacklistTable',
            'duplicateFields',
        );
        foreach ($options as $key => $value) {
            if (in_array($key, $availableOptions)) {
                $property = '_'.$key;
                $this->$property = $value;
            }
        }
        // ����������� ������
        $this->values = $values;
        // ���� ����������� �������
        $db_obj = DB_DataObject::factory($this->_checkTable);
        $this->checkTableFields = $db_obj->table();
        // ���� ��� �������� ������������
        if (!count($this->_duplicateFields)) {
            foreach ($this->checkTableFields as $field => $type) {
                if ($field != 'id' && $field != $this->_clientField && $field != $this->_userField) {
                    $this->_duplicateFields[] = $field;
                }
            }
        }
        // email ������������
        $user_obj = DB_DataObject::factory('user');
        $user_obj->get($this->values[$this->_userField]);
        $this->values['email'] = $user_obj->email;
    }

    // �������� �� ���-�� ����������
    function checkCount()
    {
        $db_obj = DB_DataObject::factory($this->_checkTable);
        if ($this->checkTableFields[$this->_clientField]) {
            $db_obj->whereAdd($this->_clientField.'=0');
        }
        $db1_obj = $db_obj;

        // �������� �� ���-�� �� user_id
        $db_obj->whereAdd($this->_userField.'='.$this->values[$this->_userField]);
        //if ($db_obj->count(DB_DATAOBJECT_WHEREADD_ONLY) >= $this->_maxCount) {
        if ($db_obj->count() >= $this->_maxCount) {
            return -1;
        }
        // �������� �� ���-�� �� ���������
        if (!$this->_phoneFields) {
            return 0;
        }
        if (!is_array($this->_phoneFields)) {
            $this->_phoneFields = array($this->_phoneFields);
        }      
        $templateQuery = '';
        foreach ($this->_phoneFields as $key => $phoneField) {
            if (!$this->checkTableFields[$phoneField]) {
                unset($this->_phoneFields[$key]);
            } else {
                $templateQuery .= $phoneField."='{phone}' OR ";
            }
        }
        $templateQuery = substr($templateQuery, 0, -4);
        if (!count($this->_phoneFields)) {
            return 0;
        }
        $query = '';
        foreach ($this->_phoneFields as $phoneField) {
            if ($this->values[$phoneField]) {
                $query .= str_replace('{phone}', $this->values[$phoneField], $templateQuery).' OR ';
            }
        }
        $db1_obj->whereAdd('('.substr($query, 0, -4).')');
        $db1_obj->selectAdd();
        $db1_obj->selectAdd($this->_userField.','.implode(',', $this->_phoneFields));
        $db1_obj->find();
        $cnt_phone_arr = array();
        while ($db1_obj->fetch()) {
            $row_phone_arr = array();
            foreach ($this->_phoneFields as $phoneField) {
                if ($db1_obj->{$phoneField} && !$row_phone_arr[$db1_obj->{$phoneField}]) {
                    $cnt_phone_arr[$db1_obj->{$phoneField}]++;
                    $row_phone_arr[$db1_obj->{$phoneField}] = 1;
                }
            }
        }
        foreach ($cnt_phone_arr as $phone => $cnt) {
            if ($cnt >= $this->_maxCount) {
                return 2;
            }
        }
        return 0;
    }

    // �������� �� ������������ ������������ ����������
    function checkDuplicate()
    {
        $db_obj = DB_DataObject::factory($this->_checkTable);
        if ($this->checkTableFields[$this->_clientField] && $this->values[$this->_clientField]) {
            $db_obj->{$this->_clientField} = $this->values[$this->_clientField];
        } else {
            $db_obj->{$this->_userField} = $this->values[$this->_userField];
        }
        foreach ($this->_duplicateFields as $field) {
            $db_obj->$field = $this->values[$field];
        }
        if ($db_obj->count()) {
            return 3;
        }
        return 0;
    }

    // �������� �� ������ blacklist'a
    function checkBlacklist()
    {
        $blacklist_obj = DB_DataObject::factory($this->_blacklistTable);
        $query  = $this->_userField."=".$this->values[$this->_userField];
        $query .= " OR email='".$this->values['email']."'";
        foreach ($this->_phoneFields as $phoneField) {
            if ($this->values[$phoneField]) {
                $query .= " OR phone='".$this->values[$phoneField]."'";
            }
        }
        $blacklist_obj->whereAdd('('.$query.')');
        if ($blacklist_obj->count()) {
            return 4;
        }
        return 0;
    }

    // ���������� � ������ �����������
    function insertInBlacklist($error_code)
    {
        if ($error_code >= 0) {
            return ;
        }
        $blacklist_obj          = DB_DataObject::factory($this->_blacklistTable);
        $blacklist_obj->user_id = $this->values[$this->_userField];
        $blacklist_obj->email   = $this->values['email'];
        $blacklist_obj->phone   = $this->values[$this->_phoneFields[0]];
        $blacklist_obj->reason  = abs($error_code);
        if (!$blacklist_obj->count()) {
            $blacklist_obj->insert();
        }
        return ;
    }

    // �������� ������ �� ��������� ������, ���������� ��� ������
    function checkValues($action)
    {
        if ($action == 'new') {
            // �������� �� ������������ ������������ ����������
            if ($error_code = $this->checkDuplicate()) {
                return $this->reason_arr[abs($error_code)][0];
            }
            // �������� �� ���������� ���-�� �������, ��������� ������ �� ���������� �� ���-�� ������� �� ������ ������������
            // ��� ���������� ������ ��������, �� ��������� ������, �� � �� ���������
            if ($error_code = $this->checkCount()) {
                $this->insertInBlacklist($error_code);
                return $this->reason_arr[abs($error_code)][0];
            }
        }
        // �������� �� ������ blacklist'a ��� �������������� � ����������
        // ������ ������ ��������� �� ������, �� ���������
        if ($error_code = $this->checkBlacklist()) {
            return $this->reason_arr[abs($error_code)][0];
        }
        return 0;
    }
}

?>
