<?php
/**
 * Table Definition for countries
 */
require_once 'DB/DataObject.php';

class DBO_Countries extends DB_DataObject
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'countries';                       // table name
    public $_database = 'rurenter';                       // database name (used with database_{*} config)
    public $id;                              // int(4)  primary_key not_null
    public $parent_id;                       // int(4)   not_null
    public $name;                            // varchar(255)   not_null
    public $rus_name;                        // varchar(255)   not_null
    public $counter;                         // int(4)
    public $country_descr;                   // text()
    public $popular;                         // tinyint(1)

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DBO_Countries',$k,$v); }

    function table()
    {
         return array(
             'id' =>  DB_DATAOBJECT_INT + DB_DATAOBJECT_NOTNULL,
             'parent_id' =>  DB_DATAOBJECT_INT + DB_DATAOBJECT_NOTNULL,
             'name' =>  DB_DATAOBJECT_STR + DB_DATAOBJECT_NOTNULL,
             'rus_name' =>  DB_DATAOBJECT_STR + DB_DATAOBJECT_NOTNULL,
             'counter' =>  DB_DATAOBJECT_INT,
             'country_descr' =>  DB_DATAOBJECT_STR + DB_DATAOBJECT_TXT,
             'popular' =>  DB_DATAOBJECT_INT + DB_DATAOBJECT_BOOL,
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
/*
    function sequenceKey() // keyname, use native, native name
    {
        return $this->disable_sk ? array() : array('id', false, false);
    }
*/
    public $listLabels   = array(
            'name'      => '',
            'rus_name' => '',
            'counter' => '',
            'delvilla' => ''
    );

    public $qs_arr = array('parent_id');

    function __construct()
    {
      $this->query("SET NAMES cp1251");
    }

    function tableRow()
    {

        $villa_obj = DB_DataObject::factory('villa');
        $villa_obj->whereAdd('locations_all LIKE "%:'.$this->id.':%"');
        $cnt = $villa_obj->count();

        return array(
            'name'      => '<a href="?op=countries&parent_id='.$this->id.'">'.$this->name.'</a>',
            'rus_name' => $this->rus_name,
            'counter' =>  '<a href="?op=villa&loc='.$this->id.'">'.$this->counter.' ('.$cnt.')</a>',
            'delvilla' => '<a href="?op=villa&act=del&loc='.$this->id.'" onclick="return doDelete();">������� �����</a>'
        );
    }

    function preGenerateList()
    {
        if (!isset($this->parent_id)) {
            $this->parent_id = 0;
        } else {
            /*
            $�ountries_obj = DB_DataObject::factory('countries');
            $�ountries_obj->get($this->parent_id);
            $this->center_title .= ' / '.$�ountries_obj->name;
            */
            $this->getParent($this->parent_id);
            $this->center_title .= ' / '.$this->region_title;
            //print_r($�ountries_obj->toArray());
            //$this->qs .= '&adm_unit_type='.$type_obj->adm_unit_type;
        }
    }

    static function declineName($str)
    {
        if (preg_match("/�$/", $str)) {
            return preg_replace("/�$/", "�", $str);
        }
        return $str;
    }

    function getParent($pid, $link='regions/')
    {
        $�ountries_obj = DB_DataObject::factory('countries');
        $�ountries_obj->database($this->database());
        //$�ountries_obj->database('rurenter');
        $�ountries_obj->get($pid);
        if ($�ountries_obj->parent_id > 0) {
            $this->region_title_t = DBO_Countries::declineName($�ountries_obj->rus_name).($this->region_title_t ? ' - ' : '').$this->region_title_t;
            $this->region_title_p = $�ountries_obj->rus_name;
        }
        if ($�ountries_obj->country_descr && !$this->country_description) {
            $this->country_description = '<br>'.$�ountries_obj->country_descr.'<br><br>';
        }

        if (!$this->region_title_t) {
            //$this->region_title_t = $�ountries_obj->rus_name;
            $this->region_title_a = '<a href="/regions/'.$�ountries_obj->getAlias().'">'.$�ountries_obj->getLocalName().'</a>';

        }
        $this->region_title = '<a href="/regions/'.$�ountries_obj->getAlias().'">'.$�ountries_obj->getLocalName().'</a> / '.$this->region_title;
        $this->locations_all = $�ountries_obj->id.($this->locations_all ? ':'.$this->locations_all : '');
        if ($�ountries_obj->parent_id > 0) {
            $this->getParent($�ountries_obj->parent_id, $link);
        }
    }

    function getParent2($pid, $link='')
    {
        $�ountries_obj = DB_DataObject::factory('countries');
        $�ountries_obj->get($pid);
        if (!$this->region_title_t) {
            $this->region_title_t = DBO_Countries::declineName($�ountries_obj->getLocalName());
        }
        $this->region_title = '<a href="/'.$�ountries_obj->ha_alias.'/r'.$�ountries_obj->id.$link.'">'.$�ountries_obj->getLocalName().'</a> / '.$this->region_title;
        if ($�ountries_obj->parent_id > 0) {
            $this->getParent2($�ountries_obj->parent_id, $link);
        }
    }

    function getChilds($pid)
    {
        $�ountries_obj = DB_DataObject::factory('countries');
        $�ountries_obj->parent_id = $pid;
        $�ountries_obj->find();
        if ($�ountries_obj->N == 0) {
            $this->loc_arr[] = $pid;
        }
        while ($�ountries_obj->fetch()) {
            //$this->childs[$pid][] = $�ountries_obj->id;
            $this->getChilds($�ountries_obj->id);
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
        return strtolower(str_replace(array(" ", "&"), array("_",'and'), trim($this->name)));
    }

    function getLocationsIdStr($alias)
    {
        $loc_arr = explode('\\', $alias);
    }

    function findLocationByKeyword($keyword)
    {
        $this->whereAdd('parent_id > 0');
        $this->whereAdd('name LIKE "'.$keyword.'%"');
    }

    function selArray()
    {
        $this->whereAdd("parent_id < 3950 AND parent_id > 3900 and id < 1000");
        $this->orderBy('name');
        $this->find();
        while ($this->fetch()) {
            $ret[$this->id] = $this->name;
        }
        return $ret;
    }

    function selArray2()
    {
        $sql = "SELECT code, name, rus_name FROM interhome.countries WHERE type='country' ORDER BY rus_name";
        $this->query($sql);
        while ($this->fetch()) {
            $ret[$this->code] = $this->rus_name;
        }
        return $ret;
    }

    function getList($parent_id=0, $proptype=null, $sale=0)
    {
        if ($proptype) {
            //$prop_str = " AND proptype IN ('$proptype')";
            $prop_str = " AND ".$proptype;
        }
        $sql ="SELECT countries.name, rus_name, countries.id as id, COUNT(villa.id) as counter FROM countries JOIN villa ON (villa.locations_all LIKE CONCAT('%:', countries.id, ':%')) WHERE parent_id=$parent_id AND villa.status_id=2 AND sale=$sale$prop_str group by countries.id order by rus_name";
        $this->query($sql);
    }

}
