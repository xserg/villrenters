<?php
/**
 * Table Definition for query
 * $Id: Query.php 388 2015-04-30 08:59:18Z xxserg $
 */
require_once 'DB/DataObject.php';

class DBO_Query extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'query';                           // table name
    public $_database = 'xserg';                           // database name (used with database_{*} config)
    public $id;                              // int(4)  primary_key not_null
    public $villa_id;                        // int(4)   not_null
    public $user_id;                         // int(4)   not_null
    public $first_name;                      // varchar(255)   not_null
    public $last_name;                       // varchar(255)   not_null
    public $email;                           // varchar(255)  
    public $country_id;                      // int(4)   not_null
    public $phone;                           // varchar(255)  
    public $start_date;                      // date()   not_null
    public $end_date;                        // date()   not_null
    public $quantity;                        // int(4)   not_null
    public $children;                        // int(4)   not_null
    public $body;                            // mediumtext()  
    public $post_date;                       // date()  
    public $ip;                              // varchar(255)   not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DBO_Query',$k,$v); }

    function table()
    {
         return array(
             'id' =>  DB_DATAOBJECT_INT + DB_DATAOBJECT_NOTNULL,
             'villa_id' =>  DB_DATAOBJECT_INT + DB_DATAOBJECT_NOTNULL,
             'user_id' =>  DB_DATAOBJECT_INT + DB_DATAOBJECT_NOTNULL,
             'first_name' =>  DB_DATAOBJECT_STR + DB_DATAOBJECT_NOTNULL,
             'last_name' =>  DB_DATAOBJECT_STR + DB_DATAOBJECT_NOTNULL,
             'email' =>  DB_DATAOBJECT_STR,
             'country_id' =>  DB_DATAOBJECT_INT + DB_DATAOBJECT_NOTNULL,
             'phone' =>  DB_DATAOBJECT_STR,
             'start_date' =>  DB_DATAOBJECT_STR + DB_DATAOBJECT_DATE + DB_DATAOBJECT_NOTNULL,
             'end_date' =>  DB_DATAOBJECT_STR + DB_DATAOBJECT_DATE + DB_DATAOBJECT_NOTNULL,
             'quantity' =>  DB_DATAOBJECT_INT + DB_DATAOBJECT_NOTNULL,
             'children' =>  DB_DATAOBJECT_INT + DB_DATAOBJECT_NOTNULL,
             'body' =>  DB_DATAOBJECT_STR + DB_DATAOBJECT_TXT,
             'post_date' =>  DB_DATAOBJECT_STR + DB_DATAOBJECT_DATE,
             'ip' =>  DB_DATAOBJECT_STR + DB_DATAOBJECT_NOTNULL,
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

    //public $fb_fieldsToRender = array('first_name');

    public $use_project_form_tmpl = true;

    public $form_template_name = 'form_query.tpl';

    /**
     * Cтолбцы таблицы
     */
    public $listLabels   = array(
                     'first_name'     =>  'class="td-name"',
                     'email'    =>  '',
                     'phone'    =>  '',
                     //'reg_date' =>  'class="td-date"',
                     //'role_id'     =>  ''
    );
    public $perms_arr = array(
        'new' => array('iu' => 1, 'mu' => 1, 'oc' => 1),
    );


    public function preGenerateList()
    {
        $stat = DVS::getVar('stat');
        if ($stat) {
            $this->center_title = ' <a href="?op=query">Вопросы</a> Статистика';
            //$this->query("SELECT COUNT(id) as cnt, post_date FROM query GROUP BY post_date ORDER BY post_date DESC");

        } else {
            $this->center_title = 'Вопросы <a href="?op=query&act=stat">Статистика</a>';
        }
    }

    public function getForm()
    {

        $villa_id = DVS::getVar('villa_id');
        $villa_obj = DB_DataObject::factory('villa');
        $villa_obj->get($villa_id);
        if ($villa_obj->N) {
            $this->center_title .= ' по '.$villa_obj->title_rus.' ('.$villa_id.')';
        }
        $form =& new HTML_QuickForm('', '', $_SERVER['REQUEST_URI'], '', 'class="reg"');
        $form->addElement('hidden', 'villa_id', $villa_id);
        $form->addElement('hidden', 'villa_user_id',  $villa_obj->user_id);
        $form->addElement('header', null, 'Контактная информация');
        $form->addElement('text', 'first_name', $this->fb_fieldLabels['first_name'].': ');
        $form->addElement('text', 'last_name', $this->fb_fieldLabels['last_name'].': ');
        $form->addElement('text', 'email', $this->fb_fieldLabels['email'].': ');
        $form->addElement('text', 'email2', $this->fb_fieldLabels['email2'].': ');

        $form->addElement('text', 'phone', $this->fb_fieldLabels['phone'].': ');
        $form->addElement('static', null, '</div><div class="clear"></div></div>');
        $form->addElement('header', null, 'Вопрос');
        $form->addElement('textarea', 'body', '');

        //print_r($_SERVER['HTTP_REFERER']);
        DVS_ShowForm::formCaptcha($form);
        
        $form->addElement('submit', '__submit__', DVS_SAVE);
        $form->addElement('static', null, '</div></div>');
        $form->addRule('last_name', DVS_REQUIRED.' "'.$this->fb_fieldLabels['last_name'].'"!', 'required', null, 'client');
        $form->addRule('first_name', DVS_REQUIRED.' "'.$this->fb_fieldLabels['first_name'].'"!', 'required', null, 'client');
        $form->addRule('phone', DVS_REQUIRED.' "'.$this->fb_fieldLabels['phone'].'"!', 'required', null, 'client');
        //$form->addRule('phone', 'Непроавильный формат поля '.$this->fb_fieldLabels['phone'].'!', 'regex', '/^[0-9-\(\)]{7,14}$/');

        $form->addRule('email', DVS_REQUIRED.' "'.$this->fb_fieldLabels['email'].'"!', 'required', null, 'client');
        $form->addRule('email', 'Неправильный формат "'.$this->fb_fieldLabels['email'].'"!', 'email', null, 'client');
        $form->addRule('email2', DVS_REQUIRED.' "'.$this->fb_fieldLabels['email2'].'"!', 'required', null, 'client');
        $form->addRule(array('email', 'email2'), $this->fb_fieldLabels['email_not_match'], 'compare', null, 'client');

        $date1 = DVS::getVar('date1');
        $date2 = DVS::getVar('date2');
        $people = DVS::getVar('people');
        $childs = DVS::getVar('chd');
        $ifants = DVS::getVar('inf');

        if ($date1) {
            $body = "\nПериод с ".$date1.' по '.$date2.' '.$people.' взр., детей:'.$childs.', мал.:'.$ifants;
        }

        $form->setDefaults( array('body' => $this->center_title.$body));
        return $form;
    }

    function preProcessForm(&$vals, $fb)
    {
        if ($this->act == 'new') {
            $fb->dateToDatabaseCallback = null;
            $vals['email']          = strtolower($vals['email']);
            $vals['post_date']       = date(DB_DATE_FORMAT);
            //$vals['reg_date']       = date('d.m.Y');
            require_once COMMON_LIB.'DVS/Auth.php';
            $vals['ip']   = DVS_Auth::getIP();
            //$this->qs = '/?op=static&act=reg_email';
            //$this->msg = DVS_REG_EMAIL;
        } else {
            //$this->userEditableFields = array(

            //);
            //$this->qs = '/office/';
        }
    }

    function postProcessForm(&$vals, &$fb)
    {

            if ($this->act == 'new') {
                if ($this->iface != 'admin') {
                    $this->adminLetter($vals);
                    $this->qs = '/pages/newquery';
                }
            }
    }

    function adminLetter($vals)
    {
        require_once COMMON_LIB.'DVS/Mail.php';
        $data['to'] = MAIL_ADMIN.',irina@villarenters.ru';
        $data['from'] = $vals['email'];
        $data['reply-to'] = $vals['email'];

        $data['subject'] = 'Новый вопрос по объекту Villarenters.ru '.$vals['villa_id'];
        if ($vals['villa_user_id'] == LETINTHESUN_ID) {
            $data['subject'] = 'Новый вопрос по объекту LetInTheSun '.$vals['villa_id'];
        }
        //$data['body'] = DVS_Mail::letter($vals, 'reg_admin.tpl');
        $data['body'] = 
        'Имя: '.$vals['first_name']."\n"
        .'Фамилия: '.$vals['last_name']."\n"
        .'Е-mail: '.$vals['email']."\n"
        .'Телефон: '.$vals['phone']."\n\n"
        .'Дата: '.$vals['post_date']."\n"
        .'IP: '.$vals['ip']."\n\n"
        .'http://villarenters.ru/villa/'.$vals['villa_id'].".html\n"
        ."\n\n".$vals['body'];
        DVS_Mail::send($data);
    }

}
