<?php
/**
 * Карточка виллы
 * @package villarenters.ru
 * $Id: Villa_Show.php 397 2015-05-19 10:19:55Z xxserg $
 */

require_once COMMON_LIB.'DVS/Dynamic.php';

class Project_Villa_Show extends DVS_Dynamic
{
    // Права
    public $perms_arr = array('ar' => 1, 'oc' => 1, 'iu' => 1, 'mu' => 1,);

    private $change_content = true;

    private $lang_ru = array(
        'Rates' => 'Цены',
        'week' => 'в неделю',
        'Sleeps' => 'спальных мест',
        'details' => 'Подробнее...',
        'booking' => 'Забронировать',
        'Bathrooms' => 'Ванная комната',
        'Facilities' => 'Услуги',
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
        '/?op=villa&act=book&id={VILLA_ID}' => 'Цены и бронирование',
        '/?op=comments&act=show&villa_id={VILLA_ID}' => 'Отзывы',
        '/?op=query&act=new&villa_id={VILLA_ID}' => 'Задать вопрос'
    );

   private $places = array(
        'airport' => 'аэропорт',
        'amusement_park' => 'парк&nbsp;развлечений',
        'bar' => 'бар',
        'cafe' => 'кафе',
        'car_rental' => 'прокат авто',
        'food' => 'питание',
        'grocery_or_supermarket' => 'рынок',
        'gym' => 'спорт зал',
        'liquor_store' => 'алкоголь',
        'museum' => 'музей',
        'night_club' => 'ночной клуб',
        'park' => 'парк',
        'parking' => 'парковка',
        'restaurant' => 'ресторан',
        'shopping_mall' => 'гипермаркет',
        'spa' => 'спа',
        'store' => 'магазин',
        'taxi_stand' => 'такси',
        'train_station' => 'ж/д станция',
        'zoo' => 'зоопарк',
        );

    function getPageData()
    {
        /*
        $db = DVS::getVar('db');
        if ($db == 'r') {
            //echo 'rr';
            $id = DVS::getVar('vid');
            $db = $this->db_obj->getDatabaseConnection();
            $db->disconnect();
            $this->db_obj->database('rurenter');
            $this->db_obj->get($id);
            //exit;
        }
        */
        if (!$this->db_obj->N) {
            $this->show404();
            $this->nocache = true;
        }

        $this->createTemplateObj();

        //$places_form = $this->showPlaces();
        //print_r( $form);
        //$nav = $this->showNavigation();

        $nav = $this->db_obj->showNavigation($this->template_obj);

        if ($this->role != 'mu') {
            $template_name = 'villa_show.tpl';
        } else {
            $template_name = 'villa_show_m.tpl';
        }

        $this->template_obj->loadTemplateFile($template_name);
        $page_arr['BREADCRUMB'] = $this->showLocation();

        $db = $this->db_obj->getDatabaseConnection();
        $db->disconnect();

        $this->db_obj->database('xserg');

            $this->template_obj->setVariable(array(
            'VILLA_ID' => $this->db_obj->id,
            'TITLE' => $this->db_obj->title_rus.', '.$this->region_title_p,
            'SUMMARY' => $this->db_obj->summary_rus,
            'PROPTYPE' => $this->db_obj->propTypeName($this->db_obj->proptype),
            'SLEEPS_NUM' => $this->db_obj->sleeps,
            'pay_period' => $this->db_obj->getPay_periodName(),
            'MIN_PRICE' => $this->db_obj->minprice,
            'MAX_PRICE' => $this->db_obj->maxprice,
            'CURRENCY' => preg_replace("/ВЈ/", "", $this->db_obj->currency),
            'COMMENTS_CNT' => $this->commentsCnt(),
            'RATING' => $this->db_obj->villarentersindex,
            'LOCATION_DESCRIPTION' => $this->db_obj->extra_rus ? $this->db_obj->extra_rus : $this->db_obj->extra,
            'VILLA_NAV' => $nav,
            'EURO_PRICE' => $this->db_obj->euroPrice($this->db_obj->minprice).' - '.$this->db_obj->euroPrice($this->db_obj->maxprice),
            'Owner' => $this->db_obj->user_id == LETINTHESUN_ID ? '<br>LTS' : '',
            //'CAPTION' => $images_obj->caption,
        //'PLACES_FORM' => $this->showPlaces(),
            ));

        $this->showDescriptions();

        $this->showUserOptions();
        $this->showOptions();
        $this->showImages();

        if ($this->db_obj->lat && $this->db_obj->lon && $this->role != 'mu') {
            $this->showMap();
            $this->template_obj->setVariable(array('PLACES_FORM' => $this->showPlaces(),));
        }
        //$this->showLinks();

        $this->template_obj->setGlobalVariable($this->lang_ru);

        $this->template_obj->setVariable(array('PLUSO' => file_get_contents(PROJECT_ROOT.'tmpl/pluso.tpl')));
        //$this->template_obj->setVariable(array('PLUSO' => file_get_contents(PROJECT_ROOT.'tmpl/share42.tpl')));


        $page_arr['BODY_CLASS']   = 'property';
        $page_arr['BODY_EVENT']   = ' onload="initialize()"';
        $page_arr['PAGE_TITLE'] = $this->db_obj->title_rus.' - '.$this->region_title_t.' - Аренда вилл - '.$this->layout_obj->project_title;
        //$page_arr['CENTER_TITLE']   = $this->db_obj->name;
        $page_arr['CENTER']         = $this->template_obj->get();
        $page_arr['JSCRIPT']        = $this->page_arr['JSCRIPT'];
        return $page_arr;
    }

