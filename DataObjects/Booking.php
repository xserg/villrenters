<?php
/**
 * Table Definition for booking
 * $Id: Booking.php 318 2014-01-14 11:52:37Z xxserg@gmail.com $
 */
require_once 'DB/DataObject.php';

class DBO_Booking extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'booking';                         // table name
    public $_database = 'xserg';                         // database name (used with database_{*} config)
    public $id;                              // int(4)  primary_key not_null
    public $villa_id;                        // int(4)  
    public $title;                           // varchar(255)  
    public $img;                             // varchar(255)  
    public $link;                            // varchar(255)  
    public $start_date;                      // date()   not_null
    public $end_date;                        // date()   not_null
    public $user_id;                         // int(4)  
    public $book_status;                     // int(4)  
    public $price;                           // float()  
    public $currency;                        // varchar(11)  
    public $user_name;                       // varchar(255)  
    public $user_email;                      // varchar(255)  
    public $post_date;                       // date()   not_null
    public $people;                          // int(4)  
    public $comment_send;                    // tinyint(1)   not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DBO_Booking',$k,$v); }

    function table()
    {
         return array(
             'id' =>  DB_DATAOBJECT_INT + DB_DATAOBJECT_NOTNULL,
             'villa_id' =>  DB_DATAOBJECT_INT,
             'title' =>  DB_DATAOBJECT_STR,
             'img' =>  DB_DATAOBJECT_STR,
             'link' =>  DB_DATAOBJECT_STR,
             'start_date' =>  DB_DATAOBJECT_STR + DB_DATAOBJECT_DATE + DB_DATAOBJECT_NOTNULL,
             'end_date' =>  DB_DATAOBJECT_STR + DB_DATAOBJECT_DATE + DB_DATAOBJECT_NOTNULL,
             'user_id' =>  DB_DATAOBJECT_INT,
             'book_status' =>  DB_DATAOBJECT_INT,
             'price' =>  DB_DATAOBJECT_INT,
             'currency' =>  DB_DATAOBJECT_STR,
             'user_name' =>  DB_DATAOBJECT_STR,
             'user_email' =>  DB_DATAOBJECT_STR,
             'post_date' =>  DB_DATAOBJECT_STR + DB_DATAOBJECT_DATE + DB_DATAOBJECT_NOTNULL,
             'people' =>  DB_DATAOBJECT_INT,
             'comment_send' =>  DB_DATAOBJECT_INT + DB_DATAOBJECT_BOOL + DB_DATAOBJECT_NOTNULL,
         );
    }

    function keys()
    {
         return array('id');
    }

    function sequenceKey() // keyname, use native, native name
    {
         return array('id', true, false);
    }

    function defaults() // column default values 
    {
         return array(
             '' => null,
         );
    }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

    /**
     * ��������� ��� �������
     */
    public $center_title = '�����';

    /**
     * ��������� ����� (�������� - �������������)
     */
    public $head_form    = '�����';

    /**
     * C������ �������
     */
    public $listLabels   = array(
             'post_date' =>  '',
             'villa_id' => '',
             'villa_title' => '',
             'user_name' =>  '',
             'start_date' =>  '',
             'end_date' =>  '',
             'people' =>  '',
             'price' =>  '',
             'currency' =>  '',
    );

    public $fb_fieldLabels  = array(
             'post_date' =>  '���� ������������',
             'villa_title' => '�����',
             'user_name' =>  '������������',
             'start_date' =>  '�',
             'end_date' =>  '��',
             'people' =>  '�������',
             'price' =>  '����',
             'currency' =>  '&nbsp;',
    );

    public $currency_arr = array('RUR' => '���.', 'USD' => 'USD', 'EUR' => 'EUR');


    function preGenerateList()
    {
        $villa_obj = DB_DataObject::factory('villa');
        $this->joinAdd($villa_obj, 'LEFT');
        $this->selectAs();
        $this->selectAs($villa_obj, 'villa_%s');
        $this->orderBy("id DESC");

    }

    function getLatest($tpl)
    {
        $this->preGenerateList();
        $tpl->addBlockFile("BOTTOM", "BOTTOM", "booking.tpl");
        $tpl->setCurrentBlock("BOTTOM");
        //$this->special_offer = 1;
        $this->limit(0,5);
        $this->find();
        $i = 0;
        while ($this->fetch()) {
               $i++;
                $tpl->setVariable(array(
                'BOOK_VILLA_LINK'      => $this->villa_id ? '/villa/'.$this->villa_id.'.html' : $this->link,
                'BOOK_VILLA_TITLE' => $this->villa_id ? substr($this->villa_title_rus, 0, 20) : $this->title,
                'BOOK_VILLA_IMAGE' => $this->villa_id ? VILLARENTERS_IMAGE_URL.$this->villa_main_image : $this->img,
                //'View_this_property' => '���������...',
                'last' => $i == 5 ? 'last' : '',
                'start' => DVS_Page::RusDate($this->start_date),
                'end' => DVS_Page::RusDate($this->end_date),
                'price' => $this->price.' '.$this->currency,
                    'name' => $this->user_name
                ));
            $tpl->parse('BOOK_VILLA');
        }
    }


    function dateOptions()
    {
        return array(   'language' => 'ru',
                        'format'=>'d-F-Y',
                        'minYear'=>date("Y")-1,
                        'maxYear'=>date("Y")+1,
                        'addEmptyOption' => true
            
        );
    }

}
