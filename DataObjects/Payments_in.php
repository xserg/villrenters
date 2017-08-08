<?php
/**
 * Table Definition for payments_in
 */
require_once 'DB/DataObject.php';

class DBO_Payments_in extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'payments_in';                     // table name
    public $_database = 'villa';                     // database name (used with database_{*} config)
    public $id;                              // int(4)  primary_key not_null
    public $external_id;                     // int(4)  
    public $pay_date;                        // date()  
    public $ammount;                         // int(4)  
    public $about;                           // varchar(4000)  
    public $advertiser_id;                   // int(4)  
    public $pay_service_id;                  // int(4)  

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DBO_Payments_in',$k,$v); }

    function table()
    {
         return array(
             'id' =>  DB_DATAOBJECT_INT + DB_DATAOBJECT_NOTNULL,
             'external_id' =>  DB_DATAOBJECT_INT,
             'pay_date' =>  DB_DATAOBJECT_STR + DB_DATAOBJECT_DATE,
             'ammount' =>  DB_DATAOBJECT_INT,
             'about' =>  DB_DATAOBJECT_STR,
             'advertiser_id' =>  DB_DATAOBJECT_INT,
             'pay_service_id' =>  DB_DATAOBJECT_INT,
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
}
