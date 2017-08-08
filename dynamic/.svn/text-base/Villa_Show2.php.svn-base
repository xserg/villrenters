<?php
/**
 * Карточка виллы
 * @package villarenters.ru
 * $Id: Villa_Show.php 70 2011-04-11 07:15:31Z xxserg@gmail.com $
 */

require_once COMMON_LIB.'DVS/Dynamic.php';
require (PROJECT_ROOT.'/layout/getData.php');
//require (PROJECT_ROOT.'/layout/saveData.php');

//define('DEBUG', 1);

class Project_Villa_Show2 extends DVS_Dynamic
{
    // Права
    public $perms_arr = array('ar' => 1, 'oc' => 1, 'iu' => 1);

    private $change_content = true;

    private $lang_ru = array(
        'Rates' => 'Цены',
        //'week' => 'в неделю',
        'Sleeps' => 'спальных мест',
        'details' => 'Подробнее...',
        'booking' => 'Забронировать',
        'Bathrooms' => 'Ванная комната',
        'Bedrooms' => 'Спальни',
        //'Facilities' => 'Услуги',
        'Further_details' => 'Подробности'
        //'Top' => 'Наверх',
        //'Send query' => 'Задать вопрос'
    );

    private $nav_arr = array(
        '#wrapper' => 'Наверх',
        '#photos-bar' => 'Фото и описания',
        '#facility-bar' => 'Услуги и оборудование',
        '#location-bar' => 'Расположение',
        '#map-bar' => 'Карта',
        '/?op=villa&act=book&ref={VILLA_ID}' => 'Цены и бронирование',
        '/?op=comments&act=show&villa_id={VILLA_ID}' => 'Отзывы',
        '/?op=query&act=new&villa_id={VILLA_ID}' => 'Задать вопрос'
    );

    private $period_arr = array('per night' => 'в сутки', 'per week' => 'в неделю');

    function getPageData()
    {        
        $villa_id = DVS::getVar('villa_id');
        $match = $this->getVilla($villa_id);



        if(!$match) {
            //$this->show404();
            $this->nocache = true;
            return;
        }

        //echo '<pre>';
        //print_r($match['rate']);

        /*
        if ($rate = saveData::getRate($match['rate'])) {
            $match['minprice'] = $rate['min'];
            $match['maxprice'] = $rate['max'];
            $match['currency'] = $rate['cur'];
            $match['period'] = $rate['period'];
        }
        */

        //echo '<pre>';
        //print_r($match);
        //exit;

        /*
        if (!$this->db_obj->N) {
            $this->show404();
            $this->nocache = true;
        }
        */
        $this->createTemplateObj();
        $this->db_obj->id = $villa_id;

        $nav = $this->showNavigation();

        $currency = preg_replace("/ВЈ/", "", $match['currency']);

        $currency = 'GBP';

        //$nav = $this->db_obj->showNavigation($this->template_obj);

        $this->template_obj->loadTemplateFile('villa_show.tpl');
        
            $this->template_obj->setVariable(array(
            'VILLA_ID' => $villa_id,
            'TITLE' => $match['title'],
            'SUMMARY' => $match['summary'],
            'PROPTYPE' => trim($match['type']),
            'SLEEPS_NUM' => $match['sleeps'],
            'BATHROOMS' => $match['bathroom'],
            'BEDROOMS' => $match['bedroom'],
            'MIN_PRICE' => $match['price'],
            
            //'MIN_PRICE' => DBO_Villa::getPrice($match['minprice']),
            //'MAX_PRICE' => DBO_Villa::getPrice($match['maxprice']),
            'CURRENCY' => $currency,
            //'week' => $this->period_arr[$match['period']],
            'COMMENTS_CNT' => $match['reviews'],
            'RATING' => $match['index'],
            'LOCATION_DESCRIPTION' => $this->db_obj->extra_rus ? $this->db_obj->extra_rus : $this->db_obj->extra,
            'VILLA_NAV' => $nav,
            
            //'EURO_PRICE' => $this->db_obj->euroPrice($this->db_obj->minprice).' - '.$this->db_obj->euroPrice($this->db_obj->maxprice),
            //'CAPTION' => $images_obj->caption,
            ));

            if ($currency != 'EUR') {
                //$this->template_obj->setVariable(array('EURO_PRICE' => DBO_Villa::euroPrice($match['minprice'], $currency)));
            }
        
        //$this->showRate(&$match);
        $this->showDescriptions(&$match);
        
        //$this->showUserOptions();
        $this->showOptions2($match);
         $this->showImages($match['img']);
       
        if ($match['map']) {
            $this->showMap($match);
        }
        //$this->showLinks();

        $this->template_obj->setGlobalVariable($this->lang_ru);

        $page_arr['BREADCRUMB'] = $this->showLocation($match);
        $page_arr['BODY_CLASS']   = 'property';
        $page_arr['BODY_EVENT']   = ' onload="initialize()"';
        $page_arr['PAGE_TITLE'] = $this->db_obj->title_rus.' - '.$this->region_title_t.' - Аренда вилл - '.$this->layout_obj->project_title;
        $page_arr['CENTER_TITLE']   = $this->db_obj->name;
        $page_arr['CENTER']         = $this->template_obj->get();
        $page_arr['JSCRIPT']        = $this->page_arr['JSCRIPT'];

        //$save_obj = new saveData;
        //$db_obj = DVS_Dynamic::createDbObj('villa');
        //$save_obj->insertVilla($match, $db_obj, 1);

        return $page_arr;
    }

