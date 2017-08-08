<?php
/**
 * Бронирование виллы
 * @package 
 * $Id: Villa_Book.php 380 2015-02-24 10:50:33Z xxserg $
 */

//error_reporting(E_ALL);

require_once ('HTTP/Request2.php');
require_once COMMON_LIB.'DVS/Dynamic.php';

require (PROJECT_ROOT.'/layout/getXML.php');
require (PROJECT_ROOT.'/layout/activecalendar.php');

define('BOOKING_URL_NEW', 'http://www.rentalsystems.com/Booking.aspx');

class Project_Villa_Book extends DVS_Dynamic
{
    // Права
    public $perms_arr = array('ar' => 1, 'oc' => 1, 'iu' => 1, 'mu' => 1);

    private $change_content = true;

    private $minBookingPeriod;


    public $nav_arr = array(
        '/villa/{VILLA_ID}.html' => 'Назад',
        '/villa/{VILLA_ID}.html#photos-bar' => 'Фото и описания',
        '/villa/{VILLA_ID}.html#facility-bar' => 'Услуги и оборудование',
        '/villa/{VILLA_ID}.html#location-bar' => 'Расположение и окрестности',
        '/?op=villa&act=book&id={VILLA_ID}' => 'Цены и бронирование',
        '/?op=comments&act=show&villa_id={VILLA_ID}' => 'Отзывы',
        '/?op=query&act=new&villa_id={VILLA_ID}' => 'Задать вопрос'
    );

