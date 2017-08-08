<?php
/**
////////////////////////////////////////////////////////////////////////////
aservice
------------------------------------------------------------------------------
Отображение текстовых страниц сайта
------------------------------------------------------------------------------
$Id:  $
////////////////////////////////////////////////////////////////////////////
*/

require_once COMMON_LIB.'DVS/Dynamic.php';

class Project_Articles_Show extends DVS_Dynamic
{
    // Права
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
        */
        if (!$this->db_obj->N) {
            $this->show404();
            $this->nocache = true;
        }
        if (!empty($this->db_obj->title)) {
            $page_arr['CENTER_TITLE'] = $this->db_obj->title;
        }

        $country_obj = DB_DataObject::factory('countries');
        $countries_obj = DB_DataObject::factory('countries');
        $countries_obj->getParent($this->db_obj->location_id);
        $this->region_title_t = $countries_obj->region_title_t;
        $this->region_title_p =  $countries_obj->region_title_p;

        //DB_DataObject::DebugLevel(1);
        $this->createTemplateObj();
        $this->template_obj->loadTemplateFile('articles_show.tpl');
        $this->template_obj->setVariable(
                array(
                    'LOCATION' => $countries_obj->region_title,
                    'BODY'      => nl2br($this->db_obj->body),
                )
        );
       //print_r($this->db_obj);;
        $page_arr['KEYWORDS']         = $this->db_obj->meta_keys;
        $page_arr['DESCRIPTION']         = $this->db_obj->meta_descr;
        $page_arr['CENTER']         = $this->template_obj->get();
        //$page_arr['CENTER'] = '<p><br><br>'.nl2br($this->db_obj->body).'<br><br>';
        return $page_arr;
    }
}

?>