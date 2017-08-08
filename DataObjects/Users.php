<?php
/**
 * Table Definition for users
 */
require_once 'DB/DataObject.php';

class DBO_Users extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'users';                           // table name
    public $_database = 'rurenter';                           // database name (used with database_{*} config)
    public $id;                              // int(4)  primary_key not_null unsigned
    public $email;                           // varchar(255)   not_null
    public $password;                        // varchar(128)   not_null
    public $reg_date;                        // datetime()   not_null
    public $last_date;                       // datetime()  
    public $last_ip;                         // varchar(64)  
    public $role_id;                         // char(2)   not_null
    public $name;                            // varchar(255)  
    public $lastname;                        // varchar(255)  
    public $passport_series;                 // int(4)   not_null
    public $passport_no;                     // int(4)   not_null
    public $passport_date;                   // date()   not_null
    public $passport_given;                  // varchar(255)   not_null
    public $age;                             // varchar(255)  
    public $country;                         // varchar(255)  
    public $city;                            // varchar(255)  
    public $street;                          // varchar(255)  
    public $house_num;                       // varchar(255)  
    public $post_code;                       // int(4)  
    public $address;                         // varchar(255)  
    public $home_phone;                      // varchar(32)  
    public $work_phone;                      // varchar(32)  
    public $mobile_phone;                    // varchar(32)  
    public $company;                         // varchar(255)  
    public $status_id;                       // int(4)  
    public $reg_code;                        // varchar(255)  
    public $balance;                         // float()  
    public $note;                            // tinytext()  
    public $agree;                           // int(4)   not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DBO_Users',$k,$v); }

    function table()
    {
         return array(
             'id' =>  DB_DATAOBJECT_INT + DB_DATAOBJECT_NOTNULL,
             'email' =>  DB_DATAOBJECT_STR + DB_DATAOBJECT_NOTNULL,
             'password' =>  DB_DATAOBJECT_STR + DB_DATAOBJECT_NOTNULL,
             'reg_date' =>  DB_DATAOBJECT_STR + DB_DATAOBJECT_DATE + DB_DATAOBJECT_TIME + DB_DATAOBJECT_NOTNULL,
             'last_date' =>  DB_DATAOBJECT_STR + DB_DATAOBJECT_DATE + DB_DATAOBJECT_TIME,
             'last_ip' =>  DB_DATAOBJECT_STR,
             'role_id' =>  DB_DATAOBJECT_STR + DB_DATAOBJECT_NOTNULL,
             'name' =>  DB_DATAOBJECT_STR,
             'lastname' =>  DB_DATAOBJECT_STR,
             'passport_series' =>  DB_DATAOBJECT_INT + DB_DATAOBJECT_NOTNULL,
             'passport_no' =>  DB_DATAOBJECT_INT + DB_DATAOBJECT_NOTNULL,
             'passport_date' =>  DB_DATAOBJECT_STR + DB_DATAOBJECT_DATE + DB_DATAOBJECT_NOTNULL,
             'passport_given' =>  DB_DATAOBJECT_STR + DB_DATAOBJECT_NOTNULL,
             'age' =>  DB_DATAOBJECT_STR,
             'country' =>  DB_DATAOBJECT_STR,
             'city' =>  DB_DATAOBJECT_STR,
             'street' =>  DB_DATAOBJECT_STR,
             'house_num' =>  DB_DATAOBJECT_STR,
             'post_code' =>  DB_DATAOBJECT_INT,
             'address' =>  DB_DATAOBJECT_STR,
             'home_phone' =>  DB_DATAOBJECT_STR,
             'work_phone' =>  DB_DATAOBJECT_STR,
             'mobile_phone' =>  DB_DATAOBJECT_STR,
             'company' =>  DB_DATAOBJECT_STR,
             'status_id' =>  DB_DATAOBJECT_INT,
             'reg_code' =>  DB_DATAOBJECT_STR,
             'balance' =>  DB_DATAOBJECT_INT,
             'note' =>  DB_DATAOBJECT_STR,
             'agree' =>  DB_DATAOBJECT_INT + DB_DATAOBJECT_NOTNULL,
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

    public $use_project_form_tmpl = true;

    public $form_template_name = 'form_query.tpl';


    /**
     * Заголовок для таблицы
     */
    public $center_title;

    /**
     * Заголовок формы (Добавить - Редактировать)
     */
    public $head_form;

    /**
     * Cтолбцы таблицы
     */
    public $listLabels   = array(
                     'name'     =>  'class="td-name"',
                     'email'    =>  '',
                     'phone'    =>  '',
                     'reg_date' =>  'class="td-date"',
                     'role_id'     =>  ''
    );

    /**
     * Название столбцов и элементов формы
     */
    public $fb_fieldLabels  = array();

    public $rules = array();

    /**
     * Сортировка таблицы по умолчанию
     */
    public $default_sort = 'reg_date';

    public $show_edit = true;

    public $act;

    public $qs_arr = array('role_id', 'status_id');

    public $fb_linkDisplayFields = array('name');


    public $sortLabels   = array(
                'name'              =>  'name',
                'reg_date'       =>  'reg_date',
                'email'    =>  'email',
    );

    public $fieldsToRender   = array(
                     'name',
                     'email',
                     'phone',
                     'last_ip',
                     'last_date',
                     'reg_date',
                     'note',
                     //'role_id'
    );


    public $user_roles = array();

    ////////////////////////////////////////////////////////////////////////// DEBUG
    public $perms_arr = array(
        'new' => array('iu' => 1, 'oc' => 1, 'mu' => 1),
        //'list' => array('iu' => 1, 'oc' => 1),
        //'edit' => array('iu' => 1, 'oc' => 1),
        //'delete' => array('iu' => 1, 'oc' => 1),
        //'card' => array('iu' => 1, 'oc' => 1),
    );
    ////////////////////////////////////////////////////////////////////////// DEBUG

    /**
     * Параметры вызовы процедуры set_user
     *
    puser_id
    pemail
    pphone
    pname
    prole_id
    pnote
     */
    public $set_params = array(
                            'puser_id',
                            'pemail',
                            'pphone',
                            'pname',
                            'prole_id', 
                            'pnote'
                        );
    
    public $list_params = null;

    //public $age_arr = array('11-15', '16-20', '21-25','26-30','31-40','41-50');

    public $age_arr = array(
        2 => '2-5',
        3 => '6-10',
        4 => '11-15',
        5 => '16-17',
        6 => '18-20',
        7 => '21-25',
        8 => '26-30',
        9 => '31-40', 
        10 => '41-50',
        11 => '51-60',
        12 => '61-70',
        13 => '70 +',
    );


    /**
     * Строка данных таблицы
     */
    function tableRow()
    {
            return array(
                 'name'     =>  '<a href="?op=users&act=card&id='.$this->id.'">'.$this->name.'</a>',
                 'email'    =>  $this->email,
                 'phone'    =>  $this->phone,
                 'reg_date' =>  $this->reg_date,
                 'role_id'     =>  $this->role_name,
            );
    }

    function preGenerateList()
    {
            $role_id = DVS::getVar('role_id', 'int');
            /*
            $this->whereAdd("users.role_id < 3");
            $roles_obj = DB_DataObject::factory('user_roles');
            if ($role_id) {
                $roles_obj->get($role_id);
                $this->center_title = $roles_obj->role_name;//.'ы';
            }
            $this->joinAdd($roles_obj);
            //$this->selectAdd();
            $this->selectAs();
            $this->selectAs(array('role_name'), '%s', 'user_roles');
            */
    }


    function userLetter()
    {
        require_once COMMON_LIB.'DVS/Mail.php';
        $data['to'] = $this->email;
        $data['subject'] = 'Villarenters registration';
        $data['body'] = DVS_Mail::letter($this->toArray(), 'reg_user.tpl');
        DVS_Mail::send($data);
    }

    function preDelete()
    {
        //print_r($_SESSION);
        if ($this->user_id == $_SESSION['_authsession']['data']['user_id']) {
            $this->msg = 'ERROR_CANT_DELETE_BY_MYSELF';
            //echo $this->msg;
            //exit;
            return false;
        } else {
            return true;
        }
    }

}
