#!/usr/bin/php -q
<?php
require ('../conf/config.inc');
require_once COMMON_LIB.'DVS/DVS.php';
require_once COMMON_LIB.'DVS/Dynamic.php';

require_once (PROJECT_ROOT.'/layout/getXML.php');

set_time_limit (7200);

$dir = PROJECT_ROOT.'data/'.date('Ymd');
//$dir = PROJECT_ROOT.'data/20110623';

$log = '../logs/parse.txt';

$files_arr = getXML::getFilesArray($dir);

$log_str = file_get_contents($log);
preg_match_all("/([0-9_]+.txt)/", $log_str, $match);
$parsed_arr = $match[1];

//exit;


$request_obj = new GetXML;
require_once 'DB/DataObject.php';

        $db_options = &PEAR::getStaticProperty('DB_DataObject','options');
        $db_options = array(
            'database'                 => DB_DSN_XSERG2,
            'database_rurenter'        => DB_DSN2,
            'schema_location'          => PROJECT_ROOT.'conf',
            'class_location'           => PROJECT_ROOT.'DataObjects/',
            'table_users'              => 'rurenter',
            'table_booking_log'        => 'rurenter',
            'table_guests'             => 'rurenter',
            'require_prefix'           => '',
            'class_prefix'             => 'DBO_',
            'db_driver'                => DB_DRIVER,
            //'quote_identifiers'         => true

        );


//$db_obj = DVS_Dynamic::createDbObj('villa');
$db_obj = DB_DataObject::factory('villa');

foreach ($files_arr as $k => $file) {
    if (in_array($file, $parsed_arr)) {
        continue;
    }
    $i = 1;
    $str = file_get_contents($dir.'/'.$file);
    $xml = simplexml_load_string($str);
    foreach ($xml->Villas->Villa as $k => $villa) {
        $id = (int)$villa->prop_ref;
        //echo $i.' '.$id.' '.$villa->Title.'<br>';
        $db_obj->query("SELECT id FROM villa WHERE id=".$id);
        $db_obj->fetch();
        if ($db_obj->N == 0) {
            $request_obj->insertVilla($villa, 0, $db_obj);
        }
        $i++;
    }
    echo $file.' '.$i."\n";
    file_put_contents($log, $file.' '.$i."\n", FILE_APPEND);
}












?>
