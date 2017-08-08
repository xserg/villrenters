<?php
/*////////////////////////////////////////////////////////////////////////////
lib2/DVS
------------------------------------------------------------------------------
����� ���������� ��� ��������
����� �������� �������
------------------------------------------------------------------------------
$Id: Delete.php 70 2011-04-11 07:15:31Z xxserg@gmail.com $
////////////////////////////////////////////////////////////////////////////*/

require_once COMMON_LIB.'DVS/Dynamic.php';

class DVS_Delete extends DVS_Dynamic
{
    function getPageData()
    {
        $res = true;
        //�������� ����� ���������
        if (method_exists($this->db_obj, 'preDelete')) {
            $res = $this->db_obj->preDelete();
        }
        if ($res && !$this->db_obj->msg) {
            $this->msg = $this->db_obj->delete() ? 'DELETE_ROW' : 'ERROR';
        } else {
            $this->msg = $this->db_obj->msg;
        }

        $this->goLocation();
    }
}
?>
