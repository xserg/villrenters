<?php
/**
 * Список вилл
 * @package villarenters
 * $Id: Villa_Index.php 388 2015-04-30 08:59:18Z xxserg $
 */

define('PER_PAGE', 10);
define('DEBUG', 1);

require_once COMMON_LIB.'DVS/Dynamic.php';
require_once COMMON_LIB.'DVS/Table.php';
require (PROJECT_ROOT.'/layout/getXML.php');

class Project_Villa_Index extends DVS_Dynamic
{
    // Права
    public $perms_arr = array('iu' => 1, 'mu' => 1, 'oc' => 1);

    private $lang_ru = array(
        'Rates' => 'Цены',
        'week' => 'в неделю',
        'Sleeps' => 'спальных мест',
        'details' => 'Подробнее...',
        //'booking' => 'Забронировать',
        
        'booking' => 'Арендовать...',

    );

    function getPageData()
    {

        //$map = DVS::getVar('map');
        if(isset($_GET['map'])) {
            $this->map = 1;
        }
        /**
        * Поиск по keyword preGenerateList
        */
        $keyword = DVS::getVar('keyword');
        $minprice = DVS::getVar('minprice', 'int');
        $maxprice = DVS::getVar('maxprice', 'int');
        $start = DVS::getVar('startDateInput');
        $end = DVS::getVar('endDateInput');
        $sleeps = DVS::getVar('sleeps');
        $proptype = DVS::getVar('proptype');
        $p = DVS::getVar('_p', 'int');


        $this->createTemplateObj();
        $this->template_obj->loadTemplateFile('villa_search2.tpl');
        $search_form = $this->db_obj->getSearchFormClient($this->template_obj);
        $this->template_obj->loadTemplateFile('villa_list.tpl');

        //$this->template_obj->setVariable(array('startDateInput' => $start, 'endDateInput' => $end));

        //$villa_recent_obj = DB_DataObject::factory('villa');
        //$villa_recent_obj->getRecent(& $this->template_obj);


        //$villa_special_obj = DB_DataObject::factory('villa');
        //$villa_special_obj->getSpecial(& $this->template_obj);
        //$villa_special_obj->getRurenterSpecial(& $this->template_obj);
        //$villa_special_obj->getRurenterList(& $this->template_obj);

/*
            $rate = $this->db_obj->currencyRate();
            //print_r($rate);
            //DB_DataObject::DebugLevel(1);
            if ($minprice) {
                //$this->db_obj->whereAdd('minprice > '.$minprice);

                $this->db_obj->whereAdd("minprice > CASE currency"
                    ." WHEN \"$ (USD)\" THEN ".round($minprice * $rate['eur_usd'])
                    ." WHEN \"ВЈ (GBP)\" THEN ".round($minprice * $rate['eur_gbp'])
                    ." WHEN \"E (EUR)\" THEN ".$minprice." END");
                 $this->template_obj->setVariable(array('minprice' => $minprice));
            }

            if ($maxprice) {
                //$this->db_obj->whereAdd('maxprice < '.$maxprice);

                $this->db_obj->whereAdd("maxprice < CASE currency"
                    ." WHEN \"$ (USD)\" THEN ".round($maxprice * $rate['eur_usd'])
                    ." WHEN \"ВЈ (GBP)\" THEN ".round($maxprice * $rate['eur_gbp'])
                    ." WHEN \"E (EUR)\" THEN ".$maxprice." END");
                 $this->template_obj->setVariable(array('maxprice' => $maxprice));
            }

            if ($sleeps) {
                $this->db_obj->whereAdd('sleeps >= '.$sleeps);
            }

            if ($proptype) {
                $this->db_obj->whereAdd("proptype = '".$proptype."'");
            }
*/

            /*

            $this->db_obj->setSearchParams($this->template_obj, $minprice, $maxprice, $sleeps, $proptype);
            $this->db_obj->preGenerateList();
            
            $this->db_obj->whereAdd("villarentersindex > 50");
            //$this->db_obj->whereAdd("(villarentersindex > 60 && id < 65000) OR (villarentersindex > 50 && id > 65000)");
            */

        if (!$this->map) {
            $maplink = '<a href="?map"><h2>На карте</h2>';
            
            //$this->db_obj1 = DB_DataObject::factory('villa');
            //$this->db_obj->database('rurenter');

            $this->db_obj->whereAdd("status_id = 2");;

            $cnt1 = $this->db_obj->getCnt($this->template_obj, $minprice, $maxprice, $sleeps, $proptype);
            
            if ($cnt1 > 0) {
                $this->db_obj->getVillaList($this->template_obj, $p);
            }
            
            //$links =  Project_Villa_Index::createPager($cnt1);
            //unset($this->db_obj);
            /*
            $db = $this->db_obj1->getDatabaseConnection();
            $db->disconnect();

            $this->db_obj2 = DB_DataObject::factory('villa');
            $this->db_obj2->database('interhome');
            //$cnt2 = $this->db_obj2->getCnt($this->template_obj, $minprice, $maxprice, $sleeps, $proptype);
            if ($cnt2 > 0 ) {
                $this->db_obj2->getVillaList($this->template_obj, $p, $this->db_obj2->N);
            }
            
            $this->db_obj->database('rurenter');
            $cnt3 = $this->db_obj->getCnt($this->template_obj, $minprice, $maxprice, $sleeps, $proptype);
            if ($cnt3 > 0 ) {
            $this->db_obj->database('xserg');
                $this->db_obj->getVillaList($this->template_obj, $p, $this->db_obj->N);
            }
            //if ($cnt2 > 0 && ($cnt1 < PER_PAGE || $this->db_obj1->N < PER_PAGE)) {

        $db1 = $this->db_obj1->getDatabaseConnection();
        $db1->disconnect();

            */

            //echo $cnt1.'<br>'.$cnt2;

            $links =  Project_Villa_Index::createPager($cnt1 + $cnt2 + $cnt3);
            //print_r($links);

            /*
            $this->db_obj->orderBy('villarentersindex DESC');
            $this->db_obj->find();

            while ($this->db_obj->fetch()) {
                $this->template_obj->setVariable(
                $this->db_obj->getVillaRow()
                /*
                array(
                //'LINK'      => '?op=villa&act=show&id=',
                //'RENT'      => 'аренда ',
                'LINK'      => '/villa/'.$this->db_obj->id.'.html',
                'VILLA_ID' => $this->db_obj->id,
                'TITLE' => $this->db_obj->title_rus ? $this->db_obj->title_rus : $this->db_obj->title,
                'SUMMARY' => $this->db_obj->summary_rus ? $this->db_obj->summary_rus : $this->db_obj->summary,
                'PROPTYPE' => 'аренда '.$this->db_obj->propTypeName($this->db_obj->proptype),
                'SLEEPS_NUM' => $this->db_obj->sleeps,
                'Rating' => $this->db_obj->villarentersindex,
                'MIN_PRICE' => $this->db_obj->minprice,
                'MAX_PRICE' => $this->db_obj->maxprice,
                'CURRENCY' => $this->db_obj->currency,
                'M_PHOTO_SRC' => VILLARENTERS_IMAGE_URL.$this->db_obj->main_image,
                'M_ALT_TEXT' => 'аренда '.$this->db_obj->propTypeName($this->db_obj->proptype).' - '.($this->db_obj->title_rus ? $this->db_obj->title_rus : $this->db_obj->title),
                )
                );
                $this->template_obj->parse('VILLA');
            }
            */
        }// map
        else {

            //$this->db_obj->database('xserg');
            $cnt2 = $this->db_obj->getCnt($this->template_obj, $minprice, $maxprice, $sleeps, $proptype);


            $this->db_obj->find(true);
            $this->showMap();
            $maplink = '<a href="/regions/'.$_GET['alias'].'"><h2>Список</h2>';
        }
            if ($this->db_obj->location_id) {
                $this->showArticles();
                $this->showRegions();
            }

            //$this->showRecent();


            $this->template_obj->setVariable(array(
            //'PAGES'      => '?op=villa&act=show&id=',
            'CNT' => $links['cnt'] ? 'Всего: '.$links['cnt'] : '',
            'PAGES'      =>     $links['all'],
                'SEARCH_FORM' => $search_form,
                'MAP_LINK' => $maplink,
            ));
        $this->template_obj->setGlobalVariable($this->lang_ru);
        $this->template_obj->setVariable(array('TICKETS' => file_get_contents(PROJECT_ROOT.'tmpl/reg_ad.tpl').$this->hotels()));


        //$this->template_obj->setVariable(array('TICKETS' => file_get_contents(PROJECT_ROOT.'tmpl/aviasales.tpl').$this->hotels()));
        if (SERVER_TYPE == 'remote') {
            //$this->template_obj->setVariable(array('TICKETS' => file_get_contents(PROJECT_ROOT.'tmpl/adsense.tpl')));
            //$this->template_obj->setVariable(array('TICKETS' => Project_Layout_User::sapeArticles()));
            $this->template_obj->setVariable(array('TICKETS' => file_get_contents(PROJECT_ROOT.'tmpl/reg_ad.tpl')));

        }
        //$this->template_obj->setVariable(array('TICKETS' => Project_Layout_User::getReclama2()));

        
        $inthe = ' в ';

        $exceptions = array('Индонезии - Бали' => 'Бали', 'Таиланд - Пхукет' => 'Пхукете', 'Кипр' => 'Кипре', 'Испании - Канарские острова - Тенерифе' => 'Тенерифе', 'Таиланд - Ко Самуи' => 'Самуи');

        if (in_array($this->db_obj->region_title_t, array_keys($exceptions))) {
            $inthe = ' на ';
            $this->db_obj->region_title_t = $exceptions[$this->db_obj->region_title_t];
        }
        $this->db_obj->region_title_t = $inthe.$this->db_obj->region_title_t;

        $page_arr['CENTER_TITLE'] = 'Аренда вилл'.$this->db_obj->region_title_t;
        $page_arr['PAGE_TITLE'] = 'Виллы и апартаменты '.$this->db_obj->region_title_t.'. Аренда вилл, аппартаментов, домов, коттеджей, квартир, '.$this->db_obj->region_title_t.' - '.' стр. '.
            ($_GET['_p'] ? $_GET['_p'] : 1).' - '.$this->layout_obj->project_title;
        
        //$page_arr['DESCRIPTION'] = 'Аренда вилл '.$this->db_obj->region_title_t.', '.$this->layout_obj->description;

        $page_arr['DESCRIPTION'] = $this->db_obj->region_title_p.'. '.$this->layout_obj->description;
        $page_arr['KEYWORDS'] = $this->db_obj->region_title_p.', '.$this->layout_obj->keywords;

        //$page_arr['CENTER_TITLE']   = $this->db_obj->name;
        if ($this->map) {
            $page_arr['BODY_EVENT']   = ' onload="initialize()"';
        }
        $page_arr['BODY_CLASS']   = 'search-page';
        //$page_arr['CENTER']         = file_get_contents(PROJECT_ROOT.'tmpl/sidebar.tpl').
        $page_arr['CENTER']         = $this->template_obj->get();
        //$page_arr['JSCRIPT']        = $this->datePicker2();

         $page_arr['JSCRIPT']        = $this->page_arr['JSCRIPT'];
        return $page_arr;
    }