    function getPageData()
    {        
        $ref = DVS::getVar('ref');

        if (!$ref) {
            $ref = DVS::getVar('ref', 'int', 'post');
        } else {
            $this->db_obj->id = $ref;
            $this->db_obj->find('true');
        }

        $selected = false;
        if (!$this->db_obj->N) {
            //echo $this->db_obj->id;
            //$this->show404();
            $this->nocache = true;
        }

        if ($_POST['__submit__']) {
            /*
            echo '<pre>';
            print_r($_GET);
            print_r($_POST);
            */
            $date1 = DVS::getVar('date1', 'word', 'post');
            $date2 = DVS::getVar('date2', 'word', 'post');
            $days = DVS::getVar('numdays', 'int', 'post');


            $people = DVS::getVar('people', 'int', 'post');
            $chl = DVS::getVar('chl', 'int', 'post');
            $inf = DVS::getVar('inf', 'int', 'post');
            //$people = DVS::getVar('extra_people', 'int', 'post');

            $start_arr = explode('/', $date1);

            $start_arr_p['Y'] = $start_arr[0];
            $start_arr_p['F'] = $start_arr[1];
            $start_arr_p['d'] = $start_arr[2];

            //$end = DVS::getVar('end');
            //$days = DVS::getVar('days');
            //$start_arr_p = $_POST['ds1']; 

            $booking_id = $this->bookingLog($this->db_obj->id, $date1, $date2, $people);

            //echo $booking_id;

            $url = BOOKING_URL_NEW.'?ref='.$this->db_obj->id.'&day='.$start_arr_p['d'].'&mth='.$start_arr_p['F'].'&yr='.$start_arr_p['Y'].'&dur='.$days.'&adl='.$people.'&chd='.$chl.'&inf='.$inf.'&rag='.VR_ACCOUNT_NUM.'&rcam=';

            $selected = true;

            //$query_url = '/?op=query&act=new&villa_id='.$this->db_obj->id.'&date1='.$date1.'&date2='.$date2.'&people='.$people.'&chd='.$chl.'&inf='.$inf;
            $query_url = '/?op=users&act=new&villa_id='.$this->db_obj->id.'&date1='.$date1.'&date2='.$date2.'&people='.$people.'&chd='.$chl.'&inf='.$inf.'&booking_id='.$booking_id;


            /*
            if ($this->db_obj->user_id == LETINTHESUN_ID) {
                header("Location: $query_url");
                exit;
            }
            */
            //echo $url;
            //exit;
            //header("Location: $url");
            //header('location: '.BOOKING_URL.'?ref='.$ref.'&start='.$start.'&end='.$end.'&rag='.VR_ACCOUNT_NUM.'&extra_people='.$people.'&ret=true&rcam=');
            //exit;
        }


        $this->createTemplateObj();

        $this->db_obj->nav_arr = $this->nav_arr;
        $nav = $this->db_obj->showNavigation($this->template_obj);
        $this->template_obj->loadTemplateFile('villa_book.tpl');

        // Календарь, выбор дат. Шаг1
        if (!$selected) {
            $calendar = $this->getActiveCalendar();
            if ($calendar) {
                //$form = $this->calendarForm3($this->db_obj->sleeps);
                $form = $this->calendarForm2($this->db_obj->sleeps);
            } else {
                $calendar = "<b>Владелец не определил цену на данный объект</b>";
            }
        $this->template_obj->setVariable(array(
                'BOOKING_TITLE' => 'Бронирование виллы "'.$this->db_obj->title.'"<br><br>',
                'BOOKING_FORM' => $form,
                'CALENDAR' => $calendar,
                'VILLA_NAV' => $nav,
            ));
        
        } else { // Шаг 2 выбор - англо - русск. ссылка.
            //$form = $this->calendarForm($this->db_obj->sleeps);
            
            //$first_price = $this->getPrice($date1, $date2);

            
            //$price_arr = $this->getPriceURL($date1, $days);
            //echo '<pre>';
            //print_r($price_arr);

            if ($price_arr['TotalPrice']) {
                $first_price = $price_arr['TotalPrice'];
            }

            $calendar = 'HELP';
            $this->template_obj->setVariable(array(
                'date1' => self::convert2RusDate($date1),
                'date2' => self::convert2RusDate($date2),
                'people' => $people,
                //'rs_url' => $url,
                'query_url' => $query_url,
                
                //'first_price' => $first_price,
                //'currency' => $this->currency,

                //'query_url' => '/?op=query&act=new&villa_id='.$this->db_obj->id.'&date1='.$date1.'&date2='.$date2.'&people='.$people,
                'BOOKING_TITLE' => 'Бронирование виллы "'.$this->db_obj->title.'"<br><br>',
                //'help' => 'HELP',
                'VILLA_NAV' => $nav,
            ));

            if ($first_price) {
                $this->template_obj->setVariable(array(
                    'first_price' => $first_price,
                    'currency' => $this->currency,
                    'breakage' => $price_arr['BreakageDeposit'],
                    //'cost' => $price_arr['CostOfAccomodation'],
                ));
            }

        }

        //$page_arr['JSCRIPT'] = 'var aurl = "'.BOOKING_URL.'?ref='.$this->db_obj->id.'&rag='.VR_ACCOUNT_NUM.'";';
        //$page_arr['JSCRIPT'] = 'var aurl = "/?op=villa&act=book&ref='.$this->db_obj->id.'&rag='.VR_ACCOUNT_NUM.'";';
        
        if ($this->minBookingPeriod) {
            $page_arr['JSCRIPT'] = 'var minp = '.$this->minBookingPeriod.';';
        }
        //$this->searchForm();
        $this->calendarRange();
        $page_arr['JSCRIPT'] .= $this->page_arr['JSCRIPT'];
        
        $page_arr['BODY_CLASS']   = 'property';
        //$page_arr['CENTER_TITLE']   = 'Бронирование виллы "'.$this->db_obj->title.'"<br><br>';
        $page_arr['CENTER']         = $this->template_obj->get();
        return $page_arr;
    }





