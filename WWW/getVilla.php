<?php
/*////////////////////////////////////////////////////////////////////////////
------------------------------------------------------------------------------
Получение данных villarenters.com
------------------------------------------------------------------------------
$Id: getVilla.php 228 2012-12-05 13:49:52Z xxserg@gmail.com $
////////////////////////////////////////////////////////////////////////////
*/

define('DEBUG', 0);
set_time_limit (7200);

require ('../conf/config.inc');
require_once COMMON_LIB.'DVS/DVS.php';
require_once COMMON_LIB.'DVS/Dynamic.php';

require ('HTTP/Request2.php');
require (PROJECT_ROOT.'/layout/getXML.php');

ini_set('display_errors', 'On');

function showForm()
{
    $str = 'VillaSearch:<br><br><form method=post action="">
            location_id: <input type="text" name="location_id"><br>
            villa_id: <input type="text" name="villa_id"><br>
            page: <input type="text" name="page_num" value=1><br>
            <input type="checkbox" name="demo"> demo<br>
             photo<br>
            <input type="radio" name="photo" value=0 CHECKED>загружать все<br>
            <input type="radio" name="photo" value=1>не загружать фото<br>
            <input type="radio" name="photo" value=2>только фото<br>
            <input type="checkbox" name="count"> count<br>
            <input type="submit" value=">>">
            </form>';
    echo $str.'<br>';
}

$op = 'VillaSearchV2';
//showMenu();

//print_r($_REQUEST);

if (!$_POST && !$_GET) {
    showForm();
    exit;
}


if ($_REQUEST['count']) {
    updateCounters();
    exit;
}

$location_id = DVS::getVar('location_id', 'int', 'request');
$villa_id = DVS::getVar('villa_id', 'int', 'request');
$page = DVS::getVar('page_num', 'int', 'request');

$request_obj = new GetXML;


if ($_REQUEST['photo'] == 2) {
    
    if ($villa_id) {
                echo $villa_id.'<br>';
                 //$images_obj = DVS_Dynamic::createDbObj('images');
                 $request_obj->insertImages($villa_id);
    } else if ($location_id) {
            $villa_obj = DVS_Dynamic::createDbObj('villa');
            //DB_DataObject::DebugLevel(1);
            $countries_obj = DB_DataObject::factory('countries');
            $countries_obj->getParent($location_id);
            $villa_obj->whereAdd('translation_status=0');
            $villa_obj->whereAdd('locations_all LIKE ":'.$countries_obj->locations_all.':%"');
            $villa_obj->orderBy('villarentersindex DESC');
            $villa_obj->find();
            echo $villa_obj->N.'<br>';
            while ($villa_obj->fetch()) {
                echo $i.' '.$villa_obj->id.' '.$villa_obj->title.'<br>';
                 $request_obj->insertImages($villa_obj->id);
                //$villa_obj->preDelete();
               // echo $this->delete();
               $i++;
            }
            echo 'Всего '.$i;
    }

/*
        $img_arr = $request_obj->getImages($villa_id);
        if ( $img_arr) {
            $images_obj = DVS_Dynamic::createDbObj('images');
            DB_DataObject::DebugLevel(1);
            $request_obj->insertImages($villa_id, $img_arr, $images_obj);
        }
*/
    exit;
}


$request_obj->initVillaSearch($location_id, $villa_id);
$start_time = time();
//$i = $request_obj->processVilla($xml, $_POST['photo']);
$i = $request_obj->pageVillaList($_REQUEST['photo'], $_REQUEST['demo'], $page);
$end_time = time();
echo 'get '.$i.' villas<br>'.($end_time - $start_time).'c.';



function updateCounters($pid=0)
{
    $request_obj = new GetXML;
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
            $request_obj->updateCounters(intval($region_obj->LocationRef), intval($region_obj->PropCount));
            updateCounters($region_obj->LocationRef);
            $num++;
            flush();
        }
        //exit;
    }
}

    /*
TRUNCATE `comments` ;

TRUNCATE `descriptions` ;

TRUNCATE `images` ;

TRUNCATE `user_options` ;

TRUNCATE `villa` ;
    */

?>
