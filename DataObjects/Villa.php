<?php
/**
 * Table Definition for villa
 */
require_once 'DB/DataObject.php';

class DBO_Villa extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'villa';                           // table name
    public $database = 'rurenter';                           // database name (used with database_{*} config)
    public $id;                              // int(4)  primary_key not_null
    public $user_id;                         // int(4)  
    public $proptype;                        // varchar(255)  
    public $title;                           // varchar(255)  
    public $title_rus;                       // varchar(255)   not_null
    public $summary;                         // varchar(255)  
    public $summary_rus;                     // varchar(255)  
    public $filename;                        // varchar(255)  
    public $location;                        // int(4)  
    public $locations_all;                   // varchar(255)   not_null
    public $minprice;                        // int(4)  
    public $maxprice;                        // int(4)  
    public $currency;                        // varchar(11)  
    public $sleeps;                          // int(4)  
    public $main_image;                      // varchar(255)   not_null
    public $lon;                             // float()   not_null
    public $lat;                             // float()   not_null
    public $maplink;                         // text()  
    public $extra;                           // text()  
    public $extra_rus;                       // text()  
    public $instantbooking;                  // tinyint(1)   not_null
    public $villarentersindex;               // int(4)   not_null
    public $special_offer;                   // tinyint(1)   not_null
    public $translation_status;              // tinyint(1)   not_null
    public $src_site;                        // varchar(255)   not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DBO_Villa',$k,$v); }

    function table()
    {
         return array(
             'id' =>  DB_DATAOBJECT_INT + DB_DATAOBJECT_NOTNULL,
             'user_id' =>  DB_DATAOBJECT_INT,
             'proptype' =>  DB_DATAOBJECT_STR,
             'title' =>  DB_DATAOBJECT_STR,
             'title_rus' =>  DB_DATAOBJECT_STR + DB_DATAOBJECT_NOTNULL,
             'summary' =>  DB_DATAOBJECT_STR,
             'summary_rus' =>  DB_DATAOBJECT_STR,
             'filename' =>  DB_DATAOBJECT_STR,
             'location' =>  DB_DATAOBJECT_INT,
             'locations_all' =>  DB_DATAOBJECT_STR + DB_DATAOBJECT_NOTNULL,
             'minprice' =>  DB_DATAOBJECT_INT,
             'maxprice' =>  DB_DATAOBJECT_INT,
             'currency' =>  DB_DATAOBJECT_STR,
             'sleeps' =>  DB_DATAOBJECT_INT,
             'main_image' =>  DB_DATAOBJECT_STR + DB_DATAOBJECT_NOTNULL,
             'lon' =>  DB_DATAOBJECT_INT + DB_DATAOBJECT_NOTNULL,
             'lat' =>  DB_DATAOBJECT_INT + DB_DATAOBJECT_NOTNULL,
             'maplink' =>  DB_DATAOBJECT_STR + DB_DATAOBJECT_TXT,
             'extra' =>  DB_DATAOBJECT_STR + DB_DATAOBJECT_TXT,
             'extra_rus' =>  DB_DATAOBJECT_STR + DB_DATAOBJECT_TXT,
             'instantbooking' =>  DB_DATAOBJECT_INT + DB_DATAOBJECT_BOOL + DB_DATAOBJECT_NOTNULL,
             'villarentersindex' =>  DB_DATAOBJECT_INT + DB_DATAOBJECT_NOTNULL,
             'special_offer' =>  DB_DATAOBJECT_INT + DB_DATAOBJECT_BOOL + DB_DATAOBJECT_NOTNULL,
             'translation_status' =>  DB_DATAOBJECT_INT + DB_DATAOBJECT_BOOL + DB_DATAOBJECT_NOTNULL,
             'src_site' =>  DB_DATAOBJECT_STR + DB_DATAOBJECT_NOTNULL,
         );
    }

    function keys()
    {
         return array('id');
    }


    function defaults() // column default values 
    {
         return array(
             '' => null,
         );
    }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

    function sequenceKey() // keyname, use native, native name
    {
        return $this->disable_sk ? array() : array('id', false, false);
    }

    public $listLabels   = array(
             'main_image' => '',
             'title' =>  '',
             //'summary' =>  '',
    );

    public $qs_arr = array('loc');

    public $prop_type_arr = array(
        'apartment' => 'апартамент',
        'boat' => 'лодка',
        'cabin' => 'домик',
        'castle' => 'замок',
        'chateau' => 'шато',
        'cottage' => 'коттедж',
        'country house' => 'дом на природе',
        'farm house' => 'ферма',
        'house' => 'дом',
        'lodge' => 'lodge',
        'room/studio' => 'студия',
        'penthouse' => 'пентхауз',
        'finca' => 'finca',
        'ski chalet' => 'лыжный домик',
        'gite' => 'gite',
        'villa' => 'вилла',
        'village house' => 'деревенский дом',
    );

    public $sleeps_arr = array(
        2 => '2',
        4 => '4',
        6 => '6',
        8 => '8',
        10 => 10,
        12 => 12,
        14 => 14,
        16 => 16,
        18 => 18,
        20 => 20
    );

    public $currency_arr = array('RUR' => 'Руб.', 'USD' => 'USD', 'EUR' => 'EUR');

    public $pay_period_arr = array(1 => 'в неделю', 2 => 'в сутки');

    public $pay_period_arr_en = array(1 => 'per week', 2 => 'per night');