    function datePicker1()
    {
        $this->src_files = array(
            'JS_SRC' => array(  '/js/jquery.js',
                                '/js/datepicker.js',
                                //'/js/date.js',
                                //'/js/eye.js',
                                //'/js/utils.js',
                                //'/js/layout1.js?ver=1.0.2',
        ),
            'CSS_SRC'  => array('/datepicker/css/datepicker.css',
                                //'/datepicker/css/layout.css',
        )
        );
        $date_str = $this->showBook();

        //echo $date_str;
        //$page_arr['JSCRIPT'] = "

        $js = "

        $(document).ready(function(){
        $('#date').DatePicker({
            flat: true,
            date: '2008-07-31',
            current: '2008-07-31',
            calendars: 1,
            starts: 1,
            view: 'years'
        });
        
                    var now = new Date();
                    now.addDays(-10);
                    var now2 = new Date();
                    now2.addDays(+20);
                    now2.setHours(0,0,0,0);
                    var now3 = new Date();
                    now3.setDate(28,12,2009);
                    //console.log(now3);
                                    $('#date1').DatePicker({
                                    //view: 'years',
                                    flat: true,
                                    date: [".$date_str."],
                                    current: '2009-12-19',
                                    calendars: 1,
                                    //mode: 'range',
                                    mode: 'multiple',
                                    //starts: 2


    /*
    onRender: function(date) {
        //console.log('You selected ' + date);

        return {
            //disabled: (date.valueOf() < Date.fromString('30/10/2009').valueOf()),
            //disabled: (date.valueOf() < now.valueOf()),
            //className: date.valueOf() > now3.valueOf() && date.valueOf() < now2.valueOf() ? 'datepickerSpecial' : false,
            //disabled: date.valueOf() > now3.valueOf() && date.valueOf() < now2.valueOf(),
            //className: date.valueOf() == now2.valueOf() ? 'datepickerSpecial' : false
        }
    
    },
    */

                                    });
                                })";
          return $js;
    }


    function datePicker2()
    {
        $this->src_files = array(
            'JS_SRC' => array(  '/js/jquery-1.3.1.min.js',
                                '/js/datepicker2.js',
                                '/js/date.js',
        ),
            'CSS_SRC'  => array('/css/datepicker.css',
                                //'/datepicker/css/layout.css',
        )
        );
        //$date_str = $this->showBook();
        //$page_arr['JSCRIPT'] = "

        $js = "
            $(function()
            {
                $('.date-pick').datePicker({
                    inline:true,
                    selectMultiple:true,
                    startDate:'2009-10-30',
                    endDate:'2010-10-30',
                    showYearNavigation:false,
                    });
            });";
          return $js;
    }


    /**
    prop_ref] => 9336
    [currency] => ВЈ (GBP)
    [minNotice] => 3
    [minBookingPeriod] => 0
    [PropertyAvailabilities] => SimpleXMLElement Object
        (
            [PropertyAvailability] => Array
                (
                    [0] => SimpleXMLElement Object
                        (
                            [intYear] => 2010
                            [intMonth] => 3
                            [MonthAvailability] => 0,0,0,0,0,0,0,1,1,1,1,1,1,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0
                            [MonthPricing] => 450,450,450,450,450,450,450,450,450,450,450,450,450,450,450,450,450,450,450,450,450,450,450,450,450,450,450,450,450,450,450
                        )


    */
    function showBook()
    {
        $request_obj = new GetXML;
        $request_obj->data_url['GetPropertyAvailability']['params']['prop_ref'] = $this->db_obj->id;
        $xml = $request_obj->requestXMLdata('GetPropertyAvailability');
        //print_r($xml);

        $this->currency = $xml->currency;
        $this->minBookingPeriod = $xml->minBookingPeriod;
        $cur_aval = 0;
        foreach($xml->PropertyAvailabilities->PropertyAvailability as $k => $v) {
            $days_str = '';
            $date_str = $v->intYear.'-'.$v->intMonth;
            $days_arr = explode(',',strval($v->MonthAvailability));
            $price_arr = explode(',',strval($v->MonthPricing));
            $i = 0;
            foreach ($days_arr as $num => $aval) {
                if ($aval == 1) {
                    //$date_arr[] = array(intval($v->intYear), intval($v->intMonth), $num+1);
                    //$jsstr .= ($jsstr ? ',' : '')."'".$date_str.'-'.($num+1)."'";
                }
                if ($aval >= 0) {
                    if ($aval == 1 && $cur_aval != $aval) {
                        $aval = 0;
                        $cur_aval = 1;
                    } else {
                        $cur_aval = $aval;
                    }
                    $date_price_arr[$date_str.'-'.($num+1)] = array($aval, $price_arr[$num]);
                }
                $i++;
            }
        }
        //echo '<pre>';
        //print_r($date_price_arr);
        //print_r($date);
        //echo $jsstr;
        //var_dump($available);
        //return $jsstr;
        //return $date_arr;
        return $date_price_arr;

    }


