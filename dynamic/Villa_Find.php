<?php
/**
 * Список вилл
 * @package villarenters
 * $Id: Villa_Search.php 70 2011-04-11 07:15:31Z xxserg@gmail.com $
 */

define('PER_PAGE', 20);
//define('DEBUG', 1);


require_once COMMON_LIB.'DVS/Dynamic.php';
require_once 'Date.php';
//require_once COMMON_LIB.'DVS/Table.php';
require (PROJECT_ROOT.'/layout/getData.php');

class Project_Villa_Find extends DVS_Dynamic
{
    // Права
    public $perms_arr = array('iu' => 1, 'ou' => 1, 'oc' => 1);

    public $prop_type_arr = array(
        'apartments' => 'апартамент',
        //'barns' => 'Barns',
        'bungalows' => 'бунгало',
        'cabins' => 'домик',
        'chalets' => 'шале',
        'chateaus' => 'шато',
        'condos' => 'квартира',
        'cottages' => 'коттедж',
        'farmhouses' => 'ферма',
        'houses' => 'дом',
        'villas' => 'вилла',
        'house boats' => 'лодка',
        'castles' => 'замок',
        'hotels' => 'отель',
        'yachts' => 'яхта'
        );

    private $lang_ru = array(
        'Rates' => 'Цены',
        'week' => 'в неделю',
        'Sleeps' => 'спальных мест',
        'details' => 'Подробнее...',
        'booking' => 'Забронировать',
    );

    function getPageData()
    {
        session_start();

        //echo '<pre>';
        //print_r($_SESSION);
        //print_r($GLOBALS);

        //print_r($_GET);

        //print_r($_POST);

        $keyword = DVS::getVar('keyword');
        if ($keyword && preg_match("/^[0-9]{4,8}$/", $keyword)) {
            header("location: /villa2/".$keyword.".html");
            exit;
        } 

        if ($_GET['x'] || $_GET['country'] || $_GET['find_button_x']) {

            $str = $this->getList();
            //echo $str;
            $data = GetData::parseList($str);

            if (!$data[0]) {
                //header("location: /");
            }
            //echo '<pre>';
            //print_r($data);
            //exit;
        }

        $template_name = 'villa_find.tpl';
        $this->createTemplateObj();

        // Список вилл
        if ($data) {

            $_SESSION['fa'] = $data['vars'][1];
            $_SESSION['vs'] = $data['vars'][2];
            $_SESSION['ev'] = $data['vars'][3];

             $this->template_obj->loadTemplateFile('villa_search_f.tpl');

            $search_form = $this->db_obj->getSearchFormDate($this->template_obj);

            $this->template_obj->loadTemplateFile('villa_list2.tpl');
            $this->showList($data);
            $links =  Project_Villa_Find::createPager($data['cnt']);

            $this->template_obj->setVariable(array(
            //'PAGES'      => '?op=villa&act=show&id=',
            'CNT' => $links['cnt'] ? 'Всего: '.$links['cnt'] : '',
            'PAGES'      =>     $links['all'],
                'SEARCH_FORM' => $search_form,
                'MAP_LINK' => $maplink,
                'HA_LINK' => '<a href="http://villarenters.ru'.$_SERVER['REQUEST_URI'].'">Еще виллы в аренду '.$this->db_obj->region_title_t.'</a><br><br>'
            ));

            //$this->showRegions($data['regions']);
            $this->template_obj->setGlobalVariable($this->lang_ru);
            $page_arr['BODY_CLASS']   = 'search-page';

            $region = DVS::getVar('region');
            $r2 = DVS::getVar('r2');

            if ($region) {
                //echo $region;
                $this->showLocation($r2 ? $r2 : $region);
            }

            $page_arr['PAGE_TITLE'] = 'Аренда вилл в '.$this->region_title_t.', аппартаментов в '.$this->region_title_t.', квартир в '.$this->region_title_t.' - '.' стр. '.
            ($_GET['_p'] ? $_GET['_p'] : 1).' - '.$this->layout_obj->project_title;

            $page_arr['CENTER']         = $this->template_obj->get();
        } else {
            $this->template_obj->loadTemplateFile('villa_find.tpl');
            $page_arr['BODY_CLASS']   = 'adv-search';
            //$page_arr['CENTER']         = $this->db_obj->getSearchFormClient($this->template_obj);
            $page_arr['CENTER']         = $this->db_obj->getSearchFormDate($this->template_obj);

        }
        $page_arr['JSCRIPT']        = $this->datePicker();
        return $page_arr;
    }