    /**
     Получение виллы с homeaway.com
    */
    function getVilla($villa_id)
    {
        $data_obj = new GetData;
        $data_obj->data_url['Search']['url'] = '/'.$villa_id;
        $data_obj->data_url['Search']['params'] = array();
        $data_obj->data_url['Search']['method'] = 'get';
        
        //$body = file_get_contents('Malta.htm');
        $body = $data_obj->requestData('Search');
        //echo $body;
        //exit;
        if (strlen($body) > 1024) {
            if ($match = $data_obj->parseVilla($body, $villa_id)) {
                return $match;
            }
        }
        //echo  $data_obj->error;
        return false;
    }



    function commentsCnt()
    {
        $comments_obj = DB_DataObject::factory('comments');
        $comments_obj->villa_id = $this->db_obj->id;
        return $comments_obj->count();
    }

    function showLocation($match)
    {
        //print_r($match['region_id']);
        $location = $match['location'];
        //DB_DataObject::DebugLevel(1);
        $countries_obj = DB_DataObject::factory('countries');
        $countries_obj->get('name', $location);

        if ($countries_obj->id) {

        $countries_obj->getParent($countries_obj->id);
        $this->region_title_t = $countries_obj->region_title_t;
        return $countries_obj->region_title;
        }
        
    }

    function showDescriptions($match)
    {
            $this->template_obj->setVariable(array(
            'DESCRIPTION_TITLE' => $match['description_title'],
            'DESCRIPTION_BODY' => $match['description'].'<br>'.$match['extra'][0],
                ));
            $this->template_obj->parse('DESRIPTION');
    }


    function showUserOptions()
    {
        //$this->template_obj->setVariable(array('LOCATION_TITLE' => 'Окрестности'));
        //$this->template_obj->parse('ROW');

        $user_options_obj = DB_DataObject::factory('user_options');
        $user_options_obj->villa_id = $this->db_obj->id;
        $user_options_obj->find();
        while ($user_options_obj->fetch()) {
                $this->template_obj->setVariable(array(
                    'LOCATION_NAME' => $user_options_obj->user_location,
                     'DISTANCE' => $user_options_obj->distance,
                    ));
            $this->template_obj->parse('USER_LOCATION');
        }
    }

/**
[img] => Array
        (
            [0] => Array
                (
                    [0] => http://imageseu.holiday-rentals.co.uk/vd2/files/HR/400x300/9g/1022051/425783_1245318645850.jpg
                )

            [1] => Array
                (
                    [0] => .2nd Bourse apartment rental - Spacious Paris apartment in the 2nd arrondissement
                )

        )

*/
    function showImages($img_arr)
    {
        $i = 0;
        while ($img_arr[0][$i]) {
            if ($i == 0) {
                    $this->template_obj->setVariable(array(
                                'M_PHOTO_SRC' => $img_arr[0][$i],
                                'M_ALT_TEXT' => $img_arr[1][$i],
                                'M_CAPTION' => $img_arr[1][$i],
                                ));
            }
            $this->template_obj->setVariable(array(
                'PHOTO_SRC' => $img_arr[0][$i],
                'ALT_TEXT' => $img_arr[1][$i],
                'CAPTION' => $img_arr[1][$i],
            ));
            $this->template_obj->parse('GALLERY_PHOTO');
            if ($i%2) {
                $this->template_obj->parse('GALLERY_ROW');
            }
            $i++;
            //$this->template_obj->setVariable(array('CONTENT_PATH' => '/'.$images_obj->file_name, 'ALT_LABEL' => $images_obj->caption));
            //$this->template_obj->parse('ROW');
        }
    }