    function showLocation()
    {
        $countries_obj = DB_DataObject::factory('countries');
        $link = 'regions/'.($this->map ? '?map' : '');
        $countries_obj->getParent(DVS::getVar('loc'), $link);
        return $countries_obj->region_title;
    }

    function showRegions()
    {
        $this->template_obj->addBlockFile('REGIONS', 'REGIONS', 'region.tpl');
        $countries_obj = DB_DataObject::factory('countries');
        $countries_obj->getParent($this->db_obj->location_id, $map_link);
        $countries_obj->parent_id = $this->db_obj->location_id;
        $countries_obj->orderBy('rus_name');
        $countries_obj->find();
        $map_link = $this->map ? '?map' : '';
            while ($countries_obj->fetch()) {
                $this->template_obj->setVariable(array(
                //'COUNTRY_LINK'  => '?op=villa&act=index&loc='.$сountries_obj->id,
                'COUNTRY_LINK'  => '/regions/'.$countries_obj->getAlias().'/'.$map_link,
                'COUNTRY_NAME' => 'аренда вилл в '.$countries_obj->region_title_t.' <b>'.$countries_obj->getLocalName().'</b>',
                'COUNTRY_CNT' => $countries_obj->counter,
                'ALT_TEXT' => 'аренда вилл '.$countries_obj->getLocalName(),
                ));
                $i++;
                $this->template_obj->parse('COUNTRY_ROW');
                /*
                if ($cnt >= 3) {
                    if (!($i % ($cnt / 3))) {
                        $this->template_obj->parse('COUNTRIES_COLUMN');
                    }
                } else {
                    $this->template_obj->parse('COUNTRIES_COLUMN');
                }
                */
            }
            $this->template_obj->parse('REGIONS');
            //DB_DataObject::DebugLevel(1);
            $this->template_obj->setVariable(array(
                'LOCATION_NAV' => $countries_obj->region_title,
                //'COUNTRY_DESCRIPTION' => $_GET['_p'] > 0 ? '' : nl2br($countries_obj->country_description)
                'COUNTRY_DESCRIPTION' => nl2br($countries_obj->country_description)

            ));
    }