    function getActiveCalendar()
    {
        $this->src_files = array(
            'JS_SRC' => array(  //'/js/pickdate1.js?nc='.rand(0, 10000),
                                '/js/pickdate_villa.js'
                                        ),
            'CSS_SRC'  => array(
                                '/css/plain.css',
                                 //'/activecalendar/data/css/plain.css'
                                 //'/activecalendar/data/css/ceramique.css'
                                 //'/activecalendar/data/css/antique.css'
                               ),
            
        );

        $day_names_ru = array(
            'вс','пн','вт','ср','чт','пт','сб',
        );
        $monthNamesArray_ru = array('Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь');

        $cal = new activeCalendar($yearID,$monthID,$dayID);
        $cal->setDayNames($day_names_ru);
        $cal->setMonthNames($monthNamesArray_ru); 
        $cal->setFirstWeekDay(1); 
        
        $date_arr = $this->showBook();
        //print_r($date_arr);

        if (is_array($date_arr)) {
            foreach ($date_arr as $k => $a) {
                $da = explode('-', $k);
                
                if ($a[0] == 1) {
                    //$cal->setEvent($da[0], $da[1], $da[2], '', 'javascript:unavaildate(\''.$da[2].'/'.$da[1].'/'.$da[0].'\',\''.$da[2].'\',\''.$da[1].'\',\''.$da[0].'\')" title="');

                    $cal->setEvent($da[0], $da[1], $da[2], '', 'javascript:myDate('.$da[0].','.$da[1].','.$da[2].')" onmouseover=temp_prices('.$real_price.') onmouseout=temp_prices(0) title="Weekly Price: '.$real_price.' ""');


                } else {
                    //$real_price = round($a[1] + $a[1]*0.045);
                    $real_price = $a[1];
                    $cal->setEvent($da[0], $da[1], $da[2], 'monthday', 'javascript:myDate('.$da[0].','.$da[1].','.$da[2].')" onmouseover=temp_prices('.$real_price.') onmouseout=temp_prices(0) title="Weekly Price: '.$real_price.' ""');
                }
            }
            return $cal->showYear(4, date('m'));
        } else {
            $cal->enableDayLinks(false, 'myDate'); 
            return $cal->showYear(4, date('m'));
            return false;
        }
    }


    function dateOptions()
    {
        return array(   'language' => 'ru',
                        'format' =>'d-F-Y',
                        'minYear' =>date("Y"),
                        'maxYear' =>date("Y")+2,
                        'addEmptyOption' => true
            
        );
    }

