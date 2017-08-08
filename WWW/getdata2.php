<?php
/*////////////////////////////////////////////////////////////////////////////
------------------------------------------------------------------------------
Получение данных villarenters.com
------------------------------------------------------------------------------
$Id: getdata2.php 70 2011-04-11 07:15:31Z xxserg@gmail.com $
////////////////////////////////////////////////////////////////////////////
*/

define('DEBUG', 0);
set_time_limit (7200);

require ('../conf/config.inc');
require_once COMMON_LIB.'DVS/Dynamic.php';

require_once (PROJECT_ROOT.'/layout/getXML.php');
require_once ('HTTP/Request2.php');


//print_r($db_obj);

//exit;

$db_obj = DVS_Dynamic::createDbObj('countries1');
DB_DataObject::DebugLevel(1);


function showMenu($data_url)
{
    foreach ($data_url as $k => $v) {
        $str .= '<br><a href="?op='.$k.'">'.$k.'</a>';
    }
    echo $str.'<br>';
}

$op = $_GET['op'];


if (isset($_GET['pid'])) {
    $data_url[$op]['params']['ParentID'] = $_GET['pid'];
}

$request_obj = new GetXML;

showMenu($request_obj->data_url);

//exit;

echo '<pre>';
switch ($op) {
    case 'childlocations':
        getRegions(3929);
        break;

    case 'childlocationsV2':
        updateCounters();
        break;

    case 'VillaSearch':
        $body = $request_obj->request($data_url[$op]);
        //echo $body;
        $xml = simplexml_load_string($body);
        //print_r($xml); 
        foreach ($xml->Villas->Villa as $k => $villa) {
            $villa_id = intval($villa->prop_ref);
            $request_obj->insertVilla($villa);
            $data_url['GetPropertyReviews']['params']['prop_ref'] = $villa_id;
            $comments_body = $request_obj->request($data_url['GetPropertyReviews']);
            $comments_xml = simplexml_load_string($comments_body);
            $request_obj->insertComments($villa_id, $comments_xml);
            //exit;
        }
        //insertVilla($xml->Villas->Villa);
        break;
    default:
        echo "<b>$op</b>";
        $xml = $request_obj->requestXMLdata($op);
        //echo $body;
        //$xml = simplexml_load_string($body);
        print_r($xml);
        break;

}


/*
 *
 [ChildLocations] => SimpleXMLElement Object
        (
            [Location] => Array
                (
                    [0] => SimpleXMLElement Object
                        (
                            [LocationRef] => 3923
                            [LocationDescription] => Africa
                            [ParentID] => 0
                        )
 */
function getRegions($pid=0)
{
    //exit;
    global $request_obj, $db_obj;
    static $num;
    $data = array(
                        'url' => 'GetChildLocations',
                        'params' => array('ParentID' => $pid, 'VRF' => '')
                        );
    $body = $request_obj->request($data);
    $xml = simplexml_load_string($body);
    $arr = $xml->ChildLocations->Location;
    //print_r($arr);
    if (sizeof($arr)) {
        foreach ($arr as $k => $region_obj) {
            echo $num.' '.$region_obj->LocationDescription.' '.$region_obj->LocationRef.'<br>';
            $request_obj->insertRegion($region_obj, $db_obj);
            getRegions($region_obj->LocationRef);
            $num++;
            flush();
        }
    }
    //exit;
}



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
            echo $num.' '.$region_obj->LocationDescription.' '.$region_obj->LocationRef.' '.$region_obj->PropCount.'<br>';
            //$request_obj->insertRegion($region_obj, $db_obj);
            //$request_obj->updateCounters(intval($region_obj->LocationRef), intval($region_obj->PropCount));

            $request_obj->updateCounters($region_obj);
            updateCounters(intval($region_obj->LocationRef));
            $num++;
            //flush();
        }
        //exit;
    }
}

?>