    function commentsCnt()
    {
        $comments_obj = DB_DataObject::factory('comments');
        $comments_obj->villa_id = $this->db_obj->id;
        return $comments_obj->count();
    }

    function showLocation()
    {
        $countries_obj = DB_DataObject::factory('countries');
        $countries_obj->getParent($this->db_obj->location);
        $this->region_title_t = $countries_obj->region_title_t;
        $this->region_title_p =  $countries_obj->region_title_p;
        return $countries_obj->region_title;
    }

    function showDescriptions()
    {
        $this->template_obj->setVariable(array('ZAG' => ''));
        $this->template_obj->parse('ROW');

        $description_obj = DB_DataObject::factory('descriptions');
        $description_obj->villa_id = $this->db_obj->id;
        $description_obj->find();

        while ($description_obj->fetch()) {
            $this->template_obj->setVariable(array(
                    'DESCRIPTION_TITLE' => $description_obj->title_rus ? $description_obj->title_rus : $description_obj->title,
                    'DESCRIPTION_BODY' => $description_obj->body_rus ? $description_obj->body_rus : $description_obj->body,
                ));
            $this->template_obj->parse('DESRIPTION');
        }
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

    function showImages()
    {
        $images_obj = DB_DataObject::factory('images');
        $images_obj->villa_id = $this->db_obj->id;
        $images_obj->orderBy('file_name');
        $images_obj->find();
        $i = 1;
        while ($images_obj->fetch()) {
            if ($i == 1) {
                    $this->template_obj->setVariable(array(
                                'M_PHOTO_SRC' => $this->db_obj->imageURL().$images_obj->file_name,
                                'M_ALT_TEXT' => $images_obj->caption,
                                'M_CAPTION' => $images_obj->caption,
                                ));
            }
            $this->template_obj->setVariable(array(
                //'PHOTO_SRC' => VILLARENTERS_IMAGE_URL.$images_obj->file_name,
                'PHOTO_SRC' => $this->db_obj->imageURL().$images_obj->file_name,
                'ALT_TEXT' => $images_obj->caption,
                'CAPTION' => $images_obj->caption,
            ));
            $this->template_obj->parse('GALLERY_PHOTO');
            $i++;
            if ($i%2) {
                $this->template_obj->parse('GALLERY_ROW');
            }
            //$this->template_obj->setVariable(array('CONTENT_PATH' => '/'.$images_obj->file_name, 'ALT_LABEL' => $images_obj->caption));
            //$this->template_obj->parse('ROW');
        }
    }

    function showOptions()
    {
        //DB_DataObject::DebugLevel(1);
        $villa_opt_obj = DB_DataObject::factory('villa_options');
        $villa_opt_obj->villa_id = $this->db_obj->id;

        $option_groups_obj = DB_DataObject::factory('option_groups');
        //$option_groups_obj->selectAs(array('name', 'rus_name'), 'group_%s', 'option_groups');

        $options_obj = DB_DataObject::factory('options');
        $options_obj->joinAdd($option_groups_obj);
        $villa_opt_obj->joinAdd($options_obj);
        $villa_opt_obj->selectAs();
        $villa_opt_obj->selectAs(array('id', 'name', 'rus_name'), '%s', 'options');
        $villa_opt_obj->selectAs(array('id', 'name', 'rus_name'), 'group_%s', 'option_groups');
        $villa_opt_obj->orderBy('group_name');
        $villa_opt_obj->find();

        $cur_group = '';
        while ($villa_opt_obj->fetch()) {
            //$this->template_obj->setVariable(array('KEY' => $villa_opt_obj->group_name.' '.$villa_opt_obj->name, 'VAL' => $villa_opt_obj->value));
            if ($cur_group != $villa_opt_obj->group_name) {
                $this->template_obj->parse('OPTION_COL');
                $this->template_obj->parse('OPTION_GROUP');
            }

            if ($villa_opt_obj->value != 0) {
                $this->template_obj->setVariable(array('GROUP_NAME' => $villa_opt_obj->group_rus_name));
                //$this->template_obj->setVariable(array('OPTION' => $villa_opt_obj->rus_name.' '.($villa_opt_obj->value != 1 ? $villa_opt_obj->value : '')));
                $this->template_obj->setVariable(array('OPTION' => $villa_opt_obj->rus_name.' '.($villa_opt_obj->value != 1 && !preg_match("/away/i", $villa_opt_obj->value) ? $villa_opt_obj->value : '')));
                //$this->template_obj->setVariable(array('OPTION' => $villa_opt_obj->rus_name));
                $this->template_obj->parse('OPTION');
            }

            $options_arr[$villa_opt_obj->group_name][$villa_opt_obj->name] = $villa_opt_obj->value;
            $cur_group = $villa_opt_obj->group_name;
            if ($villa_opt_obj->id == 5) {
                $this->template_obj->setVariable(array('BATH' => $villa_opt_obj->value));
            }

            if ($villa_opt_obj->group_id == 4 && $villa_opt_obj->value != 0) {
                $facilities .= $villa_opt_obj->rus_name.'<br>';
            }

        }

        $this->template_obj->setVariable(array('FACILITY' => $facilities));

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

    function showMap()
    {
        $radius = 500;
        $zoom = 12;
        $pictures = $_POST['pictures'];
        if ($_POST['place']) {
            foreach ($_POST['place'] as $name => $v) {
                $type_str .= ($type_str ? ',' : '')."'".$name."'";
            }
            if ($_POST['radius']) {
                $radius = DVS::getVar('radius', 'int', 'post');
                switch ($radius) {
                   case 500:
                    $zoom = 16;
                    break;
                   case 1000:
                   case 2000:
                    $zoom = 15;
                    break;
                   case 3000:
                   $zoom = 14;
                    break;
                   case 5000:
                   $zoom = 13;
                    break;

                   case 10000:
                    $zoom = 11;
                    break;
                   default:
                    $zoom = 12;
                }
            }
        }
        $this->src_files = array(
            'JS_SRC' => array("http://maps.google.com/maps/api/js?sensor=false&libraries=places,panoramio")
            );
        $this->page_arr['JSCRIPT'] = '
    var map;
    var infowindow;
    function initialize() {
        var latlng = new google.maps.LatLng('.$this->db_obj->lat.', '.$this->db_obj->lon.');
        var myOptions = {
          zoom: '.$zoom.',
          scrollwheel: false,
          center: latlng,
          mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var map = new google.maps.Map(document.getElementById("g-map"), myOptions);
    var beachMarker = new google.maps.Marker({
    position: latlng,
    map: map
    });';

    if ($type_str) {
    $this->page_arr['JSCRIPT'] .= '
    var request = {
      location: latlng,
      radius: '.$radius.',
      types: ['.$type_str.']
    };
    infowindow = new google.maps.InfoWindow();
    var service = new google.maps.places.PlacesService(map);
    service.search(request, callback);

    function callback(results, status) {
    if (status == google.maps.places.PlacesServiceStatus.OK) {
      for (var i = 0; i < results.length; i++) {
        createMarker(results[i]);
      }
    }
    }

    function createMarker(place) {
    var placeLoc = place.geometry.location;
    var marker = new google.maps.Marker({
      map: map,
      position: place.geometry.location,
      icon: place.icon

    });

    google.maps.event.addListener(marker, \'click\', function() {
        var details = {
          reference: place.reference
        };
        service.getDetails(details, function(result, status) {
            if (status == google.maps.places.PlacesServiceStatus.OK) {
                infowindow.setContent("<a href="+result.url+" target=_blank>"+result.name+"</a><br>"+result.vicinity+"<br>"+result.html_attributions);
                infowindow.open(map, marker);
            }
        });
    });
    }
    google.maps.event.addDomListener(window, \'load\', initialize);';
    }

        if ($pictures) {
        $this->page_arr['JSCRIPT'] .='
        var panoramioLayer = new google.maps.panoramio.PanoramioLayer();
        panoramioLayer.setMap(map);';

        }
        $this->page_arr['JSCRIPT'] .=   '}';
        $this->template_obj->touchBlock('LOCATION_MAP');
    }

/**
accounting airport amusement_park aquarium art_gallery atm
bakery bank bar beauty_salon bicycle_store book_store bowling_alley bus_station
cafe campground car_dealer car_rental car_repair car_wash casino cemetery church city_hall clothing_store
convenience_store courthouse dentist department_store doctor electrician electronics_store
embassy establishment finance fire_station florist food funeral_home furniture_store gas_station
general_contractor
geocode
grocery_or_supermarket
gym
hair_care
hardware_store
health
hindu_temple
home_goods_store
hospital
insurance_agency
jewelry_store
laundry
lawyer
library
liquor_store
local_government_office
locksmith
lodging
meal_delivery
meal_takeaway
mosque
movie_rental
movie_theater
moving_company
museum
night_club
painter
park
parking
pet_store
pharmacy
physiotherapist
place_of_worship
plumber
police
post_office
real_estate_agency
restaurant
roofing_contractor
rv_park
school
shoe_store
shopping_mall
spa
stadium
storage
store
subway_station
synagogue
taxi_stand
train_station
travel_agency
university
veterinary_care
zoo
*/
    function showPlaces()
    {
        require_once ("HTML/QuickForm.php");
        $form = new HTML_QuickForm('searchForm', 'POST', $_SERVER['REQUEST_URI'].'#map-bar');
        $form->addElement('header', '', 'Объекты<br>на расстоянии:');
        $form->addElement('select', 'radius', '', array(
            500 => '500m',
            1000 => '1 км',
            2000 => '2 км',
            3000 => '3 км',
            5000 => '5 км',
            10000 => '10 км',
            //15000 => '15 км'
        ));
        foreach ($this->places as $name => $label) {
            $form->addElement('checkbox', 'place['.$name.']', '', '&nbsp;'.$label);
        }
        $form->addElement('checkbox', 'pictures', '', '&nbsp;фотографии');
        $form->addElement('submit', '__submit__', 'Показать');
        $form->setDefaults($_GET);
        return $form->toHtml();

    }
}

?>