    function calendarForm($slleps=5)
    {
        require_once 'HTML/QuickForm.php';
        $form = new HTML_QuickForm('calendar', 'post', $_SERVER['REQUEST_URI']);
        //$form =& new HTML_QuickForm('calendar', 'post', '/?op=villa&act=book&id='.$this->db_obj->id);
        //$form =& new HTML_QuickForm('calendar', 'post');
        $form->addElement('hidden', 'ref', $this->db_obj->id);
        $form->addElement('hidden', 'date1');
        $form->addElement('hidden', 'date2');
        $form->addElement('hidden', 'numdays');
        $form->addElement('hidden', 'req1');
        $form->addElement('hidden', 'req2');
        $d1 = $form->createElement('date', 'ds1', '', $this->dateOptions());
        $d2 = $form->createElement('date', 'd2', '', $this->dateOptions());
        for ($i = 1; $i <= $slleps; $i++) {
            $sleeps_arr[$i] = $i;
        }
        $s = $form->createElement('select', 'extra_people', 'sl', $sleeps_arr);
        $b = $form->createElement('submit', '__submit__','Отправить');
        $form->addGroup(array($d1,$d2,$s,$b), 'pr', 'Начало:&nbsp; ', array('&nbsp;Конец:&nbsp; ', '&nbsp;Человек:&nbsp; ', '&nbsp;'), '', false);

        $form->addElement('text', 'temp_price', 'Цена в неделю, '.$this->currency.':');

        //$form->addRule('date1', DVS_REQUIRED.' "Начало"!', 'required', null, 'client');
        //$form->addRule('date2', DVS_REQUIRED.' "Конец"!', 'required', null, 'client');

        $form->setRequiredNote('');
        $form->setJsWarnings('Ошибка!','');
        

        /*
        $form->addGroupRule('book', array(
            'ds1' => array(
                array('Выберите начальную дату!', 'required', null, 'client')
            ),
            'd2' => array(
                array('Выберите конечную дату!', 'required', null, 'client')
            )
        ));
        */
        /*
        require_once 'HTML/QuickForm/Renderer/ITDynamic.php';
        $this->db_obj->renderer_obj = new HTML_QuickForm_Renderer_ITDynamic($this->template_obj);
        $this->form_obj->accept($this->db_obj->renderer_obj);
        */
        /*
        require_once 'HTML/QuickForm/Renderer/Default.php';
        $renderer =& new HTML_QuickForm_Renderer_Default();
        //echo $renderer->toHtml();
        $renderer->setFormTemplate ( "\n<form{attributes}>\n<table width=100% border=\"1\">\n{content}\n</table>\n</form>"  );
        $form->accept($renderer);
        */
       return $form->tohtml();
    }

    /**
    Всплывающий календарь datepicker
    */
    function calendarForm2($sleeps)
    {

        require_once 'HTML/QuickForm.php';
        $form = new HTML_QuickForm('calendar', '', $_SERVER['REQUEST_URI']);
        $form->addElement('hidden', 'date1');
        $form->addElement('hidden', 'date2');
        $form->addElement('hidden', 'numdays');
        $d1 = $form->createElement('text', 'start_date', 'Начало периода:', array('size' => 12,
                                    'id="from"'
                                    //'disabled' => true
                                    //'class' => 'datepicker text'
        ));
        $d2 = $form->createElement('text', 'end_date', 'Конец:', array('size' => 12,
            'id' => 'to',
            //'onchange' => 'onc()',
            //'class' => 'datepicker text'
            //'disabled' => true
            ));
        $sleeps_arr = array(1 => 1);
        for ($i = 1; $i <= $sleeps; $i++) {
            $sleeps_arr[$i] = $i;
        }

        $s = $form->createElement('select', 'people', 'Взрослых: ', $sleeps_arr);
        $chl = $form->createElement('select', 'chl', 'Детей (3-16): ', array(0 => 0) + $sleeps_arr);
        $inf = $form->createElement('select', 'inf', 'Малышей (0-2): ', array(0 => 0) + $sleeps_arr);
        
        $b = $form->createElement('submit', '__submit__', 'Отправить');

        $form->addGroup(array($d1, $d2), 'pr', 'Начало:&nbsp; ', array('&nbsp;Конец:&nbsp; '), '', false);

        $form->addGroup(array($s, $chl,$inf, $b), 'pr', 'Взрослых:&nbsp; ', array(' Детей (3-16): ', ' Малышей (0-2): ','&nbsp;'), '', false); 

        //$form->addElement('text', 'temp_price', 'Цена в неделю, '.$this->currency.':', array('size' => 12, 'disabled' => true));

        $form->addRule('date1', DVS_REQUIRED.' "Дата 1"!', 'required', null, 'client');
        $form->addRule('date2', DVS_REQUIRED.' "Дата 2"!', 'required', null, 'client');
        $form->setRequiredNote('');
        $form->setJsWarnings  ( 'Ошибка!', '');
       return $form->tohtml();
    }