    /**
     [opt] => Array
        (
            [Floor Area] => Array
                (
                    [0] => 2070 sq. ft.
                )

            [Bathrooms] => Array
                (
                    [0] => 2 Bathrooms
                    [1] => The master bath is very elegant and spacious with his and hers sinks, a whirlpool tub, a huge separate shower area and tile and marble throughout. The second bath is also tile and marble with a tub/shower combination. The second bath also serves as a pool bath with an entrance from the lanai.
                )

            [Bedrooms] => Array
                (
                    [0] => 3 Bedrooms, Sleeps 7
                    [1] => All bedrooms are furnished with beautiful Florida style furniture and luxury linens.  Each bedroom has its own television and ceiling fan.
                )

        )
     */
    function showOptions($match)
    {
        $opt_arr = $match['opt'];
        //$option_groups_obj = DB_DataObject::factory('option_groups');
        $cur_group = '';
        //DB_DataObject::DebugLevel(1);
        foreach ($opt_arr as $group => $group_arr) {
            if ($group == 'Notes') {
                $this->template_obj->setVariable(array('GROUP_NAME' => 'Дополнительно'));
                $this->template_obj->setVariable(array('OPTION' => $match['notes'][0]));
                $this->template_obj->parse('OPTION_COL');
                $this->template_obj->parse('OPTION_GROUP');
                continue;
            }
            $option_groups_obj = DB_DataObject::factory('option_groups');
            $option_groups_obj->get("name", $group);
            if ($option_groups_obj->rus_name) {
                $group = $option_groups_obj->rus_name;
            }
            $this->template_obj->setVariable(array('GROUP_NAME' => $group));


            foreach ($group_arr as $k => $name) {
                $this->template_obj->setVariable(array('OPTION' => $name));
                //$this->template_obj->setVariable(array('OPTION' => $villa_opt_obj->rus_name));
                $this->template_obj->parse('OPTION');
            }
            
            if ($cur_group != $group) {
                $this->template_obj->parse('OPTION_COL');
                $this->template_obj->parse('OPTION_GROUP');
            }
            $cur_group = $group;

        }

    }

    function showLinks()
    {

      $this->template_obj->setVariable(array('LINK' => $this->db_obj->qs.'&act=book&id='.$this->db_obj->id, 'LINK_NAME' => 'Бронировать'));
            $this->template_obj->parse('LINK');

      $this->template_obj->setVariable(array('LINK' => '?op=comments&act=show&villa_id='.$this->db_obj->id, 
          'LINK_NAME' => 'Отзывы'));
            $this->template_obj->parse('LINK');


        $this->template_obj->parse('ROW');
    }

    function showNavigation()
    {
        //$this->template_obj->addBlockFile('VILLA_NAV', 'VILLA_NAV', 'villa_nav.tpl');

        $this->template_obj->loadTemplateFile('villa_nav.tpl');
        $i = 1;
        foreach ($this->nav_arr as $link => $text) {
            $link = str_replace('{VILLA_ID}', $this->db_obj->id, $link);
            $this->template_obj->setVariable(array(
                'nav_link' => $link, 
                'nav_text' => $text,
                'nav_class' => $i == sizeof($this->nav_arr) ? ' class=last' : ''
                )
            );
            $i++;
            //$this->template_obj->setVariable(array('VILLA_ID' => 1));
            $this->template_obj->parse('NAV_ITEM');
        }
        return $this->template_obj->get();
    }

