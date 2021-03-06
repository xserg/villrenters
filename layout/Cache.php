<?php
/**
 * @package web2matrix
 * ------------------------------------------------------------------------------
 * ����� ���������� ����� �������
 * ------------------------------------------------------------------------------
 * $Id: Cache.php 379 2015-02-12 08:03:15Z xxserg $
 */
define('COOKIE_TIME', 3600*24*365);
define('COOKIE_DOMAIN', '');
define('COOKIE_SECURE', '');

require_once COMMON_LIB.'DVS/Cache.php';

class Project_Cache extends DVS_Cache
{
    public $cached_pages = array();

    function Project_Cache($get = null)
    {
        $this->get = $get ? $get : $_GET;

        if (empty($this->get)) {
            $this->get['op'] = 'countries';
            $this->get['act'] = 'index';
            //$cache_id = 'index';
        }
        foreach ($this->get as $k => $v) {
            if ($k == 'op' || $k == 'act') {
                continue;
            } else {
                $cache_id .= '_'.$k.'_'.$v;
            }
        }

        $this->cached_pages['countries']['index'] = array(
                            'cacheDir'           => PROJECT_ROOT.CACHE_FOLDER,
                            //'lifeTime'           => 1,
                            'lifeTime'           => REFRESH_TIME,
                            'fileNameProtection' => 0,
                            'cache_id'           => 'index',
                            'cache_group'        => 'countries',
                            );
        $this->cached_pages['villa']['show'] = array(
                            'cacheDir'           => PROJECT_ROOT.CACHE_FOLDER.'villa/',
                            'lifeTime'           => REFRESH_TIME,
                            'fileNameProtection' => 0,
                            'cache_id'           => $cache_id,
                            'cache_group'        => 'villa',
                            );

// ��������� �������������
        $max_recent = 3;
        if ($this->get['op'] == 'villa' && $this->get['act'] == 'show2') {
            if ($recent_arr = $_COOKIE['villa_id']) {
                $size = sizeof($recent_arr);
                if (sizeof($recent_arr) > $max_recent) {
                   arsort($recent_arr);
                   $recent_arr = array_slice($recent_arr, $max_recent, $size, true);
                   foreach ($recent_arr as $k => $v) {
                        setcookie('villa_id['.$k.']', '', 0, '/', COOKIE_DOMAIN, COOKIE_SECURE);
                   }
                   //echo 'del';
                }
            }
            //setcookie('villa_id[]', '', time() - COOKIE_TIME, '/', COOKIE_DOMAIN, COOKIE_SECURE);
            setcookie('villa_id['.$_GET['id'].']', time(), time() + COOKIE_TIME, '/', COOKIE_DOMAIN, COOKIE_SECURE);
            //print_r($_COOKIE);
        }


        $this->cached_pages['villa']['index'] = array(
                            'cacheDir'           => PROJECT_ROOT.CACHE_FOLDER.'villa_index/',
                            'lifeTime'           => REFRESH_TIME,
                            'fileNameProtection' => 1,
                            'cache_id'           => $cache_id,
                            'cache_group'        => 'villa',
                            );
        

        $this->DVS_Cache($this->get);
        if (!empty($_COOKIE['PHPSESSID']) || !empty($_COOKIE['username'])) {
            //$this->_caching = false;
        }
        if ($_POST) {
            $this->_caching = false;
        }

        if(preg_match('/^m/', $_SERVER['HTTP_HOST'])) {
            $this->_caching = false;
        }


    }
}
?>
