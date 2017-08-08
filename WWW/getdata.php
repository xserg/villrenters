<?php
/*////////////////////////////////////////////////////////////////////////////
------------------------------------------------------------------------------
Получение данных villarenters.com
------------------------------------------------------------------------------
$Id: getdata.php 70 2011-04-11 07:15:31Z xxserg@gmail.com $
////////////////////////////////////////////////////////////////////////////
*/

define('DEBUG', 0);

define('DATA_HOST', 'http://www.villarenters.com/villarenterswebservice/villasearch.asmx/');

$data_url = array(
    'countries' => array(
                    'url' => 'GetCountryList',
                    'params' => array('country_ref' => 0, 'VRF' => '')
                    ),
                    
    'childlocations' => array(
                    'url' => 'GetChildLocations',
                    'params' => array('ParentID' => 0, 'VRF' => '')
                    ),
    /* Возвращает еще и количество вил */
    'childlocationsV2' => array(
                    'url' => 'GetChildLocationsV2',
                    'params' => array('ParentID' => 0, 'VRF' => '')
                    ),
    'VastSearch' => array(
                    'url' => 'VastSearch',
                    'params' => array()
                    ),
    'VillaSearch' => array(
                    'url' => 'VillaSearch',
                    'params' => array(
                        'Rag' => '',
                        'strOwnerRefs' => '',
                        'strPropRefs' => '',
                        'strLocationRefs' => '105',
                        'intMaxPrice' => '0',
                        'intMinPrice' => '0',
                        'intSleeps' => '0',
                        'blnInstantBooking' => 'false',
                        'intVillarentersIndex' => '0',
                        'intDiscountType' => '0',
                        'intBranding' => '0',
                        'intPage' => '1',
                        'intItemsPerPage' => '100',
                        'blnEnableAvailabilitySearch' => 'false',
                        'strFromYYYYMMDD' => '',
                        'strToYYYYMMDD' => '',
                        'intSortOrder' => '0',
                    )),
    'GetPropertyAvailability' => array(
                    'url' => 'GetPropertyAvailability',
                    'params' => array('prop_ref' => '19931','VRF' => '')
                    ),
    'GetPropertyReviews' => array(
                    'url' => 'GetPropertyReviews',
                    'params' => array('prop_ref' => '19931','VRF' => '')
                    ),

);

require ('../conf/config.inc');
require_once COMMON_LIB.'DVS/Dynamic.php';

require (PROJECT_ROOT.'/layout/getXML.php');
require ('HTTP/Request2.php');



$db_obj = DVS_Dynamic::createDbObj('countries');

DB_DataObject::DebugLevel(1);
//print_r($db_obj);

//exit;

function showMenu()
{
    global $data_url;
    foreach ($data_url as $k => $v) {
        $str .= '<br><a href="?op='.$k.'">'.$k.'</a>';
    }
    echo $str.'<br>';
}

$op = $_GET['op'];
showMenu();

if (empty($op)) {
    exit;
} else {
    //echo "<b>$op</b>";
}




if (isset($_GET['pid'])) {
    $data_url[$op]['params']['ParentID'] = $_GET['pid'];
}

$request_obj = new GetXML;


//$body = $request_obj->request($data_url[$op]);


//.$body;

//$xml = simplexml_load_string($body);
//print_r($xml);

//$request_obj->getCountries($xml);

echo '<pre>';
switch ($op) {
    case 'childlocations':
        getRegions();
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
        $body = $request_obj->request($data_url[$op]);
        //echo $body;
        $xml = simplexml_load_string($body);
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
    exit;
    global $request_obj, $num, $db_obj;
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



/*
function updateCounters2($pid=0)
{
    global $request_obj, $num, $db_obj;
    $data = array(
                        'url' => 'GetChildLocationsV2',
                        'params' => array('ParentID' => $pid, 'VRF' => '')
                        );
    $body = $request_obj->request($data);
    $xml = simplexml_load_string($body);
    //print_r($xml);

    

    $arr = $xml->Location;
    //print_r($arr);
    if (sizeof($arr)) {
        foreach ($arr as $k => $region_obj) {
            echo $num.' '.$region_obj->LocationDescription.' '.$region_obj->LocationRef.' '.$region_obj->PropCount.'<br>';
            
            //$request_obj->insertRegion($region_obj, $db_obj);
            $request_obj->updateCounters($region_obj);
            updateCounters($region_obj->LocationRef);
            $num++;
            flush();
        }
        //exit;
    }
}
*/

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
            //$request_obj->updateCounters(intval($region_obj->LocationRef), intval($region_obj->PropCount));

            $request_obj->updateCounters($region_obj);
            //updateCounters($region_obj->LocationRef);
            $num++;
            flush();
        }
        //exit;
    }
}

/*
$p = xml_parser_create();
xml_parse_into_struct($p, $body, $vals, $index);
xml_parser_free($p);
//echo "Index array\n";
//print_r($index);
echo "\nVals array\n";
print_r($vals);
*/
//print_r($request_obj->response);

?>
