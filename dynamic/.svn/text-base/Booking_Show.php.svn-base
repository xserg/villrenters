<?php
/*////////////////////////////////////////////////////////////////////////////
Список букингов
------------------------------------------------------------------------------

------------------------------------------------------------------------------
$Id: $
////////////////////////////////////////////////////////////////////////////
*/

require_once COMMON_LIB.'DVS/Dynamic.php';
require_once COMMON_LIB.'DVS/Table.php';

define('PER_PAGE', 10);

class Project_Booking_Show extends DVS_Dynamic
{
    // Права
    public $perms_arr = array('iu' => 1, 'ar' => 1);

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
        $this->createTemplateObj();
        $this->template_obj->loadTemplateFile('booking_show.tpl');
        //$this->db_obj->preGenerateList();
        $links =  DVS_Table::createPager($this->db_obj);

            //$this->db_obj->orderBy('villarentersindex DESC');
            $this->db_obj->find();

            while ($this->db_obj->fetch()) {
                $this->template_obj->setVariable(array(
                //'LINK'      => '?op=villa&act=show&id=',
                //'RENT'      => 'аренда ',
                'LINK'      => $this->db_obj->villa_id ? '/villa/'.$this->villa_id.'.html' : $this->db_obj->link,
                'VILLA_ID' => $this->db_obj->villa_id,
                'TITLE' => $this->db_obj->villa_title_rus ? $this->db_obj->villa_title_rus : ($this->db_obj->villa_title ? $this->db_obj->villa_title : $this->db_obj->title),

                'SUMMARY' => $this->db_obj->villa_summary_rus ? $this->db_obj->villa_summary_rus : $this->db_obj->villa_summary,
                'PROPTYPE' => 'аренда '.$this->db_obj->propTypeName($this->db_obj->proptype),
                'SLEEPS_NUM' => $this->db_obj->villa_sleeps,
                'Rating' => $this->db_obj->villa_villarentersindex,
                'MIN_PRICE' => DVS_Page::RusDate($this->db_obj->start_date),
                'MAX_PRICE' => DVS_Page::RusDate($this->db_obj->end_date),
                'CURRENCY' => $this->db_obj->price.' '.$this->db_obj->currency,
                'M_PHOTO_SRC' => $this->db_obj->villa_id ? VILLARENTERS_IMAGE_URL.$this->db_obj->villa_main_image : $this->db_obj->img,
                'M_ALT_TEXT' => 'аренда '.$this->db_obj->propTypeName($this->db_obj->proptype).' - '.($this->db_obj->title_rus ? $this->db_obj->title_rus : $this->db_obj->title),
                'name' => $this->db_obj->user_name
                ));
                $this->template_obj->parse('VILLA');
            }

            $this->template_obj->setVariable(array(
            //'PAGES'      => '?op=villa&act=show&id=',
            'CNT' => $links['cnt'] ? 'Всего: '.$links['cnt'] : '',
            'PAGES'      =>     $links['all'],
                'SEARCH_FORM' => $search_form,
                'MAP_LINK' => $maplink,
            ));
        $this->template_obj->setGlobalVariable($this->lang_ru);

        $page_arr['BODY_CLASS']     = 'landing';
        //$page_arr['BODY_CLASS']     = 'homePage';
        $page_arr['CENTER_TITLE']   = 'Последние забронированные объекты';
        $page_arr['PAGE_TITLE'] = $this->layout_obj->project_title.' - Аренда вилл, домов, коттеджей, аппартаментов';

        $page_arr['CENTER']         = $this->template_obj->get();
        return $page_arr;
    }
/*
    function getList($tpl)
    {
        $this->preGenerateList();
       $links =  DVS_Table::createPager($this->db_obj);

        $this->find();
        $i = 0;
        while ($this->fetch()) {
               $i++;
                $tpl->setVariable(array(
                'BOOK_VILLA_LINK'      => '/villa/'.$this->villa_id.'.html',
                'BOOK_VILLA_TITLE' => substr($this->villa_title_rus, 0, 20),
                'BOOK_VILLA_IMAGE' => VILLARENTERS_IMAGE_URL.$this->villa_main_image,
                //'View_this_property' => 'Подробнее...',
                'last' => $i == 5 ? 'last' : '',
                'start' => DVS_Page::RusDate($this->start_date),
                'end' => DVS_Page::RusDate($this->end_date),
                'price' => $this->price.' '.$this->currency,
                    'name' => $this->user_name
                ));
            $tpl->parse('BOOK_VILLA');
        }
    }
*/
}

?>