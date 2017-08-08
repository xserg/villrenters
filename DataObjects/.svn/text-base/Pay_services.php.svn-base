<?php
/**
 * Table Definition for pay_services
 */
require_once 'DB/DataObject.php';

class DBO_Pay_services extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'pay_services';                    // table name
    public $_database = 'villa';                    // database name (used with database_{*} config)
    public $id;                              // int(4)  primary_key not_null
    public $name;                            // varchar(255)  
    public $status;                          // int(4)  
    public $about;                           // varchar(4000)  
    public $service_type_id;                 // int(4)  

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DBO_Pay_services',$k,$v); }

    function table()
    {
         return array(
             'id' =>  DB_DATAOBJECT_INT + DB_DATAOBJECT_NOTNULL,
             'name' =>  DB_DATAOBJECT_STR,
             'status' =>  DB_DATAOBJECT_INT,
             'about' =>  DB_DATAOBJECT_STR,
             'service_type_id' =>  DB_DATAOBJECT_INT,
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
