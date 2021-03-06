<?php
/*////////////////////////////////////////////////////////////////////////////
lib2/DVS
------------------------------------------------------------------------------
����� �������� ����������� �������
------------------------------------------------------------------------------
$Id: Static.php 70 2011-04-11 07:15:31Z xxserg@gmail.com $
////////////////////////////////////////////////////////////////////////////
*/

require_once COMMON_LIB.'DVS/Page.php';

class DVS_Static extends DVS_Page
{
    function showPage()
    {
        $this->createTemplateObj();

        if ($_GET['act'] == 'help') {
            $this->page_arr['CENTER_TITLE'] = $this->page_arr['CENTER_SUB_TITLE'] = '����� ���������� �������';
            $this->page_arr['CENTER'] = $this->showHelp();
        } else if ($_GET['act'] == 'error_login' && AUTH_FORM == 'html') {
            //$this->hide_blocks = 'RIGHT';
            $this->page_arr['CENTER_TITLE'] = $this->page_arr['CENTER_SUB_TITLE'] = '�����������';
            $this->page_arr['CENTER'] = $this->showLogin();
        } else if ($_GET['act'] == 'logout') {
            require_once COMMON_LIB.'DVS/Page.php';
            DVS_Page::logOut();
        } else {
            $filename = PROJECT_ROOT.'inc/'.$this->act.'.inc';
        }

        $this->loadTemplate();
        $this->layout_obj->getPageData(&$this->template_obj);


        if (file_exists($filename)) {
            $this->page_arr['CENTER'] = file_get_contents($filename);
        }

        if (!$this->page_arr['CENTER'] && defined('DVS_'.strtoupper($this->act))) {
            $this->showMessage($this->act);
        }
        if ($this->msg) {
            $this->showMessage($this->msg);
        }
        return $this->parsePage();
    }

    /**
    * ���������� HTML - ����� ����� �����-������
    * @return string
    */
    function showLogin()
    {
        $this->src_files = array(
            'CSS_SRC'  => array('/css/form.css')
        );
        $this->template_obj->loadTemplateFile('login_page.tpl', 1, 1);
        /*
        $this->template_obj->setVariable(array(
            'IMAGE_URL' => IMAGE_URL,
            'USERNAME'  => $_POST['username'] ? $_POST['username'] : $_COOKIE['username'],
            'PASSWORD'  => $_COOKIE['password'],
            'CHECKED'   => $_COOKIE['password'] ? ' CHECKED' : '',
        ));
        */
        
        //print_r($this->layout_obj->loginData());
        $this->template_obj->setVariable($this->layout_obj->loginData());
        $this->template_obj->parse();
        return $this->template_obj->get();
    }

    function showHelp()
    {
        $filename  = COMMON_CACHE_FOLDER.'help/'.SERVER.'.inc';
        $cfilename = COMMON_CACHE_FOLDER.'help/all.inc';
        $this->act = 'error_help';
        if (file_exists($filename)) {
            return file_get_contents($filename);
        }
        if (file_exists($cfilename)) {
            return file_get_contents($cfilename);
        }
        $this->act = 'error_help';
        return;
    }
}
?>
