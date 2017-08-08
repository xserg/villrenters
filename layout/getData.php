<?php
/**
 * @package villarenters.ru
 * @description Запрос и получение данных Villarenters.com
 */

define('DATA_HOST', 'http://www.villarenters.com/villarenterswebservice/villasearch.asmx/');

require_once (PROJECT_ROOT.'/layout/getHTTP.php');
/*
define('PROXY_HOST', '212.248.26.65');
define('PROXY_PORT', '3128');

define('PROXY_HOST', '');
define('PROXY_PORT', '');
*/

/**
 * 
 */
class GetData
{

    public $data_url = array(
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
                                                    'strLocationRefs' => 0,
                                                    'intMaxPrice' => '0',
                                                    'intMinPrice' => '0',
                                                    'intSleeps' => '0',
                                                    'blnInstantBooking' => 'false',
                                                    'intVillarentersIndex' => '0',
                                                    'intDiscountType' => '0',
                                                    'intBranding' => '0',
                                                    'intPage' => '1',
                                                    'intItemsPerPage' => '500',
                                                    'blnEnableAvailabilitySearch' => 'false',
                                                    'strFromYYYYMMDD' => '',
                                                    'strToYYYYMMDD' => '',
                                                    'intSortOrder' => '0',
                                                )),

                                'VillaSearchV2' => array(
                                                'url' => 'VillaSearchV2',
                                                'params' => array(
                                                    'Rag' => '',
                                                    'strOwnerRefs' => '',
                                                    'strPropRefs' => '',
                                                    'intPropType' => 0,
                                                    'strLocationRefs' => 0,
                                                    'intMaxPrice' => '0',
                                                    'intMinPrice' => '0',
                                                    'intSleeps' => '0',
                                                    'blnInstantBooking' => 'false',
                                                    'intVillarentersIndex' => 0,
                                                    'intDiscountType' => 0,
                                                    'intBranding' => 0,
                                                    'intPage' => 0,
                                                    'intItemsPerPage' => '200',
                                                    'blnEnableAvailabilitySearch' => 'false',
                                                    'strFromYYYYMMDD' => '',
                                                    'strToYYYYMMDD' => '',
                                                    'intSortOrder' => 0,
                                                    'VRF' => '',
                                                )),

                                'GetPropertyAvailability' => array(
                                                'url' => 'GetPropertyAvailability',
                                                'params' => array('prop_ref' => 0,'VRF' => '')
                                                ),
                                'GetPropertyReviews' => array(
                                                'url' => 'GetPropertyReviews',
                                                'params' => array('prop_ref' => 0,'VRF' => '')
                                                ),
                                'GetPropertyImages' => array(
                                                'url' => 'GetPropertyImages',
                                                'params' => array('intPropRef' => 0,'blnGetThumbnails' => 'false')
                                                ),
                                'Search' => array(
                                                'host' => 'http://www.villarenters.com',
                                                'url' => 'rent-villas',
                                                'method' => 'post',
                                                'params' => array()
                                                ),
                            );



    public function requestXMLdata($op)
    {
        $this->req = new GetHTTP;
        //return simplexml_load_string($this->request($this->data_url[$op]));
        $body = $this->req->request($this->data_url[$op]);
        //echo $body;
        if (!$body) {
            echo "No body";
            return false;
        }
        if (preg_match('/&#x/', $body)) {
             $body = str_replace('&#x', '', $body );
        }
        $xml = simplexml_load_string($body);
        if (DEBUG) {
           //print_r($xml);
        }
        return $xml;
    }

    public function requestData($op, $host='')
    {
        if (!isset($this->req)) {
            $this->req = new GetHTTP;
        }
        $body = $this->req->request($this->data_url[$op]);
        //echo $body;
        if (!$body) {
            echo "No body";
            return false;
        }
        /*
        if (preg_match('/&#x/', $body)) {
             $body = str_replace('&#x', '', $body );
        }
        */
        if (DEBUG == 1) {
           echo $body;
        }
        return $body;
    }

    
    /**
     * Read directory content
     *
     * @param string $dir
     * @return string
     */
    public static function getFiles($dir)
    {
        if ($handle = opendir($dir)) {
            while (false !== ($file = readdir($handle))) { 
                if ($file != "." && $file != "..") { 
                    $str .= "<a href=?file=$file>$file</a><br>"; 
                } 
            }
            closedir($handle); 
            return $str;
        }
    }

    function getImages($villa_id)
    {
        $this->data_url['GetPropertyImages']['params']['intPropRef'] = $villa_id;
        $xml = $this->requestXMLdata('GetPropertyImages');
        if (is_object($xml->villaimage)) {
            $i = 0;
            foreach ($xml->villaimage as $k => $a) {
                foreach($a->attributes() as $name => $val) {
                    if ($name == 'url') {
                        $a->ImageURL = strval($val);
                    }
                    if ($name == 'label') {
                        $a->ImageCaption = strval($val);
                    }
                }
                $img_arr[$i] = $a;
                $i++;
            }
            return $img_arr;
        }
    }



    function formatDate($str)
    {
        $arr = explode('/', $str);
        return $arr[2].'-'.$arr[1].'-'.$arr[0];
    }


    function initVillaSearch($loacation_id, $villa_id)
    {
        if ($loacation_id) {
            $this->data_url['VillaSearch']['params']['strLocationRefs'] = $loacation_id;
            $this->data_url['VillaSearchV2']['params']['strLocationRefs'] = $loacation_id;
            echo $loacation_id."\n";
        } else {
            $this->data_url['VillaSearch']['params']['strPropRefs'] = $villa_id;
            $this->data_url['VillaSearchV2']['params']['strPropRefs'] = $villa_id;
        }
    }

    function pageVillaList()
    {
        $dir = PROJECT_ROOT.'data/'.date('Ymd');
        @mkdir($dir);
        $num=1;
        $n = 0;
        //$this->data_url['VillaSearch']['params']['Rag'] = VR_ACCOUNT_NUM;
        $this->data_url['VillaSearch']['params']['intPage'] = 1;
        $body = $this->requestData('VillaSearch');
        //echo $body;
        //return;
        while (strlen($body) > 1024) {
            file_put_contents($dir.'/'.$this->data_url['VillaSearch']['params']['strLocationRefs'].'_'.$this->data_url['VillaSearch']['params']['intPage'].'.txt', $body);
            //set_time_limit (600);
            $this->data_url['VillaSearch']['params']['intPage']++;
            $body = $this->requestData('VillaSearch');
            //echo '<b>next page: '.$this->data_url['VillaSearch']['params']['intPage'].'</b><br>';
        }
        return;
    }

    function pageVillaList2()
    {
        $dir = PROJECT_ROOT.'data/'.date('Ymd');
        @mkdir($dir);
        $num=1;
        $n = 0;
        //$this->data_url['VillaSearch']['params']['Rag'] = VR_ACCOUNT_NUM;
        $this->data_url['VillaSearchV2']['params']['intPage'] = 2;
        $body = $this->requestData('VillaSearchV2');
        preg_match ("/<NumberOfRecords>(\d+)<\/NumberOfRecords>/", $body, $match);
        $num_records = $match[1];
        //echo $num_records;
        //echo $body;
        if ($num_records) {
            file_put_contents($dir.'/'.$this->data_url['VillaSearchV2']['params']['strLocationRefs'].'.V2.txt', $body);
        }
        return $num_records;
    }

    function pageVillaList3()
    {
        $dir = PROJECT_ROOT.'data/'.date('Ymd');
        @mkdir($dir);
        $num=1;
        $n = 0;
        //$this->data_url['VillaSearch']['params']['Rag'] = VR_ACCOUNT_NUM;
        $this->data_url['VillaSearchV2']['params']['intPage'] = 1;
        $body = $this->requestData('VillaSearchV2');
        /*
        preg_match ("/<NumberOfRecords>(\d+)<\/NumberOfRecords>/", $body, $match);
        $num_records = $match[1];
        //echo $num_records;
        //echo $body;
        if ($num_records) {
            file_put_contents($dir.'/'.$this->data_url['VillaSearchV2']['params']['strLocationRefs'].'.txt', $body);
        }
        */
        while (strlen($body) > 1024) {
            file_put_contents($dir.'/'.$this->data_url['VillaSearchV2']['params']['strLocationRefs'].'_'.$this->data_url['VillaSearchV2']['params']['intPage'].'.txt', $body);

            $this->data_url['VillaSearchV2']['params']['intPage']++;
            $body = $this->requestData('VillaSearchV2');
            echo '<b>next page: '.$this->data_url['VillaSearchV2']['params']['intPage'].'</b><br>';
        }
        //echo $body;
        return $num_records;
    }

    function getPage()
    {

    }


    function processVilla($xml, $num)
    {
        file_put_contents(PROJECT_ROOT.'data/data'.$num.'.txt', $xml);
    }

    function getBooking($villa_id)
    {
        $this->data_url['GetPropertyAvailability']['params']['prop_ref'] = $villa_id;
        return $this->requestData('GetPropertyAvailability');
    }

    function getAllBooking()
    {
        $db_obj = DVS_Dynamic::createDbObj('villa');
        $db_obj->orderBy('id');
        $db_obj->limit(0, 200);
        $db_obj->find();
        while ($db_obj->fetch()) {
            echo $db_obj->id.' '.$db_obj->title.'<br>';
            $str .= $this->getBooking($db_obj->id);
        }
        file_put_contents(PROJECT_ROOT.'data/booking2.txt', $str);
        return;
    }

