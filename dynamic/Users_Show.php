<?php
/**
 * �������� ������������
 * @package web2matrix
 * $Id: Users_Show.php 70 2011-04-11 07:15:31Z xxserg@gmail.com $
 */

require_once COMMON_LIB.'DVS/Dynamic.php';

class Project_Users_Show extends DVS_Dynamic
{
    // �����
    var $perms_arr = array('iu' => 1);

    function getPageData()
    {
        if (!$this->db_obj->N) {
            $this->show404();
            $this->nocache = true;
        }

        $this->createTemplateObj();
        $this->template_obj->loadTemplateFile('users_show.tpl');

        $fields = array(
                'user_name',
                'name',
                'status_name',
                'url_click',
                'start_date',
             //'content_id' =>  '',
                'campaign_price',
                'show_count',
                'note',
                'registration_date',
                 //'content_path'
        );
        $this->template_obj->setVariable(array('ZAG' => '��������� ��������'));
        $this->template_obj->parse('ROW');
        foreach ($fields as $key) {
                $this->template_obj->setVariable(array('KEY' => ($this->db_obj->fb_fieldLabels[$key] ? $this->db_obj->fb_fieldLabels[$key] : $key), 'VAL' => nl2br($this->db_obj->$key)));
            $this->template_obj->parse('ROW');
        }


        $this->template_obj->setVariable(array(  'ZAG' => '�������� �������'      ));
        $this->template_obj->parse('ROW');
        $address_conditions_obj = DB_DataObject::factory('address_conditions');
        $cond = $address_conditions_obj->getConditions($this->db_obj->campaign_id);

        if (!empty($this->db_obj->title)) {
            $page_arr['CENTER_TITLE'] = $this->db_obj->title;
        }
        $page_arr['CENTER'] = '<pre>'.$this->db_obj->body.'</pre>';
        return $page_arr;
    }
}

?>