<?php
/**
 * Table Definition for options
 */
require_once 'DB/DataObject.php';

class DBO_Options extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'options';                         // table name
    public $_database = 'rurenter';                         // database name (used with database_{*} config)
    public $id;                              // int(4)  primary_key not_null
    public $group_id;                        // int(4)   not_null
    public $name;                            // varchar(255)  
    public $rus_name;                        // varchar(255)  
    public $value_type;                      // tinyint(1)   not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DBO_Options',$k,$v); }

    function table()
    {
         return array(
             'id' =>  DB_DATAOBJECT_INT + DB_DATAOBJECT_NOTNULL,
             'group_id' =>  DB_DATAOBJECT_INT + DB_DATAOBJECT_NOTNULL,
             'name' =>  DB_DATAOBJECT_STR,
             'rus_name' =>  DB_DATAOBJECT_STR,
             'value_type' =>  DB_DATAOBJECT_INT + DB_DATAOBJECT_BOOL + DB_DATAOBJECT_NOTNULL,
         );
    }

    function keys()
    {
         return array('id');
    }

    function sequenceKey() // keyname, use native, native name
    {
         return array('id', false, false);
    }

    function defaults() // column default values 
    {
         return array(
             '' => null,
         );
    }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

    public $listLabels   = array(
             'name' =>  '',
             'rus_name' =>  '',
    );

    function getLocalName()
    {
        if (LANG == 'ru') {
            return $this->rus_name;
        }
        return $this->name;
    }
}