    function calendarForm3($sleeps)
    {
        require_once 'HTML/QuickForm.php';
        $form =& new HTML_QuickForm('calendar', '', '/reg/');
        $form->addElement('hidden', 'villa_id');
        $form->addElement('hidden', 'date1');
        $form->addElement('hidden', 'date2');
        $form->addElement('hidden', 'numdays');
        $d1 = $form->createElement('text', 'start_date', 'Начало периода:', array('size' => 12, 'disabled' => true));
        $d2 = $form->createElement('text', 'end_date', 'Конец:', array('size' => 12, 'disabled' => true));

        for ($i = 1; $i <= $sleeps; $i++) {
            $sleeps_arr[$i] = $i;
        }

        $s = $form->createElement('select', 'people', 'Кол-во человек: ', $sleeps_arr);
        $b = $form->createElement('submit', 'continue', 'Продолжть');

        $form->addGroup(array($d1,$d2,$s,$b), 'pr', 'Начало:&nbsp; ', array('&nbsp;Конец:&nbsp; ', '&nbsp;Человек:&nbsp; ', '&nbsp;'), '', false);

        $form->addElement('text', 'temp_price', 'Цена в неделю, '.$this->currency.':', array('size' => 12, 'disabled' => true));

        $form->addRule('date1', DVS_REQUIRED.' "Дата 1"!', 'required', null, 'client');
        $form->addRule('date2', DVS_REQUIRED.' "Дата 2"!', 'required', null, 'client');
        $form->setRequiredNote('');
        $form->setJsWarnings  ( 'Ошибка!', '');
        $form->setDefaults(array('villa_id' => $_GET['id']));
       return $form->tohtml();
    }



    /*
        rag=55172A
        Villarenters Entry Point (how to book) : The villarenters entry point is the page that your customer will jump from your site to the villarenters site and will lead your customer through the booking process.

        This page is currently the advert_price_check page. the usage of the page is as follows:
        http://www.rentalsystems.com/advert_price_check.asp?ref=23043&start=08/09/2008&end=15/09/2008&dscode=&rag=11905A&rcam=TemplateSite&ret=true

        Ref
        This is the properties reference (prop_ref from the xml feed)

        Start
        This is the start date of the booking DD/MM/YYYY

        End
        This is the end date of the booking DD/MM/YYYY

        rag
        This is your affiliate number as stated in your affiliate account area.

        rcam
        This is a free text (No spaces) campaign field to identify the source of the booking
    */

    function convertDate($str)
    {
        //$arr = explode("/", $str);
        //return $arr[2].'-'.$arr[1].'-'.$arr[0];
        return str_replace("/", "-", $str);
    }

    public static function convert2RusDate($str)
    {
        $arr = explode("/", $str);
        return $arr[2].'.'.$arr[1].'.'.$arr[0];
    }


    function bookingLog($villa_id, $start, $end, $people)
    {
        require_once ('DVS/Auth.php');
        $booking_log_obj = DB_DataObject::factory('booking_log');
        //DB_DataObject::DebugLevel(1);
        $booking_log_obj->villa_id = $villa_id;
        $booking_log_obj->start_date = $this->convertDate($start);
        $booking_log_obj->end_date = $this->convertDate($end);
        $booking_log_obj->people = $people;
        $booking_log_obj->post_date = date("Y-m-d H:i:s");
        $booking_log_obj->ip = DVS_Auth::getIP();
        return $booking_log_obj->insert();
    }

