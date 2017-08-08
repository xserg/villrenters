<?php
/*////////////////////////////////////////////////////////////////////////////
------------------------------------------------------------------------------
Получение данных villarenters.com
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


//print_r($db_obj);

//exit;

$db_obj = DVS_Dynamic::createDbObj('countries');
DB_DataObject::DebugLevel(1);


function showMenu()
{
    
        $str .= '<br><a href="?op=translate">Перевод</a>';
        $str .= '<br><a href="?op=update">Обновить страны</a>';
        $str .= '<br><a href="?op=delete">Удалить страны</a>';

        echo $str.'<br>';
}


$op = $_GET['op'];


if (isset($_GET['pid'])) {
    $data_url[$op]['params']['ParentID'] = $_GET['pid'];
}

$request_obj = new GetXML;

showMenu();

//exit;
$start_time = time();
echo '<pre>'.date("Y-m-d H:i:s");

switch ($op) {
    case 'translate':
        $n = translateCountries();
        echo $n.' updated';
        break;

    case 'update':
        updateCounters();
        break;
}

$end_time = time();
echo 'inserted: '.$request_obj->inserted.'<br>updated: '.$request_obj->updated.'<br>'
.($end_time - $start_time).'c.';

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
    print_r($arr);
    //exit;
    if (sizeof($arr)) {
        foreach ($arr as $k => $region_obj) {
            echo $region_obj->LocationDescription.' '.$region_obj->LocationRef.' '.$region_obj->PropCount.'<br>';
            //$request_obj->insertRegion($region_obj, $db_obj);
            //$request_obj->updateCounters(intval($region_obj->LocationRef), intval($region_obj->PropCount));

            //$request_obj->updateCounters($region_obj);
            updateCounters(intval($region_obj->LocationRef));
            flush();
        }
        exit;
    }
}


function translateCountries()
{
    $db_obj = DVS_Dynamic::createDbObj('countries_rus');
    $db_obj->whereAdd("name != rus_name");
    $db_obj->orderBy("name");
    $db_obj->find();
    
    while ($db_obj->fetch()) {
        $countries_obj = DVS_Dynamic::createDbObj('countries');
        $countries_obj->get($db_obj->id);
        //$countries_obj->get('name', $db_obj->name);
        if (!$countries_obj->id) {
            //echo $countries_obj->.'<br>';
            echo $db_obj->name.' '.$db_obj->rus_name."<br>";
            //$countries_obj->get($db_obj->id);
            //print_r($countries_obj->toArray());
        } else {
            $countries_obj->rus_name = $db_obj->rus_name;
            $countries_obj->update();
            $i++;
        }
    }
    return $i;
}


?>