    function datePicker2()
    {
        $this->src_files = array(
            'JS_SRC' => array(  '/js/jquery-1.3.1.min.js',
                                '/js/datePicker2.js',
                                '/js/date.js',
        ),
            'CSS_SRC'  => array('/css/datePicker.css',
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

    /**
    'params' => array(
        'Rag' => '',
        'strOwnerRefs' => '',
        'strPropRefs' => '',
        'strLocationRefs' => '',
        'intMaxPrice' => '0',
        'intMinPrice' => '0',
        'intSleeps' => '0',
        'blnInstantBooking' => 'false',
        'intVillarentersIndex' => '100',
        'intDiscountType' => '0',
        'intBranding' => '0',
        'intPage' => '1',
        'intItemsPerPage' => '200',
        'blnEnableAvailabilitySearch' => 'false',
        'strFromYYYYMMDD' => '',
        'strToYYYYMMDD' => '',
        'intSortOrder' => '0',
    )),
    */
    function xmlSearch($params)
    {
        $request_obj = new GetXML;
        $request_obj->data_url['VillaSearch']['params'] = $params;
        $xml = $request_obj->requestXMLdata('VillaSearch');
        return $xml;
    }


    function showMap()
    {
        $this->src_files = array(
            'JS_SRC' => array("http://maps.google.com/maps/api/js?sensor=false")
            );
        $this->page_arr['JSCRIPT'] = '				  function initialize() {
					var latlng = new google.maps.LatLng('.$this->db_obj->lat.', '.$this->db_obj->lon.');
					var myOptions = {
					  zoom: 12,
                      scrollwheel: false,
					  center: latlng,
					  mapTypeId: google.maps.MapTypeId.ROADMAP
					};
					var map = new google.maps.Map(document.getElementById("g-map"), myOptions);
                    var georssLayer = new google.maps.KmlLayer(\'http://villarenters.ru/?op=villa&act=geo&alias='.$_GET['alias'].'\');
                    georssLayer.setMap(map);

				  }';
        $this->template_obj->touchBlock('LOCATION_MAP');
    }

    static function createPager($cnt)
    {
        require_once 'Pager/Pager.php';
        //$cnt = $db_obj->count();
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
        $qs = preg_replace('/'.$page_params['urlVar'].'='.$p.'\&?/', '', $qs);
        if (!preg_match('/[\&\?]$/i', $qs)) {
            $qs .= strstr($qs, '?') ? '&' : '?';
        }
        //echo $qs;
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


    function hotels()
    {
        $str = file_get_contents(PROJECT_ROOT.'tmpl/hotels.tpl');
         $str = str_replace('{filename}', str_replace('/', '', $_GET['alias']),  $str);
         $str = str_replace('{cityname}', urlencode(iconv("Windows-1251", 'UTF-8', $this->db_obj->region_title_t)),  $str);
         return $str;
    }

    function showRecent()
    {
        if ($_COOKIE['villa_id']) {
            foreach ($_COOKIE['villa_id'] as $villa_id => $time) {
                echo "$villa_id => $time <br>";
            }
        }

    }

    function showArticles()
    {
        //echo $this->db_obj->location_id;
        //DB_DataObject::DebugLevel(1);
        $this->template_obj->addBlockFile('ARTICLES', 'ARTICLES', 'articles.tpl');
        $articles_obj = DB_DataObject::factory('articles');
        $articles_obj->location_id = $this->db_obj->location_id;
        $articles_obj->orderBy('id DESC');
        $articles_obj->find();
        while ($articles_obj->fetch()) {
                $this->template_obj->setVariable(array(
                'ARTICLE_TITLE' => $articles_obj->title,
                'ARTICLE_LINK'  => '?op=articles&act=show&id='.$articles_obj->id,
              ));
              $this->template_obj->parse('ARTICLES_ROW');
        }
            $db = $this->db_obj->getDatabaseConnection();
            $db->disconnect();

    }
}

?>