    function chooseBook()
    {

    }

    /**
    prop_ref] => 9336
    [currency] => ВЈ (GBP)
    [minNotice] => 3
    [minBookingPeriod] => 0
    [PropertyAvailabilities] => SimpleXMLElement Object
        (
            [PropertyAvailability] => Array
                (
                    [0] => SimpleXMLElement Object
                        (
                            [intYear] => 2010
                            [intMonth] => 3
                            [MonthAvailability] => 0,0,0,0,0,0,0,1,1,1,1,1,1,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0
                            [MonthPricing] => 450,450,450,450,450,450,450,450,450,450,450,450,450,450,450,450,450,450,450,450,450,450,450,450,450,450,450,450,450,450,450
                        )


    */
    function getPrice($start, $end)
    {
        //echo "$start, $end<br>";
        //2013/1/1, 2013/1/8
        //return;

        $start_arr = explode('/', $start);
        //print_r($start_arr);

        $request_obj = new GetXML;
        $request_obj->data_url['GetPropertyAvailability']['params']['prop_ref'] = $this->db_obj->id;
        $xml = $request_obj->requestXMLdata('GetPropertyAvailability');
        $this->currency = $xml->currency;
        $in_period = false;
        $pay_period = 7;

        //print_r($xml);

        foreach($xml->PropertyAvailabilities->PropertyAvailability as $k => $v) {
            //$date_str = $v->intYear.'/'.$v->intMonth;
            if (($start_arr[0] == $v->intYear && $start_arr[1] == $v->intMonth) || $in_period) {
                $days_arr = explode(',',strval($v->MonthAvailability));
                $price_arr = explode(',',strval($v->MonthPricing));
                
                foreach ($days_arr as $num => $aval) {

                    $date_str = $v->intYear.'/'.$v->intMonth.'/'.($num+1);
                    if ($start_arr[2] == $num+1) {
                        $in_period = true;
                    }
                    if ($in_period && $price_arr[$num] > 0) {
                        $price += $price_arr[$num] / $pay_period;
                        //echo $price;
                    }
                    //echo $date_str.'<br>';
                    if ($date_str == $end) {
                        return round($price);
                        break 2;
                    }
                }
            }


        }
        return round($price);

    }

    function getPriceURL($start, $days)
    {

        $start_arr = explode('/', $start);
        $start = $start_arr[2].'/'.$start_arr[1].'/'.$start_arr[0];
        /*
        $url = 'http://www.villarenters.com/GetBookingPrices.ashx?propref='.$this->db_obj->id.'&StartDate='.urlencode($start).'&Duration='.$days.'&PartySize=1&currency=GBP';
        //$url ='http://www.villarenters.com/GetBookingPrices.ashx?propref=60491&StartDate=5/11/2012&Duration=8&PartySize=2';
        echo $url;
        $price_json = file_get_contents($url);
        */
        //define('DEBUG', 1);
                                $vars = array(
                                                //'host' => 'http://www.villarenters.com/',
                                                'host' => 'http://www.rentalsystems.com',
                                                'url' => '/GetBookingPrices.ashx',
                                                'params' => array(
                                                                'propref' => $this->db_obj->id,
                                                                //'StartDate' => urlencode($start), 
                                                                'StartDate' => $start, 
                                                                'Duration' => $days,
                                                                'PartySize' => '2',
                                                                'currency' => 'GBP'
                                                                )
                                                );


        require (PROJECT_ROOT.'/layout/getHTTP.php');
        $request_obj = new GetHTTP;
        $price_json = $request_obj->request($vars);
        $res=json_decode($price_json);
        //echo $price_json;
        if ($res[0]) {
            return (array)$res[0];
        }
        return false;
    }

