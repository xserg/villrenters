<?php
/**
////////////////////////////////////////////////////////////////////////////
aservice
------------------------------------------------------------------------------
����������� ��������� ������� �����
------------------------------------------------------------------------------
$Id: Pages_Show.php 70 2011-04-11 07:15:31Z xxserg@gmail.com $
////////////////////////////////////////////////////////////////////////////
*/

require_once COMMON_LIB.'DVS/Dynamic.php';

class Project_Pages_Cars extends DVS_Dynamic
{
    // �����
    var $perms_arr = array('iu' => 1, 'ar' => 1);

    function getPageData()
    {
        /*
        $alias = DVS::getVar('alias');
        if (!$this->db_obj->N && !$alias) {
            $alias = 'index';
        }
        if ($alias) {
            $this->db_obj->get('alias', $alias);
        }
        if (!$this->db_obj->N) {
            $this->show404();
            $this->nocache = true;
        }
        if (!empty($this->db_obj->title)) {
            $page_arr['CENTER_TITLE'] = $this->db_obj->title;
        }
        */
        $page_arr['CENTER_TITLE'] = '������ �����������';
        $page_arr['CENTER'] = '<br><br>'.file_get_contents(PROJECT_ROOT.'tmpl/cars.tpl');
        return $page_arr;
    }
}

?>