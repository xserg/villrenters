<?php
/*////////////////////////////////////////////////////////////////////////////
lib2/DVS
------------------------------------------------------------------------------
����� ���������� ��� �������� 
����� �������� ������� � ��������� ����������
------------------------------------------------------------------------------
$Id: Admin_Office.php 226 2012-11-20 07:45:10Z xxserg@gmail.com $
////////////////////////////////////////////////////////////////////////////
*/
require_once COMMON_LIB.'DVS/DVS.php';
require_once COMMON_LIB.'DVS/Page.php';
require_once COMMON_LIB.'pear/DB.php';


class DVS_Admin_Office
{
    /* ������ �������� */
    var $page_obj;

    /* ������ ����������� */
    var $auth_obj;

    /* ��������� */
    var $iface;

    function DVS_Admin_Office($iface)
    {
        require_once 'PEAR.php';
        PEAR::setErrorHandling(PEAR_ERROR_CALLBACK, array('DVS_Page', "showError"));

        //$session = new SessionManager('mysql://'.DB_USER.':'.DB_PASS.'@'.DB_HOST.'/'.DB_NAME); 

        $this->iface = $iface;

        /* �������� ������ ����������� */
        require_once COMMON_LIB.'DVS/Auth.php';
        $this->auth_obj = DVS_Auth::factory($this->iface);
        
        /* ���������� ������������ */
        $return_auth = $this->auth_obj->dvsauth();
        //print_r($this->auth_obj);
        /* ����� ������ */
        if ($return_auth !== true) {
            $this->iface = 'i';
            $_GET['op'] = 'static';
            $_GET['act'] = $return_auth;
            @session_destroy();
            //header('Location: /?op=static&act='.$return_auth);
            //header('Location: /'.$return_auth.'.html');
            //exit;
        }
        
    }

    /* �������� ������� ��� ������ �������� */
    function showPage()
    {
        if (isset($_GET['logout'])) {
            //$this->auth_obj->destroyOnline();
            $this->auth_obj->logout();
            @session_destroy();
            //setcookie('username', '', time() + COOKIE_TIME, '/', COOKIE_DOMAIN, COOKIE_SECURE);
            header('Location: /');
            exit;
        }
        /* �������������� ������ �������� */
        $op = '';
        $act = '';
        if (isset($_GET['op'])) {
            $op = $_GET['op'];
        }
        if (isset($_GET['act'])) {
            $act = $_GET['act'];
        }
        $this->page_obj = DVS_Page::factory($op, $act, $this->iface);
        if (isset($this->auth_obj->msg)) {
            $this->page_obj->msg = $this->auth_obj->msg;
        }
        return $this->page_obj->showPage();
    }
}
?>
