<?php
/*////////////////////////////////////////////////////////////////////////////
lib2/DVS
------------------------------------------------------------------------------
����� ���������� ��� �������� AUTO.RU
����� ����������� ������������ � ���������� office.php
------------------------------------------------------------------------------
$Id: Auth_User.php 70 2011-04-11 07:15:31Z xxserg@gmail.com $
////////////////////////////////////////////////////////////////////////////*/

require_once COMMON_LIB.'DVS/Auth.php';

class DVS_Auth_User extends DVS_Auth
{

    function DVS_Auth_User()
    {
        $auth_options = array(
           'table'         => 'users',
           'usernamecol'   => 'username',
           'passwordcol'   => 'password',
           'db_fields'     => 'id, last_ip, status',
           'dsn'           => 'mysql://'.DB_USER.':'.DB_PASS.'@'.DB_HOST.'/'.DB_NAME,
           'cryptType'     => 'none'
        );

        $this->Auth('DB', $auth_options);
    }

    //����������� ������������
    function dvsauth()
    {

        if (!$this->authpw()) {
            return 'error_login';
        }

        if ($_SESSION['_authsession']['data']['status'] != 1) {
            $this->msg = DVS_ERROR_ACTIVATE;
            return 'error_login';
        }
        /*
        if (strtotime($_SESSION['_authsession']['data']['pay_expire']) < time()) {
            return 'error_payed';
        }
        */
        //echo '<pre>';
        //print_r($_SESSION);
        /*
        //�������������� �������� ��� �����������, ������ ���� ������� ������
        // auth_user() � DBO_..., � �������� �������� ��������� � $auth_arr ������������ � Project_Layout
        include_once PROJECT_ROOT.LAYOUT_FOLDER.'Layout.php';
        if (!class_exists('Project_Layout')) {
                return PEAR::raiseError('Unable to find Project_Layout  class');
        } else {
            $project_obj = & new Project_Layout;
        }
        if ($project_obj->auth_arr) {            
            //if ($this->storage->db && $_SESSION['_authsession']['data']['id']) {
           if ($_SESSION['_authsession']['data']['id']) {
                require_once PROJECT_ROOT.'conf/dbo_conf.inc';
                require_once 'DB/DataObject.php';
                foreach ($project_obj->auth_arr as $auth_op) {
                    $auth_obj = DB_DataObject::factory($auth_op);
                    if (!method_exists($auth_obj, 'auth_user')) {
                        return PEAR::raiseError('Unable to find auth_user() method');
                    } else {
                        $auth_res = $auth_obj->auth_user();
                    }
                    if ($auth_res == 'true') {
                        break;
                    } else {
                        @session_destroy();
                        return 'error_login';
                        break;
                    }
                }
            }
        }
        */
        return true;
    }

}
?>
