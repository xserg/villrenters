<?php
/**
 * ������ ����
 * @package villarenters
 * $Id: Villa_Geo.php 165 2012-02-14 13:03:00Z xxserg@gmail.com $
 */

define('PER_PAGE', 10);

require_once COMMON_LIB.'DVS/Dynamic.php';
require_once COMMON_LIB.'DVS/Table.php';


class Project_Villa_Geo extends DVS_Dynamic
{
    // �����
    public $perms_arr = array('iu' => 1, 'oc' => 1);


    function getPageData()
    {        

        $keyword = DVS::getVar('keyword');
        $minprice = DVS::getVar('minprice', 'int');
        $maxprice = DVS::getVar('maxprice', 'int');
        $start = DVS::getVar('startDateInput');
        $end = DVS::getVar('endDateInput');
        $sleeps = DVS::getVar('sleeps');
        $proptype = DVS::getVar('proptype');

        $this->createTemplateObj();
        $this->template_obj->loadTemplateFile('georss.tpl');

        $this->db_obj->setSearchParams( $this->template_obj, $minprice, $maxprice, $sleeps, $proptype);
        $this->db_obj->whereAdd("lat != 0 AND lon != 0");
        $this->db_obj->preGenerateList();
        //$links =  DVS_Table::createPager($this->db_obj);
        $this->db_obj->orderBy('villarentersindex DESC');
        $this->db_obj->limit(0,200);
        $this->db_obj->find();

//print_r($_SERVER);

        while ($this->db_obj->fetch()) {
            if ($this->db_obj->lat != 0 && $this->db_obj->lon != 0) {
                $this->template_obj->setVariable(array(
                //'LINK'      => 'http://villa/?op=villa&act=map&alias='.$_GET['alias'],
                'VILLA_LINK' => 'http://villarenters.ru/villa/'.$this->db_obj->id.'.html',
                'TITLE' => utf8_encode (htmlspecialchars($this->db_obj->title)),
                
                'SUMMARY' =>  htmlspecialchars('<a href="http://villarenters.ru/villa/'.$this->db_obj->id.'.html"><img src='.VILLARENTERS_IMAGE_URL.$this->db_obj->main_image.' title="'.$this->db_obj->sleeps.' sleeps '.$this->db_obj->proptype.'"><br>'.$this->db_obj->summary.'</a>'),

                //'TITLE' => $this->db_obj->title_rus ? $this->db_obj->title_rus : $this->db_obj->title,
                //'SUMMARY' => $this->db_obj->summary_rus ? $this->db_obj->summary_rus : $this->db_obj->summary,
                
                'PROPTYPE' => '������: '.$this->db_obj->propTypeName($this->db_obj->proptype),
                'SLEEPS_NUM' => $this->db_obj->sleeps,
                'Rating' => $this->db_obj->villarentersindex,
                'MIN_PRICE' => $this->db_obj->minprice,
                'MAX_PRICE' => $this->db_obj->maxprice,
                'CURRENCY' => $this->db_obj->currency,
                'M_PHOTO_SRC' => VILLARENTERS_IMAGE_URL.$this->db_obj->main_image,
                'LAT' => $this->db_obj->lat,
                'LON' => $this->db_obj->lon,
                ));
                $this->template_obj->parse('VILLA');
            }
        }

            $this->template_obj->setVariable(array(
                //'PAGE_TITLE' => '������ ���� '.$this->db_obj->region_title_t.', '.$this->layout_obj->description,
                //'SELF' => 'http://villarenters.ru?op=villa&act=geo&alias='.$_GET['alias'],
            ));
        echo $this->template_obj->get();
        exit;
        //return $page_arr;
    }

}
?>