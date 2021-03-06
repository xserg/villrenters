<?php
/*////////////////////////////////////////////////////////////////////////////
lib2/DVS
------------------------------------------------------------------------------
����� ���������� ��� �������� AUTO.RU
����� �������� ���� �������������
------------------------------------------------------------------------------
$Id: CheckPerms.php 70 2011-04-11 07:15:31Z xxserg@gmail.com $
////////////////////////////////////////////////////////////////////////////*/

class DVS_CheckPerms
{
    // ������ ������ �������� DVS_Layuot
    var $layout_obj;

    // ������ ������� ��
    var $db_obj;

    // �������
    var $op;

    // ��������
    var $act;

    // ������ ���� ��� �������� �� ����� ������������
    var $perms_arr;

    // �����������
    function DVS_Checkperms($layout_obj, $db_obj, $op, $act, $role, $perms_arr = null)
    {
        // �������������� ������ �������� �������
        $this->layout_obj =& $layout_obj;

        // �������������� ������ �������
        $this->db_obj =& $db_obj;

        // �������������� �������� �������
        $this->op = $op;

        // �������������� ��������
        $this->act = $act;

        // �������������� ��� ������������
        $this->role = $role;

        // �������������� ����� �� ��������
        if (isset($this->db_obj->perms_arr[$this->act])) {
            $this->perms_arr = $this->db_obj->perms_arr[$this->act];
        } else {
            $this->perms_arr = $perms_arr;
        }
     }

    // �������� ������� �������� ����
    function checkPerms()
    {
        global $_DVS;

        // �������������� �������� ���� 
        if (method_exists($this->db_obj, 'checkPermsOp') && !$this->db_obj->checkPermsOp()) {
            return 'error_forbidden5';
        }

        // ���� ����� � �� ������ �����, ��� ��������� 
        if ($this->role == 'aa' && !isset($this->perms_arr[$this->role])) {
            return true;
        }

        // �������� ������� � �������� 
        if (!$this->checkOp()) {
            return 'error_forbidden1';
        }

        // �������� �������� 
        if (!$this->checkAct()) {
            return 'error_forbidden2';
        }

        // �������� �� ��������� ������ 
        if (in_array($this->act, array_keys($_DVS['CONFIG']['DVS_DEFAULT_CLASSES'])) && isset($_GET['id']) && !$this->checkPermsByField($this->layout_obj->perms_fieldname)) {
            return 'error_forbidden3';
        }
        
        // �������� ���� ������� ��������� 
        if ($this->role == 'ar' && !$this->checkPermsRedactor()) {
            //return 'error_forbidden4';
        }

        return true;
    }

    // ��������� ���������� �� ������ � ������ �������
    function checkOp()
    {
        // ������ ����������� ������ �� �����
        if (!is_array($this->layout_obj->op_arr)) {
            return false;
        }

        // ������� ��� � ������ �����������
        if (!in_array($this->op, $this->layout_obj->op_arr)) {
            return false;
        }

        return true;
    }

    // ��������� ���������� �� �������� this->perms_arr
    function checkAct()
    {
        // ����� ��� �������� �� ������
        if (!is_array($this->perms_arr)) {
            return false;
        }

        // �������� ��� ���� ���������
        if (!$this->perms_arr[$this->role]) {
            return false;
        }

        return true;
    }

    // ��������� ���������� �� ��������� ������ �� ���� this->layout_obj->project_obj->perms_fieldname
    function checkPermsByField($fieldname = 'user_id')
    {
        /*
        // ���� �� �����������
        if (!$fieldname) {
            return false;
        }
        */
        // ��������  �� ����*/
        if (isset($this->db_obj->$fieldname)) {
            if ($fieldname == 'user_id') {
                return $_SESSION['_authsession']['data']['id'] == $this->db_obj->$fieldname;
            } else {
                return $_SESSION['_authsession']['data'][$fieldname] == $this->db_obj->$fieldname;
            }
        } else {
            // �������� ������ � ������� �������
            return $this->checkLinkedTables($this->layuot_obj->linked_table_arr[$this->op]);
        }
    }

    // �������� ���������� �� ��������� ������ � ������� ������ this->layout_obj->linked_table_arr
    function checkLinkedTables($linked_arr)
    {
        // ������� ������� ���
        if (!is_array($linked_arr)) {
            return true;
        }
        
        // �������� ������ �� ������� �������
        $obj = DB_DataObject::factory($linked_arr[$this->op]['op']);
        $obj->get($this->db_obj->{$linked_arr[$this->op]['fieldname']});

        return $obj->N && $_SESSION['_authsession']['data'][$fieldname] == $obj->$fieldname;
    }

    // �������� ���� ������� ���������
    function checkPermsRedactor()
    {

    }
}
?>
