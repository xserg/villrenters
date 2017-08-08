<?php
/**
 * Table Definition for articles
 */
require_once 'DB/DataObject.php';

class DBO_Articles extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'articles';                        // table name
    public $_database = 'xserg';                        // database name (used with database_{*} config)
    public $id;                              // int(4)  primary_key not_null
    public $authtor;                         // varchar(255)   not_null
    public $location_id;                     // varchar(255)  
    public $meta_keys;                       // varchar(255)  
    public $meta_descr;                      // varchar(255)  
    public $alias;                           // varchar(64)  
    public $title;                           // varchar(1000)  
    public $body;                            // mediumtext()  
    public $post_date;                       // date()  
    public $post_ip;                         // varchar(255)  
    public $last_date;                       // datetime()   not_null
    public $status_id;                       // smallint(2)   not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DBO_Articles',$k,$v); }

    function table()
    {
         return array(
             'id' =>  DB_DATAOBJECT_INT + DB_DATAOBJECT_NOTNULL,
             'authtor' =>  DB_DATAOBJECT_STR + DB_DATAOBJECT_NOTNULL,
             'location_id' =>  DB_DATAOBJECT_STR,
             'meta_keys' =>  DB_DATAOBJECT_STR,
             'meta_descr' =>  DB_DATAOBJECT_STR,
             'alias' =>  DB_DATAOBJECT_STR,
             'title' =>  DB_DATAOBJECT_STR,
             'body' =>  DB_DATAOBJECT_STR + DB_DATAOBJECT_TXT,
             'post_date' =>  DB_DATAOBJECT_STR + DB_DATAOBJECT_DATE,
             'post_ip' =>  DB_DATAOBJECT_STR,
             'last_date' =>  DB_DATAOBJECT_STR + DB_DATAOBJECT_DATE + DB_DATAOBJECT_TIME + DB_DATAOBJECT_NOTNULL,
             'status_id' =>  DB_DATAOBJECT_INT + DB_DATAOBJECT_NOTNULL,
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

    public $fb_dateElementFormat = 'd.m.y';

    //public $fb_dateFromDatabaseCallback = array('DVS_ShowForm2','date2array');

    //public $fb_dateToDatabaseCallback = array('DVS_ShowForm2','array2date');


    // Заголовок для страницы
    public $center_title = 'Статьи';
    // Названия добавляемого объекта
    public $head_form    = 'статью';

    public $noStripTags = true;

    // Cтолбцы
    public $listLabels   = array(
        'post_date'      => '',
        'location_id' => '',
        'alias'     => '',
        'title'     => '',
    );

    // Название столбцов и элементов формы
    public $fb_fieldLabels  = array(
        'alias'     => 'Cсылка',
        'location_id' => 'Страна',
        'meta_keys' => 'keywords',
        'meta_descr' => 'description',
        'title'     => 'Заголовок',
        'body'      => 'Текст',
        'post_date' => 'Дата',
        'ptype'     => 'Тип'
    );

    public $default_sort = 'post_date desc';

    public $perms_arr = array(
        'list' => array('ar' => 1),
        'edit' => array('ar' => 1),
        'new' => array('ar' => 1),
        'delete' => array('ar' => 1),
    );

    public $status_arr = array(
        1 => 'Новый',
        2 => 'Активный',
        3 => 'Заблокированный'
    );

    function tableRow()
    {
        return array(
            'post_date'  => DVS_Dynamic::RusDate($this->post_date),
            'location_id' => $this->countries_name,
            'alias' => '<a href="?op=articles&act=show&id='.$this->id.'">'.$this->alias.'</a>',
            'title' => $this->title,
        );
    }

    function getNewsBlock($tpl, $cnt=3)
    {
        //$tpl->loadTemplateFile('news.tpl');
        $tpl->addBlockfile('RIGHT', 'NEWS', 'news.tpl');
        $this->ptype = 1;
        $this->orderBy('post_date DESC');
        $this->limit(0, $cnt);
        $this->find();
        while ($this->fetch()) {
            $tpl->setVariable(array(
                'NDATE' => DVS_Dynamic::RusDate($this->post_date),
                'NLINK' => '/pages/'.$this->alias,
                'NLINK_TEXT' => $this->title
                ));
            $tpl->parse('NEWS_ITEM');
        }
        return;
    }


    //Вывод формы
    function getForm()
    {
		//print_r($_SESSION);
        $country_obj = DB_DataObject::factory('countries');
        $country_arr = $country_obj->selArray();

        $this->src_files = array(
            //'JS_SRC' => array('/js/jquery.js', '/js/jqUploader/jquery.jqUploader.js', '/js/jquery.flash.js'),
            'CSS_SRC'  => array('/css/form.css')
        );
        $form =& new HTML_QuickForm('', '', $_SERVER['REQUEST_URI'], '', 'class="reg"');
        //$form->addElement('header', null, strtoupper(($_GET['act'] == 'new' ? 'Добавить' : 'Редактировать').' '.$this->head_form));
        //$form->addElement('select', 'server', 'Сервер: ', array($this->common_server => '') + $this->server_arr);
        //$form->addElement('select', 'ptype', $this->fb_fieldLabels['ptype'].': ', array(1 => 'Новость', 2 => 'Текст', 3 => 'Помощь'));
        $form->addElement('text', 'meta_keys', $this->fb_fieldLabels['meta_keys'].': ', 'size=100');
        $form->addElement('text', 'meta_descr', $this->fb_fieldLabels['meta_descr'].': ', 'size=100');
        $form->addElement('select', 'location_id', $this->fb_fieldLabels['location_id'].': ', array('' => '')+$country_arr);
        $form->addElement('text', 'alias', $this->fb_fieldLabels['alias'].': ', 'size=100');
        $form->addElement('text', 'title', $this->fb_fieldLabels['title'].': ', 'size=100');
        $form->addElement('date', 'post_date', $this->fb_fieldLabels['post_date'], $this->dateOptions());

        //$form->addElement(DVS_ShowForm2::createFCK('text'));
        $form->addElement('textarea', 'body', $this->fb_fieldLabels['body'].': ', array('cols' => 100, 'rows' => 30));
        if ($_SESSION['_authsession']['data']['role_id'] == 'aa') {
            $form->addElement('select', 'status_id', 'Статус:', $this->status_arr);
        }
        $form->addElement('submit', '__submit__', 'Сохранить');
        $form->addRule('alias', 'Заполните поле '.$this->fb_fieldLabels['alias'].'!', 'required', null, 'client');
        $form->addRule('title', 'Заполните поле '.$this->fb_fieldLabels['title'].'!', 'required', null, 'client');
        $form->addRule('body', 'Заполните поле '.$this->fb_fieldLabels['body'].'!', 'required', null);
		if (DVS::getVar('act') == 'new') {
            $form->setDefaults(array('post_date' => date('Y-m-d')));
        } else {
            $form->setDefaults($this->toArray());
        }
        return $form;
    }



    function dateOptions()
    {
        return array(   'language' => 'ru',
                        'format'=>'d-F-Y',
                        'minYear'=>date("Y")-1,
                        'maxYear'=>date("Y"),
                        'addEmptyOption' => true
            
        );
    }

    function preProcessForm(&$vals, $fb)
    {
        if ($this->act == 'new') {
            $fb->dateToDatabaseCallback = null;
            $vals['authtor']          = $_SESSION['_authsession']['username'];
            $vals['post_date']       = date(DB_DATE_FORMAT);
            //$vals['reg_date']       = date('d.m.Y');
            require_once COMMON_LIB.'DVS/Auth.php';
            $vals['post_ip']   = DVS_Auth::getIP();
			$vals['status_id']   = 1;
            //$this->qs = '/?op=static&act=reg_email';
            //$this->msg = DVS_REG_EMAIL;
        } else {
            //$this->userEditableFields = array(

            //);
            //$this->qs = '/office/';
        }
    }

    function preGenerateList()
    {
        $countries_obj = DB_DataObject::factory('countries');
        $this->joinAdd($countries_obj);
        $this->selectAs();
        $this->selectAs($countries_obj, 'countries_%s');
        $this->orderBy("id DESC");
    }
}
