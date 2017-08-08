<?php
/*////////////////////////////////////////////////////////////////////////////
lib2/DVS
------------------------------------------------------------------------------
Среда разработки веб проектов AUTO.RU
Класс авторизации пользователя в интерфейсе admin.php
------------------------------------------------------------------------------
$Id: Auth_Admin.php 192 2012-09-24 05:18:41Z xxserg $
//////////////////////////////////////////////////////////////////////////// */

require_once COMMON_LIB.'DVS/Auth.php';
require_once 'DB.php';

class DVS_Auth_Admin extends DVS_Auth
{
/*
    function checkRole()
    {
        if ($_SESSION['_authsession']['data']['id']) {
            $dsn = 'mysql://'.DB_USER.':'.DB_PASS.'@'.DB_HOST.'/'.DB_ADMINS_NAME;
            $db =& DB::connect($dsn);
            if (DB::isError($db)) {
                return PEAR::raiseError($db->getMessage());
            }
            $db->setFetchMode(DB_FETCHMODE_ASSOC);
            $admin = $db->getRow("SELECT * FROM admins WHERE user_id = ".$_SESSION['_authsession']['data']['id']
                ." AND (server = '".SERVER."' OR role = 1)");
            //print_r($admin);
            if ($admin) {
                $_SESSION['_authsession']['data']['role'] = $admin['role'];
                return true;
            } else {
                return false;
            }
        }
    }
*/

    function checkStatus()
    {
        if ($_SESSION['_authsession']['data']['role_id'] == 'oc' || $_SESSION['_authsession']['data']['role_id'] == 'ou') {
            require_once COMMON_LIB.'DVS/Dynamic.php';
            $users_obj = DVS_Dynamic::createDbObj('users');
            $users_obj->get($_SESSION['_authsession']['data']['id']);
            if ($users_obj->status_id == 2) {
                $_SESSION['_authsession']['data']['user_id'] = $users_obj->id;
                if (method_exists($users_obj, 'checkAuth')) {
                    $users_obj->checkAuth();
                }
                return true;
            }
            unset($_SESSION['_authsession']['data']['role_id']);
            return false;
        }
    }

    function checkRole()
    {
        //return true;
        if ($_SESSION['_authsession']['data']['role_id'] == 'aa' || $_SESSION['_authsession']['data']['role_id'] == 'ar') {
            return true;
        } else {
            //return true;
            return $this->checkStatus();
            //return false;
        }
    }

    //Авторизация
    function dvsauth()
    {
        //Проверка пароля
        if (!$this->authpw()) {
            //DVS::dump($this);
            //return false;
            //$this->msg = DVS_ERROR_LOGIN;
            return 'error_login';
        }
        //Проверка роли администратора
        if (!$this->checkRole()) {
            $this->msg = 'ERROR_STATUS';
            return 'error_login';
        }
        //print_r($_SESSION);
        return true;
    }
}
?>