    function datePicker()
    {
        $this->src_files = array(
            'JS_SRC' => array(  '/js/jquery-1.3.1.min.js',
                                '/js/datePicker2.js',
                                '/js/date.js',
        ),
            'CSS_SRC'  => array(
                                '/css/datePicker.css',
                                '/css/demo1.css',
                                //'/datepicker/css/layout.css',
        )
        );
        //$date_str = $this->showBook();
        //$page_arr['JSCRIPT'] = "

        $js = "
            $(function()
            {
                $('.datepicker').datePicker();
            });";
          return $js;
    }


    static function dateDiff($start, $end)
    {
        $start_arr = explode('/', $start);
        $end_arr = explode('/', $end);

        return  Date_Calc::dateDiff($start_arr[0],$start_arr[1],$start_arr[2], $end_arr[0], $end_arr[1], $end_arr[2]);
    }


    /**
     * Формирование запроса поиска GET 30.04.13
     * searchresults.aspx?location=105&departure=09052013&nights=10&sleeps=10&keywords=villa&page=2
     */
    function getList()
    {
        $country =  DVS::getVar('country');
        $region = DVS::getVar('region');
        $r2 = DVS::getVar('r2');
        $keyword = DVS::getVar('keyword');
        $minprice = DVS::getVar('minprice', 'int');
        $maxprice = DVS::getVar('maxprice', 'int');
        $start = DVS::getVar('startDateInput', 'word');
        $nights = DVS::getVar('nights');
        $end = DVS::getVar('endDateInput');
        $sleeps = DVS::getVar('sleeps', 'int');
        $proptype = DVS::getVar('proptype');
        $page = DVS::getVar('_p');
        $action = '/searchresults.aspx';
        $data_obj = new GetData;
        if ($start && $end) {
            $nights = self::dateDiff($start, $end);
            //echo $nights;
        } else {
            $nights = 7;
        }
        $params = array(
            'location' => $region,
            'page' => $page,
            'sleeps' => $sleeps,
            'keywords' => $keyword,
            'departure' => str_replace('/', '', $start),
            'nights' => $nights,
        );
        $data_obj->data_url['Search']['url'] = $action;
        $data_obj->data_url['Search']['method'] = 'get';
        $data_obj->data_url['Search']['params'] = $params;
        return $data_obj->requestData('Search');
    }