    function searchForm()
    {
        //$this->template_obj->loadTemplateFile('villa_search_f.tpl');
        //$tpl = new HTML_Template_Sigma(PROJECT_ROOT.TMPL_FOLDER, PROJECT_ROOT.CACHE_FOLDER.'tmpl');
        //$tpl->loadTemplateFile('villa_search_f.tpl');
        //$tpl->loadTemplateFile('search_form.tpl');
        //$this->template_obj->addBlockFile('SEARCH_FORM', 'SEARCH_FORM', 'villa_search_f.tpl');

        $this->src_files = array(
            
            'JS_SRC' => array(   '/js/pickdate_villa.js',
                                '/js/jquery-1.3.1.min.js',
                                '/js/date.js',
                                '/js/date_ru_win1251.js',
                               '/js/datePicker2.js',
                                //'/js/datepicker-ru.js',

        ),
        
            'CSS_SRC'  => array(
                                '/css/datePicker.css',
                                '/css/demo1.css',
                                '/css/search.css',
                                 '/css/plain.css',
        )
        );

         $this->page_arr['JSCRIPT'] = "
            Date.format = 'dd.mm.yyyy';
            $.dpText = {
                TEXT_PREV_YEAR		:	'Пред. год',
                TEXT_PREV_MONTH		:	'Пред. месяц',
                TEXT_NEXT_YEAR		:	'След. год',
                TEXT_NEXT_MONTH		:	'След. месяц',
                TEXT_CLOSE			:	'Закрыть',
                TEXT_CHOOSE_DATE	:	'Выберите дату'
            }
            $(function()
            {
                $('.datepicker').datePicker({clickInput:true});
            });";

        //return $this->villa_obj->getSearchFormDate($tpl);
    }


    function calendarRange()
    {
        $this->src_files = array(
            'JS_SRC' => array(   '/js/pickdate_villa.js',
                                 '/js/jquery-1.10.2.js',
                                 '/js/jquery-ui-1.10.4.custom.min.js',
                                 '/js/jquery.ui.datepicker-ru.min.js',
                                //'http://code.jquery.com/jquery-1.9.1.js',
                                //'http://code.jquery.com/ui/1.10.3/jquery-ui.js',
                                //'/js/datepicker-ru.js'
                                //'/js/date.js',
                                //'/js/date_ru_win1251.js',
                               //'/js/datePicker2.js',
                                //'/js/datepicker-ru.js',

        ),
        
            'CSS_SRC'  => array(
                                //'http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css',
                                '/css/jquery-ui.css',
                                '/css/datePicker.css',
                                '/css/plain.css',
        )
        );


        $this->page_arr['JSCRIPT'] .= '

        $(function() {
        $( "#from" ).datepicker({
        dateFormat: "dd.mm.yy",
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 3,
        minDate: 0,
        regional: "ru",
        onClose: function( selectedDate ) {
        $( "#to" ).datepicker( "option", "minDate", selectedDate );
        }
        });

        $( "#to" ).datepicker({
        dateFormat: "dd.mm.yy",
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 3,
        onClose: function( selectedDate ) {
        $( "#from" ).datepicker( "option", "maxDate", selectedDate );
            var start = $("#from").datepicker("getDate");
            var end   = $("#to" ).datepicker("getDate");
            var days   = (end - start)/1000/60/60/24;

            if (days < minp)
                {
                    date_OK = false;
                    alert("Владелец задал минимальный период броирования " + minp + " дней");
                    $("#from").val("");
                    $("#to" ).datepicker( "setDate", "" );
                } else {
                    $("[name=date1]" ).datepicker({ dateFormat: "yy/mm/dd" } );
                    $("[name=date1]").datepicker("setDate", start);
                    $("[name=date2]" ).datepicker({ dateFormat: "yy/mm/dd" });
                    $("[name=date2]").datepicker("setDate", end);
                    
                    $("[name=numdays]").val(days);
                }

        }
        });
        });
        ';
    }

}

?>