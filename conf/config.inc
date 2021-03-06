<?php
/**
 * @package villarenters.ru
 * ------------------------------------------------------------------------------
 * ��������� ������������ �������
 * ------------------------------------------------------------------------------
 * $Id: config.inc 394 2015-04-30 09:41:08Z xxserg $
 */


/**
 * ����� SQL - ��������
 * ����� ���� 1 - 5
 */

//define('TEST_DEBUG', 5);
//define('TEST_CACHE', 1);
//��������� locale

define('LANG', 'ru');
setlocale(LC_ALL, 'ru_RU.CP1251');

define('DB_TYPE', 'mysql');
define('DB_DRIVER', 'MDB2');

define('PROXY_HOST', '');
define('PROXY_PORT', '');
/**
 * ����������� ����� - �� ��������!!
 */
define('HTDOCS_FOLDER', 'WWW/');
define('INC_FOLDER', 'inc/');
define('LIB_FOLDER', 'lib/');
define('CONF_FOLDER', 'conf/');
define('CACHE_FOLDER', 'cache/');
define('BIN_FOLDER', 'bin/');
define('TMPL_FOLDER', 'tmpl/');
define('IMAGE_FOLDER', 'images/');
define('LAYOUT_FOLDER', 'layout/');
define('DINAMIC_FOLDER', 'dynamic/');

/**
 * ���� �������� ��������
 */
define('CONTENT_FOLDER', 'content/');

if (isset($_SERVER['SCRIPT_FILENAME'])) {
    define('PROJECT_ROOT', preg_replace("/[a-z]+\/$/i", '', dirname(realpath($_SERVER['SCRIPT_FILENAME'])).'/'));
} else {
    define('PROJECT_ROOT', '../');
}
define('COMMON_LIB', PROJECT_ROOT.'lib/');

//echo PROJECT_ROOT;
//print_r($_SERVER);
/**
 * ����������� ���� ������� - ��������� ��� �������
 */
//if (preg_match("/Z:/", PROJECT_ROOT) || preg_match("/Z:/",$_SERVER['argv'][0])) {
if (getenv(APP_ENV) == 'DEV') {
//if (ereg("Z:", PROJECT_ROOT) || (isset($_SERVER['argv']) && ereg("Z:",$_SERVER['argv'][0]))) {
    // ��� �������� �������
    /**
     * ��������� ���������� � ����� ������
    */
    define('DB_USER', 'root');
    define('DB_PASS', 'rottar');
    ini_set('include_path', COMMON_LIB.':'.COMMON_LIB.'pear/:.');
    ini_set('display_errors', 'On');

    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    //error_reporting(E_ERROR | E_PARSE);
    //error_reporting(E_ALL);
    define('SERVER',   'villa');
    define('SERVER_URL',   'http://'.SERVER);
    define('SERVER_TYPE',   'local');
    define('DB_HOST',       'localhost');
    /*
    $db = $_GET['db'];
    if ($db == 'r') {
        $dbname = 'rurenter';
    } else {
        $dbname = 'xserg';
    }
    define('DB_NAME', $dbname);
    */
    define('DB_NAME', 'xserg');
    define('DB_NAME_RURENTER', 'xserg_rurenter');
    define('DB_NAME_INTERHOME', 'interhome');
    define('REFRESH_TIME', 0);
    define('IMAGE_URL', '/img/');
    //if ($_SERVER['SERVER_ADDR'] == '195.62.63.10') {
        define('MAIL_ADMIN', 'xxserg@gmail.com');
        define('MAIL_DRIVER', 'mail');
        //define('MAIL_DRIVER', 'smtp');
        define('MAIL_FROM', 'sergfomin@mail.ru');
        define('MAIL_HOST', 'smtp.mail.ru');
        define('MAIL_AUTH', true);
        define('MAIL_USERNAME', 'sergfomin@mail.ru');
        define('MAIL_PASSWORD', '');
        define('GOOGLE_MAPS_API_KEY', '');
        define('GMAP_KEY', 'AIzaSyAbnwDID2N8mO-UV8ciWj8RH76MXj4__Hc');

    //}
} else {
    // ������������ �������� �������
    /**
     * ��������� ���������� � ����� ������
     */
    define('DB_USER', 'xserg');
    define('DB_PASS', 'xserg17');
    ini_set('include_path', COMMON_LIB.':'.COMMON_LIB.'pear:.');
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    ini_set('display_errors', 'Off');
    define('SERVER',   'villarenters.ru');
    define('SERVER_URL',   'http://'.SERVER);
    define('IMAGE_URL', '/img/');
    define('SERVER_TYPE', 'remote');
    define('REFRESH_TIME', 3600);
    define('MAIL_DRIVER', 'mail');
    define('MAIL_ADMIN', 'info@villarenters.ru');
    define('MAIL_FROM', 'info@villarenters.ru');
    define('MAIL_HOST', 'localhost');
    //define('MAIL_AUTH', 'true');
    define('DB_HOST',       'localhost');
    define('DB_NAME', 'xserg');
    define('DB_NAME_RURENTER', 'xserg_rurenter');
    define('DB_NAME_INTERHOME', 'interhome');
    define('GOOGLE_MAPS_API_KEY', '');
    define('GMAP_KEY', 'AIzaSyAbnwDID2N8mO-UV8ciWj8RH76MXj4__Hc');

}

/**
 * ������� �������� ������� DVS
 */
define('DVS_CLASS_PREFIX', 'DVS_');

/**
 * ������� �������� ������� �������
 */
define('DVS_PROJECT_CLASS_PREFIX', 'Project_');

/**
 * dsn
 * ������ ������������ � ��
 */
define('DB_DSN', DB_TYPE.'://'.DB_USER.':'.DB_PASS.'@'.DB_HOST.'/'.DB_NAME);
define('DB_DSN2', DB_TYPE.'://'.DB_USER.':'.DB_PASS.'@'.DB_HOST.'/'.DB_NAME_RURENTER);
define('DB_DSN3', DB_TYPE.'://'.DB_USER.':'.DB_PASS.'@'.DB_HOST.'/'.DB_NAME_INTERHOME);

//define('DB_DSN', DB_TYPE.'://'.DB_USER.':'.DB_PASS.'@'.DB_HOST.'/?service='.DB_NAME);


define("CHARSET", 'cp1251');
define('AUTH_FORM', 'html');
define('DB_DATE_FORMAT', 'Y-m-d H:i');
define('MAX_CONTENT_SIZE', 500*1024*1024);

define('RURENTER_URL', 'http://rurenter.ru/');
//define('RURENTER_URL', 'http://rurenter.villarenters.ru/');
define('VHOME_URL', 'http://vhome.villarenters.ru/');


define('VILLA_IMAGE_URL', '/villa_img/');
//define('VILLARENTERS_IMAGE_URL', 'http://www.rentalsystems.com/data/images/');

define('VILLARENTERS_IMAGE_URL', 'http://clickstay.s3-eu-west-1.amazonaws.com/images/property/');


define('DATA_HOST', 'http://www.villarenters.com/villarenterswebservice/villasearch.asmx/');
define('BOOKING_URL', 'http://www.rentalsystems.com/advert_price_check.asp');
define('VR_ACCOUNT_NUM', '55172A');

define('LETINTHESUN_ID', 54440);
?>