    /**
     * Формирование запроса поиска
     * 
     */
    function getList2()
    {
        $country =  DVS::getVar('country');
        $region = DVS::getVar('region');
        $r2 = DVS::getVar('r2');
        $keyword = DVS::getVar('keyword');
        $minprice = DVS::getVar('minprice', 'int');
        $maxprice = DVS::getVar('maxprice', 'int');
        $start = DVS::getVar('startDateInput', 'word');
        $nights = DVS::getVar('nights');

        $end = DVS::getVar('endDateInput');
        $sleeps = DVS::getVar('sleeps', 'int');
        $proptype = DVS::getVar('proptype');
        $page = DVS::getVar('_p');

        //$action = $_POST['action'];

        if ($_SESSION['fa'] && $_SESSION['fa'] != '/ErrorPage.aspx') {
            $action = $_SESSION['fa'];
        } else {
            $action = '/searchresults.aspx';
            //$action = '/default.aspx';
        }

        $data_obj = new GetData;

        if ($country) {
            $data_obj->data_url['Search']['url'] = '/SearchResults.aspx';
            $data_obj->data_url['Search']['method'] = 'get';
            $data_obj->data_url['Search']['params'] = array('country' => $country, 'p' => $page);
            return $data_obj->requestData('Search');
        }

        if ($start && $end) {
            $nights = self::dateDiff($start, $end);
            //echo $nights;
        } else {
            $nights = 7;
        }

/*
        if ($region) {
            $this->region = $region;
            //$url .= '/region:'.$region;
            $url .= '/'.$region;
        } else if ($keyword) {
            if (preg_match("/^\d+a?$/", $keyword)) {
                header('location: /villa2/'.$keyword.'.html');
                return;
            }
            $url .= '/keywords:'.$keyword;
        }
*/

        $evt = '';
        if ($page) {
            $evt = 'LB'.$page;
        }


        //$start =    'dd/mm/yyyy';

        $post_arr = array(
            '__EVENTTARGET' =>                      $evt,
            '__EVENTARGUMENT' =>                    '',                    
            '__LASTFOCUS' =>                        '',                        
            '__VIEWSTATE' =>                        $_SESSION['vs'],
            '__EVENTVALIDATION' =>                  $_SESSION['ev'],
            'txtSearchName' =>                      '',                      
            //'locationinput'                     => $region,
            'location_dropdown1$DropDownList_1' =>  $region,
            'location_dropdown1$DropDownList_2' =>  $r2 ? $r2 : '-1',
            'txtStartDate' =>                       $start ? $start : 'dd/mm/yyyy',
            'ddlNights' =>                          $nights,
            'ddlSleeps' =>                          $sleeps,
            'txtKeywords' =>                        $keyword,
            'ddlCarhire' =>                         0,
            //'cmdSearch1.x' =>                       18,
            //'cmdSearch1.y' =>                       5,
            'ImageButton2.x' =>  23,     
            'ImageButton2.y' =>  14,     

            //'txtNewsletterEmail' => '',         
            'ddlPerPage' =>                         20,
            'ddlSort' =>                            8,
                    );

        // Поиск с первой страницы
        if ($_GET['find_button_x'] && !$_GET['_p']) {
            $post_arr = array();
            $post_arr['__EVENTTARGET'] = 'ctl00$VRHeader$cmdSearch';
            $post_arr['ctl00$BodyContent$txtNewsletterEmail'] =    '';      
            $post_arr['ctl00$VRHeader$LocationInput'] =    $region;
            $post_arr['ctl00$VRHeader$ddlPartySize'] =    $sleeps;
            $post_arr['ctl00$VRHeader$txtStartDate'] =    $start ? $start : 'dd/mm/yyyy';
            $post_arr['ctl00$VRHeader$ddlNights'] =    $nights;
            $post_arr['__VIEWSTATE'] = '/wEPDwUKLTQwNjI0MzY2MQ9kFgJmD2QWAgIDEGRkFgICAw9kFggCAQ8WAh4FY2xhc3MFEWhlYWRlci10YWItYWN0aXZlZAINDxYCHgdWaXNpYmxlaGQCEQ8PZBYCHwAFFmhlYWRlci1jdXJyZW5jeS1hY3RpdmVkAhcPZBYEAgIPEGQPFiBmAgECAgIDAgQCBQIGAgcCCAIJAgoCCwIMAg0CDgIPAhACEQISAhMCFAIVAhYCFwIYAhkCGgIbAhwCHQIeAh8WIBAFDkFueSBQYXJ0eSBzaXplBQEwZxAFCDEgcGVyc29uBQExZxAFCDIgcGVvcGxlBQEyZxAFCDMgcGVvcGxlBQEzZxAFCDQgcGVvcGxlBQE0ZxAFCDUgcGVvcGxlBQE1ZxAFCDYgcGVvcGxlBQE2ZxAFCDcgcGVvcGxlBQE3ZxAFCDggcGVvcGxlBQE4ZxAFCDkgcGVvcGxlBQE5ZxAFCTEwIHBlb3BsZQUCMTBnEAUJMTEgcGVvcGxlBQIxMWcQBQkxMiBwZW9wbGUFAjEyZxAFCTEzIHBlb3BsZQUCMTNnEAUJMTQgcGVvcGxlBQIxNGcQBQkxNSBwZW9wbGUFAjE1ZxAFCTE2IHBlb3BsZQUCMTZnEAUJMTcgcGVvcGxlBQIxN2cQBQkxOCBwZW9wbGUFAjE4ZxAFCTE5IHBlb3BsZQUCMTlnEAUJMjAgcGVvcGxlBQIyMGcQBQkyMSBwZW9wbGUFAjIxZxAFCTIyIHBlb3BsZQUCMjJnEAUJMjMgcGVvcGxlBQIyM2cQBQkyNCBwZW9wbGUFAjI0ZxAFCTI1IHBlb3BsZQUCMjVnEAUJMjYgcGVvcGxlBQIyNmcQBQkyNyBwZW9wbGUFAjI3ZxAFCTI4IHBlb3BsZQUCMjhnEAUJMjkgcGVvcGxlBQIyOWcQBQkzMCBwZW9wbGUFAjMwZxAFCjMxKyBwZW9wbGUFAjMxZ2RkAgQPEGQPFjJmAgECAgIDAgQCBQIGAgcCCAIJAgoCCwIMAg0CDgIPAhACEQISAhMCFAIVAhYCFwIYAhkCGgIbAhwCHQIeAh8CIAIhAiICIwIkAiUCJgInAigCKQIqAisCLAItAi4CLwIwAjEWMhAFBzEgbmlnaHQFATFnEAUIMiBuaWdodHMFATJnEAUIMyBuaWdodHMFATNnEAUINCBuaWdodHMFATRnEAUINSBuaWdodHMFATVnEAUINiBuaWdodHMFATZnEAUINyBuaWdodHMFATdnEAUIOCBuaWdodHMFAThnEAUIOSBuaWdodHMFATlnEAUJMTAgbmlnaHRzBQIxMGcQBQkxMSBuaWdodHMFAjExZxAFCTEyIG5pZ2h0cwUCMTJnEAUJMTMgbmlnaHRzBQIxM2cQBQkxNCBuaWdodHMFAjE0ZxAFCTE1IG5pZ2h0cwUCMTVnEAUJMTYgbmlnaHRzBQIxNmcQBQkxNyBuaWdodHMFAjE3ZxAFCTE4IG5pZ2h0cwUCMThnEAUJMTkgbmlnaHRzBQIxOWcQBQkyMCBuaWdodHMFAjIwZxAFCTIxIG5pZ2h0cwUCMjFnEAUJMjIgbmlnaHRzBQIyMmcQBQkyMyBuaWdodHMFAjIzZxAFCTI0IG5pZ2h0cwUCMjRnEAUJMjUgbmlnaHRzBQIyNWcQBQkyNiBuaWdodHMFAjI2ZxAFCTI3IG5pZ2h0cwUCMjdnEAUJMjggbmlnaHRzBQIyOGcQBQkyOSBuaWdodHMFAjI5ZxAFCTMwIG5pZ2h0cwUCMzBnEAUJMzEgbmlnaHRzBQIzMWcQBQkzMiBuaWdodHMFAjMyZxAFCTMzIG5pZ2h0cwUCMzNnEAUJMzQgbmlnaHRzBQIzNGcQBQkzNSBuaWdodHMFAjM1ZxAFCTM2IG5pZ2h0cwUCMzZnEAUJMzcgbmlnaHRzBQIzN2cQBQkzOCBuaWdodHMFAjM4ZxAFCTM5IG5pZ2h0cwUCMzlnEAUJNDAgbmlnaHRzBQI0MGcQBQk0MSBuaWdodHMFAjQxZxAFCTQyIG5pZ2h0cwUCNDJnEAUJNDMgbmlnaHRzBQI0M2cQBQk0NCBuaWdodHMFAjQ0ZxAFCTQ1IG5pZ2h0cwUCNDVnEAUJNDYgbmlnaHRzBQI0NmcQBQk0NyBuaWdodHMFAjQ3ZxAFCTQ4IG5pZ2h0cwUCNDhnEAUJNDkgbmlnaHRzBQI0OWcQBQk1MCBuaWdodHMFAjUwZ2RkGAEFHl9fQ29udHJvbHNSZXF1aXJlUG9zdEJhY2tLZXlfXxYBBSJjdGwwMCRCb2R5Q29udGVudCRidG5BZGROZXdzbGV0dGVynz1phcDfN02jFskzItrQ0wigQZU=';
            $post_arr['__EVENTVALIDATION'] = '/wEWWwKLyrnLAgLz07++BgLk77PyAwK887uxAQKIoaz5CAKqtLGDDQLvoY+LCgKw9enLBAKv9enLBAKu9enLBAKt9enLBAKs9enLBAKr9enLBAKq9enLBAKp9enLBAK49enLBAK39enLBAKv9anIBAKv9aXIBAKv9aHIBAKv9Z3IBAKv9ZnIBAKv9ZXIBAKv9ZHIBAKv9Y3IBAKv9cnLBAKv9cXLBAKu9anIBAKu9aXIBAKu9aHIBAKu9Z3IBAKu9ZnIBAKu9ZXIBAKu9ZHIBAKu9Y3IBAKu9cnLBAKu9cXLBAKt9anIBAKt9aXIBALJzNr/BQKyxrKoDwKzxrKoDwKwxrKoDwKxxrKoDwK2xrKoDwK3xrKoDwK0xrKoDwKlxrKoDwKqxrKoDwKyxvKrDwKyxv6rDwKyxvqrDwKyxsarDwKyxsKrDwKyxs6rDwKyxsqrDwKyxtarDwKyxpKoDwKyxp6oDwKzxvKrDwKzxv6rDwKzxvqrDwKzxsarDwKzxsKrDwKzxs6rDwKzxsqrDwKzxtarDwKzxpKoDwKzxp6oDwKwxvKrDwKwxv6rDwKwxvqrDwKwxsarDwKwxsKrDwKwxs6rDwKwxsqrDwKwxtarDwKwxpKoDwKwxp6oDwKxxvKrDwKxxv6rDwKxxvqrDwKxxsarDwKxxsKrDwKxxs6rDwKxxsqrDwKxxtarDwKxxpKoDwKxxp6oDwK2xvKrDwKcvOCKAWGoTBtCLxT7Jmf5SeOo1Mas0SSd';

            $action = '/default.aspx';
        }

        if ($page) {
            unset($post_arr['cmdSearch.x'], $post_arr['cmdSearch.y'], $post_arr['ImageButton2.x'], $post_arr['ImageButton2.y']);
        }

        //echo $action;

        if ($action) {
            $data_obj->data_url['Search']['url'] = $action;
            $data_obj->data_url['Search']['params'] = $post_arr;
            //$_SESSION['vcookies'] = '';
            if ($_SESSION['vcookies']) {
                foreach ($_SESSION['vcookies'] as $name => $value) {
                    $data_obj->data_url['Search']['cookies'][] = array('name' => $name, 'value' => $value);
                }
            }
        }
        $body = $data_obj->requestData('Search');
        //$body = file_get_contents('italy.htm');
        //return $body;
        
        //$header = $data_obj->req->response->getHeader();
        $cookies = $data_obj->req->response->getCookies();

        //echo '<pre>';
        //print_r($cookies);
        /*
        $_SESSION['vcookies']['WRUID'] = 0;
        $_SESSION['vcookies']['s_cc'] = true;
        $_SESSION['vcookies']['s_sq'] = 'teletxtvillarenters=%26pid%3DSearch%2520Results%26pidt%3D1%26oid%3Dhttp%253A%252F%252Fwww.villarenters.com%252Fassets%252Fen%252Fgfx%252Fbtn-home-search.png%26ot%3DIMAGE';
        */

        foreach ($cookies as $k => $cookie) {
            $_SESSION['vcookies'][$cookie['name']] = $cookie['value'];
        }
        //$_SESSION['vcookies']['Calendar'] = 'SearchCriteriaStartDate=&HomePageDuration=7&HomePagePartySize=0';
        //print_r($cookies);
/*        if ($header['location']) {
            preg_match("!^/([^?]+)\?q=(.*)$!", $header['location'], $location_arr);
            print_r($location_arr);
            //exit;
            $data_obj = new GetData;
            $data_obj->data_url['Search']['url'] = $location_arr[1];
            $data_obj->data_url['Search']['params'] = array('q' => $location_arr[2]);
            $data_obj->data_url['Search']['method'] = 'get';
            $body = $data_obj->requestData('Search');
            //print_r($data_obj);
        }
*/
        //$body = file_get_contents('searchresults.aspx.htm');
        return $body;
    }


