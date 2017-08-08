<?php
/**
 * Videoradar
 * Frontend
 * $Id: index.php 311 2013-11-08 14:39:09Z xxserg $
 */


require_once '../conf/config.inc';
require_once COMMON_LIB.'DVS/DVS.php';
require_once PROJECT_ROOT.'layout/Cache.php';

require_once PROJECT_ROOT.'layout/mobir.php';


$iface = 'i';
if(preg_match('/^m/', $_SERVER['HTTP_HOST'])) {
    //echo 'm';
    $iface = 'm';
}

try {
    $page_obj = new Project_Cache;
    echo $page_obj->showCachedPage($iface);
} catch (Exception $e) {
            echo $e->getMessage();
        }
?>
