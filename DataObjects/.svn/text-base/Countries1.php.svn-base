<?php
/**
 * Table Definition for countries
 */
require_once 'DB/DataObject.php';

class DBO_Countries1 extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'countries1';                      // table name
    public $_database = 'xserg';                      // database name (used with database_{*} config)
    public $id;                              // int(4)  primary_key not_null
    public $parent_id;                       // int(4)   not_null
    public $name;                            // varchar(255)   not_null
    public $rus_name;                        // varchar(255)   not_null
    public $counter;                         // int(4)  

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DBO_Countries1',$k,$v); }

    function table()
    {
         return array(
             'id' =>  DB_DATAOBJECT_INT + DB_DATAOBJECT_NOTNULL,
             'parent_id' =>  DB_DATAOBJECT_INT + DB_DATAOBJECT_NOTNULL,
             'name' =>  DB_DATAOBJECT_STR + DB_DATAOBJECT_NOTNULL,
             'rus_name' =>  DB_DATAOBJECT_STR + DB_DATAOBJECT_NOTNULL,
             'counter' =>  DB_DATAOBJECT_INT,
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

    public $listLabels   = array(
            'name'      => '',
            'rus_name' => '',
            'counter' => '',
    );

    public $qs_arr = array('parent_id');

    function tableRow()
    {

        $villa_obj = DB_DataObject::factory('villa');
        $villa_obj->whereAdd('locations_all LIKE "%:'.$this->id.':%"');
        $cnt = $villa_obj->count();

        return array(
            'name'      => '<a href="?op=countries&parent_id='.$this->id.'">'.$this->name.'</a>',
            'rus_name' => $this->rus_name,
            'counter' =>  '<a href="?op=villa&loc='.$this->id.'">'.$this->counter.' ('.$cnt.')</a>',
        );
    }

    function preGenerateList()
    {
        if (!isset($this->parent_id)) {
            $this->parent_id = 0;
        } else {
            /*
            $ñountries_obj = DB_DataObject::factory('countries');
            $ñountries_obj->get($this->parent_id);
            $this->center_title .= ' / '.$ñountries_obj->name;
            */
            $this->getParent($this->parent_id);
            $this->center_title .= ' / '.$this->region_title;
            //print_r($ñountries_obj->toArray());
            //$this->qs .= '&adm_unit_type='.$type_obj->adm_unit_type;
        }
    }

    function getParent($pid, $link='?op=countries&parent_id=')
    {
        $ñountries_obj = DB_DataObject::factory('countries');
        $ñountries_obj->get($pid);
        $this->region_title_t = $ñountries_obj->name.' / '.$this->region_title_t;
        
        $this->region_title = '<a href="/'.$link.$ñountries_obj->id.'">'.$ñountries_obj->getLocalName().'</a> / '.$this->region_title;


        $this->region_title_a = '<a href="/regions/'.$ñountries_obj->getAlias().'">'.$ñountries_obj->getLocalName().'</a> / '.$this->region_title_a;

        

        $this->locations_all = $ñountries_obj->id.($this->locations_all ? ':'.$this->locations_all : '');
        if ($ñountries_obj->parent_id > 0) {
            $this->getParent($ñountries_obj->parent_id);
        }
    }


    function getChilds($pid)
    {
        $ñountries_obj = DB_DataObject::factory('countries');
        $ñountries_obj->parent_id = $pid;
        $ñountries_obj->find();
        if ($ñountries_obj->N == 0) {
            $this->loc_arr[] = $pid;
        }
        while ($ñountries_obj->fetch()) {
            //$this->childs[$pid][] = $ñountries_obj->id;
            $this->getChilds($ñountries_obj->id);
        }
    }

    function getLocalName()
    {
        if (LANG == 'ru') {
            return $this->rus_name;
        }
        return $this->name;
    }

    function getAlias()
    {
        return strtolower(str_replace(" ", "_", $this->name));
    }

    function getLocationsIdStr($alias)
    {
        $loc_arr = explode('\\', $alias);

        
    }
}