    function showList($data)
    {

        $period = 'за выбранный период';

        $map = array('img' => 0, 'title' => 1, 'id' => 2, 'index' => 3, 'text' => 4, 'price' => 5, 'sleeps' => 6);

        $i = 0;
            while (isset($data[1][$i])) {
                //$price_arr = self::parsePrice($data[6][$i]);
                //print_r($price_arr);
                $this->template_obj->setVariable(array(
                'LINK'      => '/villa2/'.$data[$map['id']][$i].'.html',
                'VILLA_ID' => $data[$map['id']][$i],
                'TITLE' => $data[$map['title']][$i],
                'SUMMARY' => $data[$map['text']][$i],
                //'PROPTYPE' => 'аренда '.$this->db_obj->propTypeName($this->db_obj->proptype),
                'SLEEPS_NUM' => $data[$map['sleeps']][$i],
                'Rating' => $data[$map['index']][$i],
                //'MIN_PRICE' => DBO_Villa::getPrice((int)str_replace(array('ВЈ',','), "", $data[6][$i])),
                'MIN_PRICE' => $data[$map['price']][$i],
                //'MAX_PRICE' => DBO_Villa::getPrice($this->db_obj->maxprice),
                'CURRENCY' => 'GBP',
                'M_PHOTO_SRC' => $data[$map['img']][$i],//self::parseImage($data[0][$i]),
                'period' => $period,
                //'M_ALT_TEXT' => 'аренда '.$this->db_obj->propTypeName($this->db_obj->proptype).' - '.($this->db_obj->title_rus ? $this->db_obj->title_rus : $this->db_obj->title),
                ));
                $this->template_obj->parse('VILLA');
                $i++;
            }
    }