/*
    [1] => Title
    [3] => Summary
    [4] => Region_id
    [5] => Bedroom
    [6] => Sleeps
    [7] => Bathroom
    [8] => Type (trim)
    [9] => Summary foto
    [10] => Description foto
*/
    function parseVilla($str, $file)
    {

        /**
        1 Lat
        2 Lon
        3 img
        4 location
        5 title
        6 summury
        7 reviews
        8 index
        9 sleeps
        10 price GBP
        */


        $villa_tpl = '!Lat: ([0-9.-]+), Lon: ([0-9.-]+).*?TitleLabel"[^<]{0,}>([^<]+)<.*?PropertyTypeLabel">([^<]+)<.*?ReviewCountLabel" style="color:#D74B14;">\(([0-9]{0,})\)<.*?VRIndexLabel">(\d+)<.*?SleepsLabel">(\d+)\+?<.*?FromPriceLabel">([^<]+)<.*?Para1TitleLabel">(.*?)</div>!s';

        /**
        1 Lat
        2 Lon
        3 sleeps
        4 title
        5 location
        6 reviews
        7 index
        8 summury
        9 price GBP
        10 descr title
        11 descr
        12 type


        3 img
        */


        $villa_tpl = '!Lat: ([0-9.-]+), Lon: ([0-9.-]+).*?sleeps-number">\s+(\d+)\s.*?advert-title">\s+([^<]{0,})<.*?"advert-breadcrumb">(.*?)</div>.*?(\d+) reviews<.*?index-value">\s+(\d+).*?advert-summary-text">([^<]+)<.*?minprice-value">\s+([^<]{0,})<.*?TitleLabel"[^<]{0,}>([^<]+)<.*?advert-overview-text">(.*?)</p.*?PropertyTypeLabel">([^<]+)<!s';



        $photo_tpl = '/photo-container">\s+<img src="([^"]+)" alt="([^"]{0,})"/';

/*
            <a href="/rent-villas/united-arab-emirates/">United Arab Emirates</a>
/
<a href="/rent-villas/united-arab-emirates/dubai/">Dubai</a>
/
<a href="/rent-villas/united-arab-emirates/the-palm-island-jumeirah/">The Palm Island Jumeirah</a>
*/

        $region_id_tpl = '!<a href="([^"]+)">([^<]+)</a>!';


        //initialLon=55.149425&initialLat=25.108392&initialZoom=11
        $map_tpl = '/initialLon=([0-9.]+)&initialLat=([0-9.]+)&initialZoom=(\d+)/';

        
        $notes_tpl = '/class="doubleColumn notes">([^<]+)</';
        $extra_tpl = '/id="propertyDetailsContent">([\s\S]+?)<\/div>/s';
        $rate_tpl = '!class="period">([^<]+)</span>\s+(<span class="currencyCode">\(([^<]+)\)</span>\s+)?<span class="rate">([^\d]+)([0-9,]+)( -\s+([^\d]+)([0-9,]+))?<!s';

/*
                        <h2 class="advert-overview-title">Facilities</h2>
                        <ul class="advert-facilities-1">
                            <li id="ctl00_BodyContent_PropertyTypePanel">
                                <div class="advert-facilities-title">
                                    Property type
                                </div>
                                <div>
                                    <ul>
                                        <li>
                                            <span id="ctl00_BodyContent_PropertyTypeLabel">villa</span></li>
                                    </ul>
                                </div>
                            </li>
                            <li id="ctl00_BodyContent_SwimmingPoolPanel">
                                <div class="advert-facilities-title">
                                    Swimming pools
                                </div>
                                <div>
                                    <ul>
                                        <li>Private swimming pool</li>
                                    </ul>
                                </div>
                            </li>

*/
        $facility_tpl = '/property-overview-row-title">\s{0,}([^<]+)<.*?property-overview-row-info">\s+<ul>(.*?)<\/ul>/s';
        
        $facility_tpl = '/advert-facilities-title">\s{0,}([^<]+)<.*?<ul>(.*?)<\/ul>/s';

        $facility2_tpl = '/<li>\s{0,}(.*?)\s{0,}<\/li/s';


        preg_match ($villa_tpl, $str, $match);



        if (!$match) {
            echo "no villa match $id<br>";
            $this->error = "no villa match $id\n";
            //return;
        }
        preg_match_all ($region_id_tpl, $match[5], $region_id_match);
        if (!$region_id_match) {
            $this->error = "no region_id_match $id\n";
            //return;
        }
        preg_match_all ($photo_tpl, $str, $photo_match);
        if (!$photo_match) {
            echo "no photo_match $id<br>";
            //return;
        }

        preg_match_all ($facility_tpl, $str, $facility_match);
        if (!$facility_match) {
            echo "no facility_match $id<br>";
            //return;
        }
        //print_r($region_id_match);

        if ($facility_match) {
            array_shift($facility_match);
            //print_r($facility_match);
            foreach ($facility_match[0] as $k => $v) {
                preg_match_all($facility2_tpl, $facility_match[1][$k], $options_match);
                //array_shift($options_match);
                array_shift($options_match);
                $opt_arr[$v] = $options_match[0];
            }
        }
            array_shift($photo_match);
            //array_shift($rate_match);
            array_shift($region_id_match);

        //echo '<pre>';
        //print_r($match[11]);
        

        if ($match) {
            $ret['id'] = $id;
            $ret['title'] = $match[4];
            $ret['summary'] = $match[8];
            $ret['location'] = $region_id_match[1][sizeof($region_id_match[0])-1];
            //$ret['bedroom'] = $match[2];
            $ret['sleeps'] = $match[3];
            //$ret['bathroom'] = $match[4];
            
            $ret['reviews'] = $match[6];
            $ret['index']   = $match[7];
            $ret['price']   = $match[9];

            $ret['type'] = $match[12];
            $ret['description_title'] = $match[10];
            $ret['description'] = $match[11];
            $ret['main_img'] = $match[3];
            $ret['region_id'] = $region_id_match;
            
            $ret['notes'] = $notes_match;
            $ret['extra'] = $extra_match;
            $ret['img'] = $photo_match;
            $ret['rate'] = $rate_match;
            $ret['opt'] = $opt_arr;
            $ret['map'] = array($match[2], $match[1], '');
        }

        //print_r($ret);
        //array_shift($match);
        //print_r($match);



        unset($str);
        unset($match);
        return $ret;
    }

    /**
     *
     * @return array(
        [0] => array(image)
        [1] => title
        [2] => id
        [3] => index
        [4] => summury
        [5] => rate GBP
        [6] => sleeps
     )
     */
    public static function parseList1($str)
    {
        //echo $str;
        $vars_tpl = '!action="([^"]+)".*?__VIEWSTATE" value="([^"]+)".*?id="__EVENTVALIDATION" value="([^"]+)"!s';
        preg_match($vars_tpl, $str, $vars_match);
        
        print_r($vars_match);

        //'<span id="lblTracking">1 to 10 of 11 properties</span>' <span id="lblTracking">1 to 10 of 200 properties</span>
        $pager_tpl = '!<span id="lblTracking">\d+ to \d+ of (\d+) (.*)DropDownList_2(.*)!s';

        preg_match($pager_tpl, $str, $cnt_match);

        print_r($cnt_match);

        if ($cnt_match) {
            //echo $cnt_match[1];
            $location_tpl = '/value="(\d+)" class="LocationMenuLitstItemIndent">&#160;&#160;&#160;&#160;([^(]+) \((\d+)\)</';
            //$cnt = str_replace(",", "", $cnt_match[1]);
            //echo intval($cnt);
            //$location_tpl = '/DropDownList_2.*&#160;&#160;&#160;&#160;([^<]+)</is';
            //$location_tpl = '/&#160;&#160;&#160;&#160;([^<]+) \((\d+)\)</is';

            preg_match_all ($location_tpl, $cnt_match[3], $location_match);
            //print_r($location_match);
            array_shift($location_match);

            //$loc_arr = array_slice ($location_match[0], 85);
            //print_r($loc_arr);
        }

        //$villa_tpl = '!src="([^"]+)" alt="Property Photo.*?Property ref: <strong>\s+(\d+)<!s';


        /**
        OLD Style
        0 img
        1 title
        2 id
        3 index
        4 text
        5 price
        6 sleeps
        */
        $villa_tpl = '!src="([^"]+)" alt="Property Photo.*?"search-results-item-title">\s+<a href=".*?">\s+([^<]+)<.*?Property ref: <strong>\s+(\d+)<.*?RS Index:\s+(\d+)<.*?search-results-item-text">([^<]+)<.*?pound;([0-9,]+)\s+<.*?"search-results-item-sleeps">\s+(\d+)\s+<!s';


        /**
        0 img
        1 price
        2 title
        3 id
        4 text
        5 index
        */
        //$villa_tpl = '!src="([^"]+)" alt="Property Photo.*?pound;(\d+).*?"search-results-item-title">\s+<a href=".*?">\s+([^<]+)<.*?Property ref: <strong>\s+(\d+)<.*?search-results-item-text">([^<]+)<.*?RS Index:\s+(\d+)<!s';

        //$villa_tpl = '!src="([^"]+)" alt="Property Photo.*?pound;(\d+).*?style="position: relative; overflow: visible;">\s+<a href=".*?">\s+([^<]+)<.*?Property ref: <strong>\s+(\d+)<.*?search-results-item-text">([^<]+)<.*?RS Index:\s+(\d+)<!s';

        preg_match_all ($villa_tpl, $cnt_match[2], $match);
        if (!$match) {
            echo "no villa match $id<br>";
            $this->error = "no villa match $id\n";
            return;
        }

        //print_r($match);
        array_shift($match);

        $match['regions'] = $location_match;
        $match['cnt'] = $cnt_match[1];
        $match['vars'] = $vars_match;

        //$match['regions'] = $regions_match;
        //$match['locations'] = $location_match;
        //echo '<pre>';
        //print_r($match);
        return $match;
    }

    /**
     *
     * @return array(
        [0] => array(image)
        [1] => title
        [2] => id
        [3] => index
        [4] => summury
        [5] => rate GBP
        [6] => sleeps
     )
                    [PropRef] => 13842
                    [Country] => Italy
                    [Town] => Alberobello
                    [RSIndex] => 1550
                    [ReviewCount] => 30
                    [HasReviews] => 1
                    [ReviewRating] => 9
                    [PropertyType] => country house
                    [Summary] => "AS FEATURED IN A PLACE IN THE SUN MAGAZINE Oct 2010!" 
Trullo Patrizia is a 300 year old trullo - romantic Southern Italian farmhouse.

                    [Title] => Trullo Patrizia
                    [DailyPrice] => 950
                    [Accommodation] => Self catering
                    [Currency] => ВЈ (GBP)
                    [Sleeps] => 6
                    [InstantConfirmation] => 1
                    [Babies] => 1
                    [Beach] => 
                    [PrivatePool] => 1
                    [AirConditioner] => 
                    [CarHire] => 3
                    [IsCarHireOptional] => 
                    [IsCarHireRecommended] => 
                    [IsCarHireEssential] => 1
                    [Latitude] => 40.740001678467
                    [Longitude] => 17.219999313354
                    [BigImageUrl] => http://www.rentalsystems.com/data/images/13842/2010910754_main.jpg
                    [ImageUrl] => http://www.rentalsystems.com/data/images/13842/2010910754_thm.jpg
                    [HasSpecificBookingDate] => 
                    [BookingDuration] => 7
                    [BookingDate] => 2007-01-01T00:00:00
                    [BreadCrumbs] => Italy
/
Apulia - Puglia
/
Alberobello

                    [ActualPrice] => 993
                    [AdvertUrl] => http://www.villarenters.com/rent-villas/italy/alberobello/trullo-patrizia-13842
                    [IsShortListed] => 
     */
    public static function parseList($str)
    {
        //echo $str;
        $villa_tpl = '!searchresults = (.*?); !s';
        preg_match($villa_tpl, $str, $match);
        if (!$match) {
            echo "no villa match $id<br>";
            $this->error = "no villa match $id\n";
            return;
        }

        //echo '<pre>';
        $results = json_decode($match[1], 1);
        //$results = json_decode(utf8_encode($json));
        //echo '<br>'.json_last_error();
        //print_r($results);

        foreach ($results['SearchResults'] as $k => $villa) {
            $ret[0][$k] = $villa['ImageUrl'];
            $ret[1][$k] = $villa['Title'];
            $ret[2][$k] = $villa['PropRef'];
            $ret[3][$k] = $villa['RSIndex'];
            $ret[4][$k] = $villa['Summary'];
            $ret[5][$k] = $villa['ActualPrice'];
            $ret[6][$k] = $villa['Sleeps'];
            //$ret[6][$k] = $villa['ActualPrice'];
        }

        $ret['regions'] = $location_match;
        $ret['cnt'] = $results['Counts']['Total'];
        $ret['vars'] = $vars_match;

        //print_r($ret);
        return $ret;
    }
}

?>