/*
    public $prop_type_arr = array(
        'villa' => 'вилла',
        'apartment' => 'аппартамент',
        'cabin' => 'домик',
        'country house' => 'деревенский дом'
    );
*/
    public $default_sort = 'id';

    //public $search_arr = array('fields_search' => array('title', 'id'));

    private $translation_status_arr = array( 0 => 'Нет', 1 => 'Новый', 2 => 'Проверен');

    public $nav_arr = array(
        '#wrapper' => 'Наверх',
        '#photos-bar' => 'Фото и описания',
        '#location-bar' => 'Расположение',
        '#facility-bar' => 'Услуги и оборудование',
        '#map-bar' => 'Карта',
        //'/?op=villa&act=book&id={VILLA_ID}' => 'Цены и бронирование',
        'http://rurenter.ru/?op=booking&act=user&villa_id={VILLA_ID}' => 'Цены и бронирование',
        '/?op=comments&act=show&villa_id={VILLA_ID}' => 'Отзывы',
        '/?op=query&act=new&villa_id={VILLA_ID}' => 'Задать вопрос'
    );

    function tableRow()
    {

        return array(
            'main_image' => '<a href="?op=villa&act=show&id='.$this->id.'"><img src='.VILLARENTERS_IMAGE_URL.$this->main_image.'></a>',
            'title'      => '<a href="?op=villa&act=show&id='.$this->id.'">'.$this->title.'</a><br>'.$this->summary,
            'summary' => $this->summary,
        );
    }

    function createObjs()
    {
        $this->descriptions_obj = DB_DataObject::factory('descriptions');
        $this->user_options_obj = DB_DataObject::factory('user_options');
        $this->images_obj = DB_DataObject::factory('images');
        $this->villa_options_obj = DB_DataObject::factory('villa_options');

        $this->comments_obj = DB_DataObject::factory('comments');
    }

    function preDelete()
    {
        //echo 'preDelete';
        $this->createObjs();
        $this->descriptions_obj->villa_id = $this->id;
        $this->descriptions_obj->delete();
        $this->user_options_obj->villa_id = $this->id;
        $this->user_options_obj->delete();

        $this->images_obj->villa_id = $this->id;
        $this->images_obj->delete();
        
        $this->villa_options_obj->villa_id = $this->id;
        $this->villa_options_obj->delete();

        $this->comments_obj->villa_id = $this->id;
        $this->comments_obj->delete();
        return true;
    }

    function preGenerateList()
    {
        $alias = DVS::getVar('alias');
        //echo $alias;
        $location_id = DVS::getVar('loc');
        $keyword = DVS::getVar('keyword');

        $user_id = DVS::getVar('user_id');

        if ($user_id) {
            $this->user_id = $user_id;
        }

        if ($this->translation_status == '') {
            unset($this->translation_status);
        }

        $st = DVS::getVar('st');

        if ($st) {
            if (preg_match("/[0-9]+/",$st)) {
                $this->id=intval($st);
            } else {
                $this->whereAdd('title LIKE "%'.$st.'%" OR title_rus LIKE "%'.$st.'%"');
            }
        }

        if ($keyword) {

            if (preg_match("/^[0-9]+/",$keyword)) {
                $this->id=intval($keyword);
                 $this->region_title = 'Поиск "'.$keyword.'"';
                return true;
            }

            //echo $keyword;
            if (preg_match("/[a-z]+/", $keyword)) {
                $country_field = 'name';
                $title_field = 'title';
            } else {
                $country_field = 'rus_name';
                $title_field = 'title_rus';
            }
            $countries_obj = DB_DataObject::factory('countries');
            $countries_obj->whereAdd('parent_id > 0');
            $countries_obj->whereAdd($country_field.' LIKE "'.$keyword.'%"');
            $countries_obj->find();
            while ($countries_obj->fetch()) {
                //$this->whereAdd('locations_all LIKE "%:'.$countries_obj->id.':%"', 'OR');
                $loc_str .= ($loc_str ? ' OR ' : '').'locations_all LIKE "%:'.$countries_obj->id.':%"';
            }
            if ($loc_str) {
                $this->whereAdd($loc_str);
            }
            if ($countries_obj->N == 0) {
                $this->whereAdd($title_field.' LIKE "%'.$keyword.'%"');
            }
            $this->region_title = 'Поиск "'.$keyword.'"';
        }

        if ($alias == 'world') {
            return true;
        }

        if ($alias) {
            if (preg_match("!\/!", $alias)) {
                $loc_arr = explode('/', $alias);
                $alias = $loc_arr[sizeof($loc_arr) - 2];
            }
            $countries_obj = DB_DataObject::factory('countries');
            $db = $this->database();
            $countries_obj->database($db);
            $countries_obj->get('name', str_replace(array('_and_', "_"), array(" & ", " "), $alias));
            $this->location_id = $countries_obj->id;
            $countries_obj->getParent($countries_obj->id);
            //echo $countries_obj->region_title.'<br>'.$countries_obj->locations_all;
            //$location_id = $countries_obj->id;
            if (!$countries_obj->locations_all) {
                return false;
            }
            $this->whereAdd('locations_all LIKE ":'.$countries_obj->locations_all.':%"');
            $this->region_title = $countries_obj->region_title_a;
            $this->region_title_t = $countries_obj->region_title_t;
            $this->region_title_p = $countries_obj->region_title_p;
        }

        //exit;
        if ($location_id) {

            $this->whereAdd('locations_all LIKE "%:'.$location_id.':%"');
            $countries_obj = DB_DataObject::factory('countries');
            $countries_obj->getParent($location_id);
             $this->center_title = $countries_obj->region_title_a;
            /*
            $countries_obj = DB_DataObject::factory('countries');
            $countries_obj->getChilds($location_id);

            //print_r($countries_obj->loc_arr);
            foreach ($countries_obj->loc_arr as $k => $v) {
                $str .= ($str ? ',' : '').$v;
            }
            $this->whereAdd('location IN ('.$str.')');
            */
        }
        return true;
    }

    function propTypeName($name)
    {
        if (isset($this->prop_type_arr[$name])) {
            return $this->prop_type_arr[$name];
        } else {
            return $this->prop_type_arr['villa'];
        }
    }

    function deleteVillasByLocation($location_id)
    {
            $countries_obj = DB_DataObject::factory('countries');
            $countries_obj->getParent($location_id);
            $this->whereAdd('translation_status=0 OR translation_status=2');
            $this->whereAdd('locations_all LIKE ":'.$countries_obj->locations_all.':%"');
            $this->find();
            echo $this->N.'<br>';
            while ($this->fetch()) {
                echo $this->id.' '.$this->title.'<br>';
                $this->preDelete();
                echo $this->delete();
            }
    }

    function saveDescr($descr)
    {
        foreach ($descr as $id => $vals) {
            $descriptions_obj = DB_DataObject::factory('descriptions');
            $descriptions_obj->get($id);
            $descriptions_obj->title_rus = $vals['title_rus'];
            $descriptions_obj->body_rus = $vals['body_rus'];
            $descriptions_obj->update();
        }
    }

    //Вывод формы
    function getForm()
    {
        $form =& new HTML_QuickForm('', '', $_SERVER['REQUEST_URI'], '');
        $form->addElement('header', null, ($this->act == 'new' ? DVS_NEW : DVS_EDIT).' '.$this->head_form);
        
        $t1 = $form->createElement('text', 'title', '', 'size=50');
        $t2 = $form->createElement('text', 'title_rus', '', 'size=50');
        
        $form->addGroup(array($t1, $t2), '', 'Заголовок: ');
        $s1 = $form->createElement('textarea', 'summary', '', array('rows' => 5, 'cols' => 47));
        $s2 = $form->createElement('textarea', 'summary_rus', '', array('rows' => 5, 'cols' => 47));
        $form->addGroup(array($s1, $s2), '', 'Краткое описание: ');
        
        $e1 = $form->createElement('textarea', 'extra', '', array('rows' => 5, 'cols' => 47));
        $e2 = $form->createElement('textarea', 'extra_rus', '', array('rows' => 5, 'cols' => 47));
        $form->addGroup(array($e1, $e2), '', 'Дополнительно: ');

        $descriptions_obj = DB_DataObject::factory('descriptions');
        $descriptions_obj->editForm($this->id, $form);

        $form->addElement('select', 'translation_status', 'Перевод:', array(1 => 'Новый', 2 => 'Проверен', 0 => 'Нет'));
        $form->addElement('checkbox', 'special_offer', 'На главной:');

        $form->addElement('submit', '__submit__', DVS_SAVE);
        $form->addRule('name', DVS_REQUIRED.' "'.$this->fb_fieldLabels['name'].'"!', 'required', null, 'client');
        return $form;
    }

    function preProcessForm(&$vals, $fb)
    {
        //print_r($vals);
        $this->saveDescr($vals['descr']);
    }

    //Форма поиска для страницы администрирования
    function getSearchForm()
    {
        require_once('HTML/QuickForm.php');
        $form =& new HTML_QuickForm('search_form', 'get', $this->qs, '', 'class="search"');
        $form->addElement('hidden', 'op', $this->__table);
        $text = HTML_QuickForm::createElement('text', 'st', 'Искать: ', array('size' => '50'));
        $submit = HTML_QuickForm::createElement('submit', 'search', '>>');
        $status = HTML_QuickForm::createElement('select', 'translation_status', '', array('' => '') + $this->translation_status_arr);
        $form->addGroup(array($text,  $status,  $submit), '', 'Поиск &nbsp;', array(' перевод ', '&nbsp;'));
        
        return $form->toHtml().'<br><br>';
    }


    function showNavigation($tpl)
    {
        $tpl->loadTemplateFile('villa_nav.tpl');
        $i = 1;
        foreach ($this->nav_arr as $link => $text) {
            $link = str_replace('{VILLA_ID}', $this->id, $link);
            $tpl->setVariable(array(
                'nav_link' => $link, 
                'nav_text' => $text,
                'nav_class' => $i == sizeof($this->nav_arr) ? ' class=last' : ''
                )
            );
            $i++;
            $tpl->parse('NAV_ITEM');
        }
        return $tpl->get();
    }

    function currencyRate()
    {
        //$cur_file = PROJECT_ROOT.'conf/currency_rate.txt';
        $cur_file = PROJECT_ROOT.'../rurenter/conf/currency_rate.txt';
        $cur_str = file_get_contents($cur_file);
        preg_match_all("/([A-Z_]+)\t([0-9.]+)/", $cur_str, $cur_arr);
        //print_r($cur_arr);
        foreach ($cur_arr[1] as $k => $v) {
            $rate[strtolower($v)] = $cur_arr[2][$k];
        }
        return $rate;
        /*
        $eur_usd = $cur_arr[2][0]/$cur_arr[2][1];
        $eur_gbp = $cur_arr[2][0]/$cur_arr[2][2];
        //echo "eur_usd = $eur_usd, eur_gbp = $eur_gbp";
        return array('eur_usd' => $eur_usd, 'eur_gbp' => $eur_gbp);
        */
    }

    function euroPrice($price)
    {
        if ($this->currency == "E (EUR)") {
            return $price;
        } else {
            $rate = $this->currencyRate();
            if ($this->currency == "$ (USD)") {
                $price = $price / $rate['eur_usd'];
            } else if ($this->currency == "ВЈ (GBP)") {
                $price = $price / $rate['eur_gbp'];
            } else if ($this->currency == "RUR") {
                $price = $price / $rate['eur_rur'];
            }
            return round($price);
        }
        return $price;
    }

    /*
    Форма поиска для страницы администрирования
    Расширенный поиск
    
    function getSearchFormClient($tpl)
    {
        require_once ("HTML/QuickForm.php");
        $form = new HTML_QuickForm('searchForm', 'POST', '/search/');
        $form->addElement('text', 'keyword', '', array('class' => "text input-keyword default ac_input", 'id' => "searchKeywords") );
        $form->addElement('text', 'minprice', '', array('class' => 'input'));
        $form->addElement('text', 'maxprice', '', array('class' => 'input'));
        $form->addElement('select', 'sleeps', '',  array('' => 'Любое') + $this->sleeps_arr);
        $form->addElement('select', 'proptype', '', array('' => 'Любой') + $this->prop_type_arr);
        $form->addElement('select', 'user_id', '', array('' => 'Любой', LETINTHESUN_ID => 'LetInTheSun'));
        $form->addElement('submit', 'submit', 'Register');

        $form->setDefaults($_GET);
        require_once 'HTML/QuickForm/Renderer/ITStatic.php';
        $renderer =& new HTML_QuickForm_Renderer_ITStatic($tpl);
        //$renderer->setRequiredTemplate('{label}<font color="red" size="1">*</font>');
        //$renderer->setErrorTemplate('<font color="red">{error}</font><br />{html}');
        $form->accept($renderer);
        return $tpl->get();

    }
*/

    //Форма поиска для страницы администрирования
    function getSearchFormDate($tpl)
    {
        require_once ("HTML/QuickForm.php");
        $form = new HTML_QuickForm('searchForm', 'get', '');
        $form->addElement('text', 'keyword', '', array('placeholder' => "ключевое слово"));
        $form->addElement('hidden', 'op', 'villa');
        $form->addElement('hidden', 'act', 'find');


        $country_obj = DB_DataObject::factory('countries');
        //require(PROJECT_ROOT.'../vhome/DataObjects/Countries.php');
        //$country_obj = 
        $country_arr = $country_obj->selArray2();

        $form->addElement('select', 'region', '', array('' => '') + $country_arr);

        $form->addElement('text', 'startDateInput', '', array('class' => 'datepicker text'));
        $form->addElement('text', 'endDateInput', '', array('class' => 'datepicker text'));
   
        //$form->addElement('select', 'nights', '',  self::numArr(7, 30));   
        //$form->addElement('text', 'minprice', '', array('class' => 'input'));
        //$form->addElement('text', 'maxprice', '', array('class' => 'input'));
        $form->addElement('select', 'sleeps', '',  array('' => 'Любое') + $this->sleeps_arr);
        $form->addElement('select', 'proptype', '', array('' => 'Любой') + $this->prop_type_arr);
        $form->addElement('submit', 'submit', 'Register');
        //$form->addRule('region', DVS_REQUIRED.' "Страна"!', 'required', null, 'client');
        //$form->addFormRule(array('Project_Villa_Find', 'countryOrKey'));
        $form->setDefaults($_GET);
        require_once 'HTML/QuickForm/Renderer/ITStatic.php';
        $renderer =& new HTML_QuickForm_Renderer_ITStatic($tpl);
        //$renderer->setRequiredTemplate('{label}<font color="red" size="1">*</font>');
        //$renderer->setErrorTemplate('<font color="red">{error}</font><br />{html}');
        $form->accept($renderer);
        return $tpl->get();
    }


    //Форма поиска для страницы администрирования
    function getSearchFormClient($tpl)
    {
        require_once ("HTML/QuickForm.php");
        $form = new HTML_QuickForm('searchForm', 'POST', '/search/');
        $form->addElement('text', 'keyword', '', array('class' => "text input-keyword default ac_input", 'id' => "searchKeywords") );
        $form->addElement('hidden', 'op', 'villa');
        $form->addElement('hidden', 'act', 'find');


        $form->addElement('text', 'startDateInput', '', array('class' => 'datepicker text'));
        $form->addElement('text', 'endDateInput', '', array('class' => 'datepicker text'));

        $form->addElement('text', 'minprice', '', array('class' => 'input'));
        $form->addElement('text', 'maxprice', '', array('class' => 'input'));
        $form->addElement('select', 'sleeps', '',  array('' => 'Любое') + $this->sleeps_arr);
        $form->addElement('select', 'proptype', '', array('' => 'Любой') + $this->prop_type_arr);
        $form->addElement('submit', 'submit', 'Register');

        $form->setDefaults($_GET);
        require_once 'HTML/QuickForm/Renderer/ITStatic.php';
        $renderer =& new HTML_QuickForm_Renderer_ITStatic($tpl);
        //$renderer->setRequiredTemplate('{label}<font color="red" size="1">*</font>');
        //$renderer->setErrorTemplate('<font color="red">{error}</font><br />{html}');
        $form->accept($renderer);
        return $tpl->get();

    }


    function getSpecial($tpl)
    {
        //DB_DataObject::DebugLevel(1);
        //$this->database('rurenter');
        $tpl->addBlockFile("SPECIAL", "SPECIAL", "special.tpl");
        
        $tpl->setVariable(array(
                'TOP_VILLA_LINK'      => '/villa/60491.html',
                'TOP_VILLA_TITLE' => 'Пентхаус с 3-мя сп.',
                'TOP_VILLA_IMAGE' => VILLA_IMAGE_URL.'60491/200x133_20081121430_main.jpg',
                'View_this_property' => 'Подробнее...',
                ));
            //array('v', 60491, 'Пентхаус с 3-мя сп.', VILLARENTERS_IMAGE_URL.'60491/20081121430_thm.jpg'),
        $tpl->parse('TOP_VILLA');
        //$this->special_offer = 1;
        $this->whereAdd("villarentersindex > 1000");
        $cnt = $this->count();
        $this->whereAdd("id=60491", 'OR');
        //$this->id  = 60491;
        $rand = rand(0, $cnt-5);
        $this->limit($rand, 4);
        $this->find();
        $i = 0;
        while ($this->fetch()) {
               $i++;
                $tpl->setVariable(array(
                'TOP_VILLA_LINK'      => '/villa/'.$this->id.'.html',
                'TOP_VILLA_TITLE' => substr($this->title_rus, 0, 20),
                'TOP_VILLA_IMAGE' => VILLA_IMAGE_URL.$this->main_image,
                'View_this_property' => 'Подробнее...',
                'last' => $i == 4 ? 'last' : ''
                ));
            $tpl->parse('TOP_VILLA');
        }
    }


    function getRecentArr($cnt='')
    {
        $time_arr = $_COOKIE['villa_id'];
        arsort($time_arr);
        if ($cnt && $cnt < sizeof($time_arr)) {
            $time_arr = array_slice($time_arr, 0, $cnt, true);
            $this->limit(0, $cnt);
        }
        if ($time_arr) {
            foreach ($time_arr as $villa_id => $time) {
                //echo "$villa_id => $time <br>";
                $this->whereAdd("id=$villa_id", 'OR');
            }
        }
        //$this->limit(0, $cnt);
        $this->find();
        while ($this->fetch()) {
            $recent_arr[$this->id] = $this->toArray();
            //$recent_arr[$i]['time'] = $_COOKIE['villa_id'][$this->id];
            $sort_arr[$this->id] = $time_arr[$this->id];
        }
        
        //print_r($recent_arr);
        array_multisort($sort_arr, SORT_DESC, $recent_arr);
        return $recent_arr;
    }

    function getRecent($tpl)
    {
        //DB_DataObject::DebugLevel(1);
        //$this->database('rurenter');
        $tpl->addBlockFile("SPECIAL", "SPECIAL", "recent.tpl");
        $recent_arr = $this->getRecentArr(5);
        $i = 0;
        //while ($this->fetch()) {
        foreach ($recent_arr as $id => $arr) {
               $this->setFrom($arr);
                $this->id = $arr['id'];
               $i++;
                $tpl->setVariable(array(
                'TOP_VILLA_LINK'      => '/villa/'.$this->id.'.html',
                'TOP_VILLA_TITLE' => substr($this->title_rus, 0, 20),
                'TOP_VILLA_IMAGE' => VILLARENTERS_IMAGE_URL.$this->main_image,
                'View_this_property' => 'Подробнее...',
                'last' => $i % 5 ? '' : 'last'

                ));
            $tpl->parse('TOP_VILLA');
        }
    }



    function getRurenterSpecial($tpl)
    {
        $this->database('rurenter');
        $tpl->addBlockFile("SPECIAL", "SPECIAL", "special.tpl");
        //$this->special_offer = 1;
        //$this->whereAdd("proptype='villa'");
        $this->whereAdd("src_site='rurenter.ru'");
        $this->preGenerateList();

        $cnt = $this->count();
        $rand = mt_rand(0, $cnt-5);
        $this->orderBy('special_offer DESC, id DESC');
//        $this->limit($rand,3);
        $this->limit(0,3);
        $this->find();
        $i = 0;
        while ($this->fetch()) {
               $i++;
                $tpl->setVariable(array(
                'TOP_VILLA_LINK'      => RURENTER_URL.'/villa/'.$this->id.'.html',
                'TOP_VILLA_TITLE' => substr($this->title_rus, 0, 20),
                'TOP_VILLA_IMAGE' => RURENTER_URL.'images/'.$this->main_image,
                'VILLA_TARGET' => ' target=_blank',
                'View_this_property' => 'Подробнее...',
                'last' => $i % 5 ? 'last' : ''
                ));
            $tpl->parse('TOP_VILLA');
        }
        $db = $this->getDatabaseConnection();
        $db->disconnect();
    }


    function getSpecialMain($tpl)
    {
        $sp_arr = array(
            array('v', 60491, 'Пентхаус с 3-мя сп.', VILLARENTERS_IMAGE_URL.'60491/20081121430_thm.jpg'),
            array('r', 75446, 'Эйлат', RURENTER_URL.'images/75446/e5a32709_200_150.jpg'),
            //array('r', 75451, 'VACD -005, Miami Playa', RURENTER_URL.'images/75451/186d977e_200_150.jpg'),
            array('r', 71398, 'Современная вилла Елена у моря в Элунде, Крит', RURENTER_URL.'images/71398/c60e4de1_200_150.jpg'),
            array('r', 75438, 'Fewo Olimpias', RURENTER_URL.'images/75438/cae45192_200_150.jpg'),
            array('v', 75407, 'Вилла 3 этажа, 3 сп.', VILLARENTERS_IMAGE_URL.'75407/2010719374_thm.jpg'),

        );
        $tpl->addBlockFile("SPECIAL", "SPECIAL", "special.tpl");
        foreach ($sp_arr as $k => $arr) {
               $i++;
                $tpl->setVariable(array(
                'TOP_VILLA_LINK'      => ($arr[0] == 'r' ? RURENTER_URL : '/').'villa/'.$arr[1].'.html',
                'TOP_VILLA_TITLE' => substr($arr[2], 0, 20),
                'TOP_VILLA_IMAGE' => $arr[3],
                'View_this_property' => 'Подробнее...',
                'last' => $i == 5 ? 'last' : ''
                ));
            $tpl->parse('TOP_VILLA');
        }
    }

    function getVillaRow($type='villa')
    {
        $title = ($this->title_rus ? $this->title_rus : $this->title).', '.$this->region_title_p;
        //if ($type == 'villa') {
        if ($this->database() == DB_NAME) {
            $link = '/villa/'.$this->id.'.html';
            $image = VILLA_IMAGE_URL.$this->main_image;
            $booking_link = '/?op=villa&act=book&id='.$this->id;
            $no_index = array();
        } else if ($this->database() == 'rurenter') {
            //$link = '/villa-r/'.$this->id.'.html';
            $rurenter_url = RURENTER_URL;
            if(preg_match('/^m/', $_SERVER['HTTP_HOST'])) {
                $role = 'mu';
                $rurenter_url = 'http://m.rurenter.ru/';
            }
 
            $link = $rurenter_url.'villa/'.$this->id.'.html';
            $image = $rurenter_url.'images/'.$this->main_image;
            $booking_link = RURENTER_URL.'?op=booking&act=user&villa_id='.$this->id;
            $no_index = array('NOINDEX' => '<noindex>', 'NOINDEX_END' => '</noindex>', 'NOFOLLOW' => ' rel="nofollow"');
        } else {
             $no_index = array();
             $title = $this->code;
             $image = $this->main_image;
             $link = VHOME_URL.'villa/'.$this->id.'.html';
             $booking_link = VHOME_URL.'?op=villa&act=book&id='.$this->id;
        }

            $link = '/villa/'.$this->id.'.html';
            $image = $this->imageURL().$this->main_image;
            $booking_link = RURENTER_URL.'?op=booking&act=user&villa_id='.$this->id;
            $no_index = array();


        return $no_index + array(
                'LINK'      => $link,
                'VILLA_ID' => $this->id,
                'TITLE' => $title,
                //'SUMMARY' => $this->summary_rus ? $this->summary_rus : $this->summary,
                'SUMMARY' => $this->getShortSummary(),
                'PROPTYPE' => 'аренда '.$this->propTypeName($this->proptype),
                'SLEEPS_NUM' => $this->sleeps,
                'Rating' => $this->villarentersindex,
                'MIN_PRICE' => self::euroPrice($this->minprice),
                'MAX_PRICE' => self::euroPrice($this->maxprice),
                'CURRENCY' => 'EUR',
                'pay_period' => $this->getPay_periodName(),
                /*
                'MIN_PRICE' => $this->minprice,
                'MAX_PRICE' => $this->maxprice,
                'CURRENCY' => $this->currency,
                */
                'M_PHOTO_SRC' => $image,
                'M_ALT_TEXT' => 'аренда '.$this->propTypeName($this->proptype).' - '.($this->title_rus ? $this->title_rus : $this->title),
                'BOOKING_LINK' => $booking_link,
            );
    }


    function setSearchParams($tpl, $minprice, $maxprice, $sleeps, $proptype)
    {
        if ($minprice || $maxprice) {
            $rate = $this->currencyRate();
        }

        if ($minprice) {
            $this->whereAdd("minprice > CASE currency"
                ." WHEN \"$ (USD)\" THEN ".round($minprice * $rate['eur_usd'])
                ." WHEN \"ВЈ (GBP)\" THEN ".round($minprice * $rate['eur_gbp'])
                ." WHEN \"E (EUR)\" THEN ".$minprice." END");
             $tpl->setVariable(array('minprice' => $minprice));
        }

        if ($maxprice) {
            //$this->db_obj->whereAdd('maxprice < '.$maxprice);

            $this->whereAdd("maxprice < CASE currency"
                ." WHEN \"$ (USD)\" THEN ".round($maxprice * $rate['eur_usd'])
                ." WHEN \"ВЈ (GBP)\" THEN ".round($maxprice * $rate['eur_gbp'])
                ." WHEN \"E (EUR)\" THEN ".$maxprice." END");
             $tpl->setVariable(array('maxprice' => $maxprice));
        }

        if ($sleeps) {
            $this->whereAdd('sleeps >= '.$sleeps);
        }

        if ($proptype) {
            $this->whereAdd("proptype = '".$proptype."'");
        }
        $this->whereAdd("sale=0");
    }


    function getCnt($tpl, $minprice, $maxprice, $sleeps, $proptype)
    {
        $this->setSearchParams($tpl, $minprice, $maxprice, $sleeps, $proptype);
        if ($this->preGenerateList()) {
        //$this->preGenerateList();
            return $this->count();
        }
        return;
    }

    function getVillaList($tpl, $p=1, $offset=0)
    {
        /*
        $this->setSearchParams($tpl, $minprice, $maxprice, $sleeps, $proptype);
        $this->preGenerateList();
        $cnt = $this->count();
        */
        if ($this->database() == DB_NAME) {
            //$per_page = PER_PAGE;
            $per_page = 10;
            $this->orderBy('villarentersindex DESC');
        } else if ($this->database() == 'rurenter') {
            $per_page = 20;
            $this->orderBy('special_offer DESC, id DESC');
        } else {
            $per_page = 3;
            $this->orderBy('id DESC');
        }
        $this->limit(($p - 1)*$per_page, $per_page - $offset);
        
        //$links =  DVS_Table::createPager(&$this);
        //$this->orderBy('special_offer DESC, id DESC');
        $this->find();
        $i = 0;
        while ($this->fetch()) {
            $tpl->setVariable($this->getVillaRow());
            //$i++;
            $tpl->parse('VILLA');
        }
        return;
    }

    function getShortSummary()
    {
        $summary = $this->summary_rus ? $this->summary_rus : $this->summary;
        return substr($summary, 0, 256);
    }

    function getRurenterLatest($tpl)
    {
        //DB_DataObject::DebugLevel(1);
        $this->database('rurenter');
        $tpl->addBlockFile("LATEST", "LATEST", "latest.tpl");
        $this->whereAdd("sale=0");
        $this->orderBy("id DESC");
        
        //$this->special_offer = 1;
        //$this->whereAdd("proptype='villa'");
        //$this->whereAdd("src_site='rurenter.ru'");
        $this->preGenerateList();

        $cnt = $this->count();
        $this->orderBy('special_offer DESC, id DESC');
//        $this->limit($rand,3);
        $this->limit(0,3);
        $this->find();
        $i = 0;
        while ($this->fetch()) {
               $i++;
                $tpl->setVariable(array(
                'LATEST_VILLA_LINK'      => RURENTER_URL.'/villa/'.$this->id.'.html',
                'LATEST_VILLA_TITLE' => substr($this->title_rus, 0, 20),
                'LATEST_VILLA_IMAGE' => RURENTER_URL.'images/'.$this->main_image,
                'LATEST_TARGET' => ' target=_blank',
                'villa_descr' => $this->minprice.'&nbsp;-&nbsp;'.$this->maxprice.'('.$this->currency.')<br>'.substr($this->summary, 0, 128).'...',
                //'View_this_property' => 'Подробнее...',
                //'last' => $i % 5 ? 'last' : ''
                ));
            $tpl->parse('LATEST_VILLA');
        }
        $db = $this->getDatabaseConnection();
        $db->disconnect();
    }

    function imageURL()
    {
        if ($this->src_site == 'villarenters.com') {
            if (SERVER_TYPE == 'local') {
                $url = 'http://villa/villa_img/';
            } else {
                $url = 'http://villarenters.ru/villa_img/';
            }
        } else {
            $url = RURENTER_URL.'images/';
        }
        return $url;
    }

    function getPay_periodName($lang='ru')
    {
        if ($lang != 'ru') {
            $arr = $this->{'pay_period_arr_'.$lang};
        }
        if (!$arr) {
            $arr = $this->pay_period_arr;
        }
        if (!$this->pay_period) {
            $this->pay_period = 1;
        }
        return $arr[$this->pay_period];
    }

}
