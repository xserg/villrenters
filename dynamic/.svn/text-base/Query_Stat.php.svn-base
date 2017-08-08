<?php
/**
////////////////////////////////////////////////////////////////////////////
aservice
------------------------------------------------------------------------------
Отображение текстовых страниц сайта
------------------------------------------------------------------------------
$Id: Pages_Show.php 70 2011-04-11 07:15:31Z xxserg@gmail.com $
////////////////////////////////////////////////////////////////////////////
*/

require_once COMMON_LIB.'DVS/Dynamic.php';
require_once COMMON_LIB.'DVS/Table.php';

class Project_Query_Stat extends DVS_Dynamic
{
    // Права
    public $perms_arr = array('iu' => 1, 'ar' => 1);

    private $pr_arr = array('day' => 'день', 'week' => 'неделя', 'month' => 'месяц');

    function getPageData()
    {
        $this->createTemplateObj();

        $pr = DVS::getVar('pr');


        switch ($pr) {
            case 'month':
                $pr = 'MONTH(post_date)';
                $format = '%m.%Y';
            break;
            case 'week':
                $pr = 'WEEK(post_date)';
                $format = '%v.%x';
            break;
            case 'day':
            default:
                $pr = 'post_date';
                $format = '%d.%m.%Y';
            break;
        }

        $this->db_obj->query("SELECT SQL_CALC_FOUND_ROWS COUNT(id) as cnt, ".$pr." as date, DATE_FORMAT(post_date, '$format') as date_name FROM query GROUP BY date ORDER BY date DESC");

        //$this->db_obj->query("SELECT SQL_CALC_FOUND_ROWS COUNT(id) as cnt, post_date FROM query GROUP BY post_date ORDER BY post_date DESC");

        $this->db_obj->listLabels   = array(
                     //'first_name'     =>  'class="td-name"',
                     'date_name'    =>  '',
                     'cnt'    =>  '',
    );
        $this->db_obj->perms_arr = array(
        'new' => array('iu' => 0, 'oc' => 0, 'aa' => 0),
        'edit' => array('iu' => 0, 'oc' => 0, 'aa' => 0),
        'delete' => array('iu' => 0, 'oc' => 0, 'aa' => 0),

        );
        $page_arr['CENTER_TITLE'] = ' <a href="?op=query">Вопросы</a> Статистика';;
        $page_arr['CENTER'] = '<br>'.$this->periodMenu().'<br><br>'.$this->showTable();
        return $page_arr;
    }

    function periodMenu()
    {
        $pr_cur = DVS::getVar('pr');
        foreach ($this->pr_arr as $pr => $name) {
            if ($pr != $pr_cur) {
                $str .= '<a href="?op=query&act=stat&pr='.$pr.'">'.$name.'</a>&nbsp;';
            } else {
                $str .= '<b>'.$name.'</b>&nbsp;';
            }
        }
        return $str;
    }


    function createTableObj()
    {
        if (!$this->table_obj) {
            require_once COMMON_LIB.'DVS/Table.php';
            $this->table_obj =& new DVS_Table;
        }
    }

    //Функция выполнения запроса в бд по умолчанию
    function getTable()
    {
        //Взять данные из строки запроса
        $this->db_obj->setFrom($_GET);

        //Поиск
        if (isset($_GET['st']) && isset($this->db_obj->search_arr)) {
            //$this->setSearch();
        }

        //Сортировка
        if (isset($this->db_obj->field_order)) {
            //$this->setOrder();
        }

        //Выполнение операций перед выполнение запроса
        if (method_exists($this->db_obj, 'preGenerateList')) { 
            //$this->db_obj->preGenerateList();
        }

        //Сортировка
        //$this->table_obj->sortList(&$this->db_obj);

        //Выполнение SQL - запроса
        //$cnt = $this->db_obj->count();
        //$cnt = $this->count();
        if ($cnt > 0) {
            $this->table_obj->setLimitByPage(&$this->db_obj, $cnt);
            //$this->db_obj->find();
            $this->db_obj->N = $cnt;
        } else {
            $this->nocache = true;
        }
    }

    function count()
    {
        $this->db_obj->query("SELECT FOUND_ROWS() as cnt_all");
        return $this->db_obj->cnt_all;
    }

    function showTable()
    {
        $this->createTableObj();
        $this->getTable();
        return $this->table_obj->buildTable(&$this->db_obj, $this->template_obj, $this->db_obj->qs, $this->role);
    }


    function setSearch()
    {
        if (method_exists($this->db_obj, 'setSearch')) { 
            $this->db_obj->setSearch();
        } else {
            foreach ($this->db_obj->search_arr['fields_search'] as $key=>$val) {
                $where .= $val." LIKE '".$_GET['st']."%' OR ";
            }
            $this->db_obj->whereAdd('('.substr($where, 0, -4).')');
        }
    }

    function setOrder()
    {
        if (method_exists($this->db_obj, 'whereOrder')) { 
            $this->db_obj->whereOrder();
        }
        $this->db_obj->orderBy($this->db_obj->__table.'.'.$this->db_obj->field_order);

        $db_obj = DB_DataObject::factory($this->db_obj->__table);
        $db_obj->orderBy($this->db_obj->field_order.' DESC');
        $db_obj->limit(0,1);
        $db_obj->find(true);
        $this->db_obj->last_field_order = $db_obj->{$this->db_obj->field_order};

        $db_obj = DB_DataObject::factory($this->db_obj->__table);
        $db_obj->orderBy($this->db_obj->field_order.' ASC');
        $db_obj->limit(0,1);
        $db_obj->find(true);
        $this->db_obj->first_field_order = $db_obj->{$this->db_obj->field_order};
    }
}

?>