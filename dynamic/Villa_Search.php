<?php
/**
 * ������ ����
 * @package villarenters
 * $Id: Villa_Search.php 81 2011-05-17 08:38:35Z xxserg@gmail.com $
 */

define('PER_PAGE', 10);

require_once COMMON_LIB.'DVS/Dynamic.php';
require_once COMMON_LIB.'DVS/Table.php';


class Project_Villa_Search extends DVS_Dynamic
{
    // �����
    public $perms_arr = array('iu' => 1, 'oc' => 1);

    private $lang_ru = array(
        'Rates' => '����',
        'week' => '� ������',
        'Sleeps' => '�������� ����',
        'details' => '���������...',
        'booking' => '�������������',
    );

    function getPageData()
    {        

        $keyword = DVS::getVar('keyword');

        $this->createTemplateObj();
        $this->template_obj->loadTemplateFile('villa_search1.tpl');

        $page_arr['BODY_CLASS']   = 'adv-search';
        $page_arr['CENTER']         = $this->db_obj->getSearchFormClient($this->template_obj);
        $page_arr['JSCRIPT']        = $this->page_arr['JSCRIPT'];
        return $page_arr;
    }
/*
    function getForm()
    {
        require_once ("HTML/QuickForm.php");
        $form = new HTML_QuickForm('searchForm', 'POST', '/search/');
        $form->addElement('text', 'keyword', '', array('class' => "text input-keyword default ac_input", 'id' => "searchKeywords") );
        $form->addElement('text', 'minprice', '', array('class' => 'input'));
        $form->addElement('text', 'maxprice', '', array('class' => 'input'));
        $sleeps_arr = array();
        $form->addElement('select', 'sleeps', '', $sleeps_arr);
        $form->addElement('select', 'proptype', '', array('' => '�����') + $this->db_obj->prop_type_arr);
        
        $form->addElement('select', 'user_id', '', array('' => '�����', 54440 => 'LetInTheSun'));
        $form->addElement('submit', 'submit', 'Register');

        require_once 'HTML/QuickForm/Renderer/ITStatic.php';
        $renderer =& new HTML_QuickForm_Renderer_ITStatic($this->template_obj);
        //$renderer->setRequiredTemplate('{label}<font color="red" size="1">*</font>');
        //$renderer->setErrorTemplate('<font color="red">{error}</font><br />{html}');
        $form->accept($renderer);
        return $this->template_obj->get();

    }
    */
}
?>