    private static function parseImage($str) 
    {
        if (preg_match('/<noscript>\s+<img src="([^"]+)"/', $str, $match)) {
            return $match[1];
        }
        return false;
    }

    /**
     *
    @return array(price, currency, period)
     */
    private static function parsePrice($str) 
    {
        if (preg_match_all('/"price">([^\d]+)([0-9,]+)<\/span> <span class="period">per (night|week|month)</', $str, $match)) {
            //print_r($match);
            //return;
            foreach ($match[2] as $k => $price) {
                $price = (int)str_replace(',', "", $price);
                $ret[$match[3][$k]] = array(floor($price * MARGA), $match[1][$k]);
            }
            return $ret;
        }
        return array('week' => array('Владелец не установил цену'));
    }

    static function createPager($cnt)
    {
        require_once 'Pager/Pager.php';
        $page_params = array(
            'spacesBeforeSeparator' => 1,
            'spacesAfterSeparator'  => 1,
            'separator'             => '',
            'curPageLinkClassName'  => 'current',
            'perPage'               => PER_PAGE,
            'delta'                 => 10,
            'clearIfVoid'           => true,
            'mode'                  => 'Jumping',
            'urlVar'                => '_p',
            'append'                => false,
            'fileName'              => '',
            'totalItems'            => $cnt,
            'prevImg'               => '<<',
            'altPrev'               => 'пред.',
            'altNext'               => 'след.',
            'nextImg'               => '>>',
            'altPage'               => 'стр.',
            'path'                  => $_SERVER['REDIRECT_URL'],
        );
        $p = DVS::getVar($page_params['urlVar'], 'int');
        
        $qs = str_replace($_SERVER['REDIRECT_URL'], '', urldecode($_SERVER['REQUEST_URI']));
        //$qs = urldecode($_SERVER['REQUEST_URI']);
        $qs = preg_replace('/'.$page_params['urlVar'].'='.$p.'\&?/', '', $qs);
        if (!preg_match('/[\&\?]$/i', $qs)) {
            $qs .= strstr($qs, '?') ? '&' : '?';
        }
        //echo '<br>'.$qs;
        $page_params['fileName'] = $qs.$page_params['urlVar'].'=%d';
        if (empty($p)) {
            $p = 1;
        }
        //Проверка на существование запрощенной страницы
        if ($cnt && (($p - 1)*$page_params['perPage']) > $cnt) {
            $p = 1;
        }
        //$db_obj->limit(($p - 1)*$page_params['perPage'], $page_params['perPage']);    
        $pager_obj = Pager::factory($page_params);
        $links = $pager_obj->getLinks();
        $links['cnt'] = $cnt;
        return $links;
    }

