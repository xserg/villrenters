#!/usr/bin/php -q
<?php
/*////////////////////////////////////////////////////////////////////////////
------------------------------------------------------------------------------
��������� ������ villarenters.com
------------------------------------------------------------------------------
$Id: getVillaFile.php 219 2012-11-15 10:46:15Z xxserg $
////////////////////////////////////////////////////////////////////////////
*/

define('DEBUG', 0);

set_time_limit (7200);

require ('../conf/config.inc');
require_once COMMON_LIB.'DVS/DVS.php';
require_once COMMON_LIB.'DVS/Dynamic.php';

require ('HTTP/Request2.php');
require (PROJECT_ROOT.'/layout/getData.php');


$error = @file_get_contents('../logs/getVillaFile_error.txt');

//$error=1511;

$db_obj = DVS_Dynamic::createDbObj('countries');


if ($error) {
    $db_obj->whereAdd('id>='.$error);
}

$db_obj->orderBy('id');
$db_obj->find();

$data_obj = new GetData;

$start_time = time();

try {
    while ($db_obj->fetch()) {
        //echo $db_obj->id.' '.$db_obj->name."\n";
        $location_id = $db_obj->id;
        $data_obj->initVillaSearch($location_id, $villa_id);
        $data_obj->pageVillaList3();
    }
} catch (Exception $e) {
    print_r($e);
    echo $e->getMessage();
    file_put_contents('../logs/getVillaFile_error.txt', $location_id);
}

$end_time = time();
echo 'get  villas files<br>'.($end_time - $start_time).'c.';

?>
