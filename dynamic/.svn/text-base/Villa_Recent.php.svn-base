<?php
/**
 * Список вилл
 * @package villarenters
 * $Id: Villa_Index.php 188 2012-09-05 08:33:00Z xxserg@gmail.com $
 */

define('PER_PAGE', 10);
define('DEBUG', 1);

require_once COMMON_LIB.'DVS/Dynamic.php';
require_once COMMON_LIB.'DVS/Table.php';
require (PROJECT_ROOT.'/layout/getXML.php');

class Project_Villa_Recent extends DVS_Dynamic
{
    // Права
    public $perms_arr = array('iu' => 1, 'oc' => 1);

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
        //$this->template_obj->loadTemplateFile('villa_search2.tpl');
        //$search_form = $this->db_obj->getSearchFormClient($this->template_obj);
        
        $this->template_obj->loadTemplateFile('booking_show.tpl');

            /*
            $this->db_obj1 = DB_DataObject::factory('villa');
            $this->db_obj1->database('rurenter');
            $cnt1 = $this->db_obj1->getCnt($this->template_obj, $minprice, $maxprice, $sleeps, $proptype);
            
            if ($cnt1 > 0) {
                $this->db_obj1->getVillaList($this->template_obj, $p);
            }
            
            //$links =  Project_Villa_Index::createPager($cnt1);
            //unset($this->db_obj);
            $db = $this->db_obj1->getDatabaseConnection();
            $db->disconnect();
            


            $this->db_obj->database('xserg');
            $cnt2 = $this->db_obj->getCnt($this->template_obj, $minprice, $maxprice, $sleeps, $proptype);

            //if ($cnt2 > 0 && ($cnt1 < PER_PAGE || $this->db_obj1->N < PER_PAGE)) {
            if ($cnt2 > 0 ) {
                $this->db_obj->getVillaList($this->template_obj, $p, $this->db_obj1->N);
            }

            //echo $cnt1.'<br>'.$cnt2;

            $links =  Project_Villa_Recent::createPager($cnt1 + $cnt2);
            //print_r($links);
            */

            



            $recent_arr = $this->db_obj->getRecentArr();

        foreach ($recent_arr as $id => $arr) {
               $this->db_obj->setFrom($arr);
                $this->db_obj->id = $arr['id'];
                 $this->template_obj->setVariable(
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




            //$this->showRecent();


            $this->template_obj->setVariable(array(
            //'PAGES'      => '?op=villa&act=show&id=',
            'CNT' => $links['cnt'] ? 'Всего: '.$links['cnt'] : '',
            'PAGES'      =>     $links['all'],
                'SEARCH_FORM' => $search_form,
                'MAP_LINK' => $maplink,
            ));
        $this->template_obj->setGlobalVariable($this->lang_ru);

        //$this->template_obj->setVariable(array('TICKETS' => file_get_contents(PROJECT_ROOT.'tmpl/aviasales.tpl').$this->hotels()));

        $inthe = ' в ';

        $exceptions = array('Индонезии - Бали' => 'Бали', 'Таиланд - Пхукет' => 'Пхукете', 'Кипр' => 'Кипре', 'Испании - Канарские острова - Тенерифе' => 'Тенерифе', 'Таиланд - Ко Самуи' => 'Самуи');

        if (in_array($this->db_obj->region_title_t, array_keys($exceptions))) {
            $inthe = ' на ';
            $this->db_obj->region_title_t = $exceptions[$this->db_obj->region_title_t];
        }
        $this->db_obj->region_title_t = $inthe.$this->db_obj->region_title_t;

        $page_arr['CENTER_TITLE'] = 'Вы недавно смотрели:';
        $page_arr['PAGE_TITLE'] = 'Виллы'.$this->db_obj->region_title_t.'. Аренда домов, коттеджей, квартир, вилл, аппартаментов'.$this->db_obj->region_title_t.' - '.' стр. '.
            ($_GET['_p'] ? $_GET['_p'] : 1).' - '.$this->layout_obj->project_title;
        
        //$page_arr['DESCRIPTION'] = 'Аренда вилл '.$this->db_obj->region_title_t.', '.$this->layout_obj->description;

        $page_arr['DESCRIPTION'] = $this->db_obj->region_title_p.'. '.$this->layout_obj->description;
        $page_arr['KEYWORDS'] = $this->db_obj->region_title_p.', '.$this->layout_obj->keywords;

        //$page_arr['CENTER_TITLE']   = $this->db_obj->name;
        if ($this->map) {
            $page_arr['BODY_EVENT']   = ' onload="initialize()"';
        }
        $page_arr['BODY_CLASS']   = 'landing';
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

}

?>