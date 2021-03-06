#!/usr/bin/php -q
<?php
/*////////////////////////////////////////////////////////////////////////////
------------------------------------------------------------------------------
��������� ������ villarenters.com
------------------------------------------------------------------------------
$Id: getCountries.php 70 2011-04-11 07:15:31Z xxserg@gmail.com $
////////////////////////////////////////////////////////////////////////////
*/

define('DEBUG', 0);
set_time_limit (7200);

require ('../conf/config.inc');

//print_r($_SERVER);
//echo PROJECT_ROOT;
//exit;

require_once COMMON_LIB.'DVS/Dynamic.php';

require_once (PROJECT_ROOT.'/layout/getXML.php');
require_once ('HTTP/Request2.php');

$db_obj = DVS_Dynamic::createDbObj('countries');
$db_obj->disable_sk = true;
DB_DataObject::DebugLevel(1);


$request_obj = new GetXML;

$start_time = time();
echo '<pre>'.date("Y-m-d H:i:s");

//exit;

        updateCounters();
$end_time = time();

echo 'inserted: '.$request_obj->inserted.'<br>updated: '.$request_obj->updated.'<br>'
.($end_time - $start_time).'c.';


function updateCounters($pid=0)
{
    global $request_obj;
    //$request_obj = new GetXML;
    $request_obj->data_url['childlocationsV2']['params']['ParentID'] = $pid;
    $xml = $request_obj->requestXMLdata('childlocationsV2');
    //print_r($xml);
    $arr = $xml->Location;
    //print_r($arr);
    //exit;
    if (sizeof($arr)) {
        foreach ($arr as $k => $region_obj) {
            echo $region_obj->LocationDescription.' '.$region_obj->LocationRef.' '.$region_obj->PropCount."\n";
            $request_obj->updateCounters($region_obj);
            updateCounters(intval($region_obj->LocationRef));
            flush();
        }
        //exit;
    }
}

?>
