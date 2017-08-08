<?php
/**
* @package aservice
* lib/DVS
* ------------------------------------------------------------------------------
* ����� �������� ���������
* ------------------------------------------------------------------------------
* $Id: CheckPhone.php 70 2011-04-11 07:15:31Z xxserg@gmail.com $
*/

define('ERROR_PHONE_REPEAT', '� ������ ��� ����� �����������!');
define('ERROR_PHONE_MSCCODE', '������������ ��� ��� ������ ������!');
define('ERROR_PHONE_INCORRECT', '������������ ������! ������: (495) 123-34-78');
define('ERROR_PHONE_NOT_CODE', '�� ������ ��� ������!');
define('ERROR_PHONE_ZERO', '������������ ����� ��������!');
define('ERROR_PHONE_COUNT_10', '� ������ ������ ���� 10 ����!');
define('ERROR_PHONE_COUNT_7', '� ������ ������ ���� 7 ����!');
define('ERROR_PHONE_COUNT', '������������ ���������� ���� � ������!');
define('ERROR_REPEAT_PHONE', '������ ����� �������� ��� ������!');
define('ERROR_PHONE_EXIST', '���� �� ��������� ������� �������� ��� ��������������� � �������!');

class DVS_CheckPhone
{

    var $_optionPhoneFields = array('phone1', 'phone2', 'phone3');

    // �������� ����� �� ������������ ���������
    function checkCorrectPhone($phone)
    {
        // (���_������) (3)|���_������ 3 �����_�������� 3+2+2
        //$pattern = "/^[8\+7]{0,}(\([0-9]{3}\)|[0-9]{3})[ ]{0,}([0-9]{3})[- ]?([0-9]{2})[- ]?([0-9]{2})$/";
        $pattern = "/^[87]{0,}([0-9]{3})([0-9]{7})$/";
        preg_match($pattern, preg_replace('/[^0-9]/', '', $phone), $match);
        return $match ? $match : false;
    }

    // �������� �� ���������� ���� � ������
    function checkPhoneRepeat($number)
    {
        return preg_match('/^(0+|1+|2+|3+|4+|5+|6+|7+|8+|9+)$/', $number)? false : true;
    }

    // �������� ���������� ����� ������
    function checkMSCCode($code)
    {
        $msk_code = array('095', '495', '477', '499', '501', '901', '902', '903', '905', '906', '909', '910', '911', '915', '916', '917', '921', '926', '960');
        return in_array($code, $msk_code) ? true : false;
    }

    // �������� ������ ������ �� 0
    function checkZeroPhone($number, $code)
    {
        $valid_codes = array('903', '905', '906', '915', '916');
        return $number[0] == '0' && (!$code || !in_array($code, $valid_codes)) ? false : true;
    }

    /**
    * �������� �������� �� ���� ����������
    * @param $phone
    * @return ��� ������ | ''
    */
    function checkFormPhoneField($phone)
    {
        // �������� ������� � ���������
        if (!$phone_arr = DVS_CheckPhone::checkCorrectPhone($phone)) {
            return ERROR_PHONE_INCORRECT;
        }
        //echo '<pre>';
        //print_r($phone_arr);
        // ����� �������� ��� ���� ������ � ������
        $number = $phone_arr[2];
        // ��� ������
        $code = $phone_arr[1];

        // �������� ������ ������ �� 0
        if (!DVS_CheckPhone::checkZeroPhone($number, $code)) {
            return ERROR_PHONE_ZERO;
        }
        // �������� �� ���-�� ���� - 10
        $number_cnt = strlen($number);
        $count      = $number_cnt + strlen($code);
        if (!$code && $number_cnt != 7) {
            return ERROR_PHONE_COUNT_7;
        }
        if ($code && $count != 10) {
            return ERROR_PHONE_COUNT_10;
        }
        // �������� �� ���������� ����
        //if (!DVS_CheckPhone::checkPhoneRepeat($number)) {
        //    return ERROR_PHONE_REPEAT;
        //}
        // �������� ���������� ����� ������
        if ($code && !DVS_CheckPhone::checkMSCCode($code)) {
            return ERROR_PHONE_MSCCODE;
        }
        return '';
    }

    /**
    * �������� ���� ��������� � �����
    * @param $fields array(��������_���� => ��������)
    * @return ������ array(��������_���� => ������) | ''
    */
    function checkFormPhone($fields)
    {
        // �������� ��������
        $phone_arr = array();
        foreach ($fields as $name => $phone) {
            $msg   = '';
            if ($phone) {
                $phone_arr[$phone]++;
                // �������� �� ������������
                if ($phone_arr[$phone] > 1) {
                    $msg = ERROR_REPEAT_PHONE;
                }
                // �������� ��������
                if (!$msg) {
                    $msg = DVS_CheckPhone::checkFormPhoneField($phone);
                }
                // ������
                if ($msg) {
                    $arr[$name] = $msg;
                } else {
                    $this->tableValues[$name] = DVS_CheckPhone::formatPhone($phone);
                }
            }
        }
        //print_r($tableValues);
        /*
        if ($msg = DVS_CheckPhone::_checkCountByPhone($tableValues)) {
            $arr['phone'] = $msg;
        }
        */
        return $arr ? $arr : '';
    }

    /**
    * ���������� ����������� ������ ��������
    * (495) 123-45-67
    * @param $phone string
    * @return string
    */
    function formatPhone($phone)
    {
        if (!$arr = DVS_CheckPhone::checkCorrectPhone($phone)) {
            return '';
        }
        $number = '';
        $number .= '('.$arr[1].') ';
        $number .= substr($arr[2], 0, 3).'-'.substr($arr[2], 3, 2).'-'.substr($arr[2], 5, 2);
        return $number;
    }

    /**
    * �������� �� ���-�� ���������� �� ��������
    * @param
    * @return true|false - true - ���-�� ���������� �� ��������� ���������� ��������, false - ���������
    */
    function checkCountByPhone($tableValues, $id = 0)
    {
        $_optionPhoneFields = array_keys($tableValues);
        // ��� ��������� � �������
        if (!count($_optionPhoneFields)) {
            return true;
        }

        // �������� ������ ��� ������ ����������
        $templateQuery = '';
        foreach ($_optionPhoneFields as $phoneField) {
            $templateQuery .= $phoneField."='{phone}' OR ";
        }
        $templateQuery = substr($templateQuery, 0, -4);
        $query = '';
        foreach ($_optionPhoneFields as $phoneField) {
            if ($tableValues[$phoneField]) {
                $query .= str_replace('{phone}', $tableValues[$phoneField], $templateQuery).' OR ';
            }
        }
        // �����
        //DB_DataObject::DebugLevel(1);
        $db_obj = DB_DataObject::factory('members');

        // ��� ������� ������
        if ($id) {
            $db_obj->whereAdd('id!='.$id);
        }

        $db_obj->whereAdd('('.substr($query, 0, -4).')');
        $db_obj->selectAdd();
        $db_obj->selectAdd(implode(',', $_optionPhoneFields));
        //$db_obj->find(true);

        if ($db_obj->count()) {
            return ERROR_PHONE_EXIST;
        } else {
            return '';
        }
        /*
        // ������� ���-�� ���������� �� ������ �������
        $cnt_phone_arr = array();
        while ($db_obj->fetch()) {
            $row_phone_arr = array();
            foreach ($_optionPhoneFields as $phoneField) {
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
        */
    }
}

?>