    function numArr($min, $max)
    {
        for ($i = $min; $i < $max; $i++) {
            $ar[$i] = $i;
        }
        return $ar;
    }

    public static function countryOrKey($fields)
    {
        if (!$fields['region'] && !$fields['keyword']) {
            return array('region' => 'Заполните  страну или ключевое слово!');
        }
        return true;
    }

    function showLocation($region)
    {
        $countries_obj = DB_DataObject::factory('countries');
        $link = $this->map ? '?map' : '';
        $countries_obj->getParent2($region, $link);

        $this->template_obj->setVariable(array('LOCATION_NAV' => $countries_obj->region_title));
        $this->region_title_t = $countries_obj->region_title_t;
        return $countries_obj->region_title;
    }

    function showRegions($arr)
    {
        //print_r($arr);
        $this->template_obj->addBlockFile('REGIONS', 'REGIONS', 'region.tpl');
        $map_link = $this->map ? '?map' : '';

         $qs = preg_replace('/&r2=\d+$/', '', $_SERVER['REQUEST_URI']);

            foreach ($arr[0] as $k => $id) {
                $this->template_obj->setVariable(array(
                //'COUNTRY_LINK'  => '?op=villa&act=index&loc='.$сountries_obj->id,
                //'COUNTRY_LINK'  => '/'.preg_replace("!(/r$|/s/$)!", "", $arr[1][$k]).'/r'.$arr[2][$k].$map_link,
                'COUNTRY_LINK'  => urldecode($qs).'&r2='.$id.$map_link,
                'COUNTRY_NAME' => $arr[1][$k],
                'COUNTRY_CNT' => $arr[2][$k],
                'ALT_TEXT' => 'аренда вилл '.$arr[1][$k],
                ));
                $i++;
                $this->template_obj->parse('COUNTRY_ROW');
            }
            $this->template_obj->parse('REGIONS');
    }
}
?>