    function showMap($match)
    {
        $lon = $match['map'][0];
        $lat = $match['map'][1];
        $this->src_files = array(
            'JS_SRC' => array("http://maps.google.com/maps/api/js?sensor=false")
            );
        $this->page_arr['JSCRIPT'] = '				  function initialize() {
					var latlng = new google.maps.LatLng('.$lat.', '.$lon.');
					var myOptions = {
					  zoom: 12,
                      scrollwheel: false,
					  center: latlng,
					  mapTypeId: google.maps.MapTypeId.ROADMAP
					};
					var map = new google.maps.Map(document.getElementById("g-map"), myOptions);
                    var beachMarker = new google.maps.Marker({
      position: latlng,
      map: map
  });

				  }';
        $this->template_obj->touchBlock('LOCATION_MAP');
    }

/**
Array
(
    [0] => Array
        (
            [0] =>  Nightly Rate
            [1] =>  Weekly Rate
            [2] =>  Monthly Rate
        )

    [1] => Array
        (
            [0] => (GBP)
					
            [1] => 
            [2] => 
        )

    [2] => Array
        (
            [0] => GBP
            [1] => 
            [2] => 
        )

    [3] => Array
        (
            [0] => ВЈ
            [1] => ВЈ
            [2] => ВЈ
        )

    [4] => Array
        (
            [0] => 200
            [1] => 750
            [2] => 1,500
        )

    [5] => Array
        (
            [0] => 
            [1] =>  - 
									ВЈ1,100
            [2] =>  - 
									ВЈ4,000
        )

    [6] => Array
        (
            [0] => 
            [1] => ВЈ
            [2] => ВЈ
        )

    [7] => Array
        (
            [0] => 
            [1] => 1,100
            [2] => 4,000
        )

)
*/
    function showRate($match)
    {
        $rate_arr = $match['rate'];
        //echo '<pre>';
        //print_r($rate_arr);
        $cur_arr = array('в‚¬' => 'EUR', 'ВЈ' => 'GBP', '$' => 'USD');
        if ($rate_arr[3][0]) {
            $this->template_obj->setVariable(array('CURRENCY' => $cur_arr[$rate_arr[3][0]]));
            $ret['cur'] = $rate_arr[2][0];
        }
        foreach ($rate_arr[0] as $k => $v) {
                $this->template_obj->setVariable(array(
                    'MIN_PRICE' => DBO_Villa::getPrice((int)str_replace(',', '', $rate_arr[4][$k])),
                    'MAX_PRICE' => $rate_arr[7][$k] ? ' - '.DBO_Villa::getPrice((int)str_replace(',', '', $rate_arr[7][$k])) : '',
                    'PERIOD' => $v,
                ));
                $this->template_obj->parse('RATE');
        }
        return;
    }

    function showOptions2($match)
    {
        $opt_arr = $match['opt'];
        //print_r($match['opt']);
        //$option_groups_obj = DB_DataObject::factory('option_groups');
        $cur_group = '';
        //DB_DataObject::DebugLevel(1);
        foreach ($opt_arr as $group => $group_arr) {
            $option_groups_obj = DB_DataObject::factory('option_groups');
            $option_groups_obj->get("name", $group);
            if ($option_groups_obj->rus_name) {
                $group = $option_groups_obj->rus_name;
            }
            $this->template_obj->setVariable(array('GROUP_NAME' => $group));


            foreach ($group_arr as $k => $name) {
                $this->template_obj->setVariable(array('OPTION' => $name));
                //$this->template_obj->setVariable(array('OPTION' => $villa_opt_obj->rus_name));
                $this->template_obj->parse('OPTION');
            }
            
            if ($cur_group != $group) {
                $this->template_obj->parse('OPTION_COL');
                $this->template_obj->parse('OPTION_GROUP');
            }
            $cur_group = $group;

        }

    }
}

?>