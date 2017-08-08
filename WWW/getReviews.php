<?php
/*////////////////////////////////////////////////////////////////////////////
------------------------------------------------------------------------------
Получение данных villarenters.com
------------------------------------------------------------------------------
$Id: getVilla.php 87 2011-06-15 10:03:44Z xxserg@gmail.com $
////////////////////////////////////////////////////////////////////////////
*/

define('DEBUG', 0);
set_time_limit (7200);

require ('../conf/config.inc');
require_once COMMON_LIB.'DVS/DVS.php';
require_once COMMON_LIB.'DVS/Dynamic.php';

require ('HTTP/Request2.php');
require (PROJECT_ROOT.'/layout/getXML.php');

require_once ('./gtranslate/translate2.php');

ini_set('display_errors', 'On');
$log = '../logs/getReviews.txt';

function showForm()
{
    $str = 'VillaSearch:<br><br><form method=post action="">
            location_id: <input type="text" name="location_id"><br>
            villa_id: <input type="text" name="villa_id"><br>
            <input type="submit" value=">>">
            </form>';
    echo $str.'<br>';
}

$op = 'VillaSearch';
//showMenu();

//print_r($_REQUEST);

if (!$_POST && !$_GET) {
    showForm();
    exit;
}

$location_id = DVS::getVar('location_id', 'int', 'request');
$villa_id = DVS::getVar('villa_id', 'int', 'request');

$request_obj = new GetXML;

$start_time = time();
    if ($villa_id) {
                echo $villa_id.'<br>';
                 //$images_obj = DVS_Dynamic::createDbObj('images');
    } else if ($location_id) {
        $done_arr = file($log, FILE_IGNORE_NEW_LINES);
            $villa_obj = DVS_Dynamic::createDbObj('villa');
            //DB_DataObject::DebugLevel(1);
            $countries_obj = DB_DataObject::factory('countries');
            $countries_obj->getParent($location_id);
            //$villa_obj->whereAdd('translation_status=0');
            $villa_obj->whereAdd('locations_all LIKE ":'.$countries_obj->locations_all.':%"');
            $villa_obj->orderBy('villarentersindex DESC');
            $villa_obj->find();
            echo $villa_obj->N.'<br>';
            while ($villa_obj->fetch()) {
                $villa_id = $villa_obj->id;
                if (in_array($villa_id, $done_arr)) {
                    continue;
                }
                echo $i.' '.$villa_obj->id.' '.$villa_obj->title.'<br>';
                $request_obj->data_url['GetPropertyReviews']['params']['prop_ref'] = $villa_id;
                $comments_xml = $request_obj->requestXMLdata('GetPropertyReviews');
                //print_r($comments_xml);
                $request_obj->insertComments($villa_id, $comments_xml);

               //$request_obj->insertImages($villa_obj->id);
               //$villa_obj->preDelete();
               // echo $this->delete();
               $i++;
                   file_put_contents($log, $villa_id."\n", FILE_APPEND);
            }
            echo 'Всего '.$i;
    }


$end_time = time();
echo 'inserted: '.$i.'<br>'
.($end_time - $start_time).'c.';

?>
