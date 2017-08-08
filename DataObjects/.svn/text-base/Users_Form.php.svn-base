<?php

class DBO_Users_Form extends DBO_Users
{

    public $use_project_form_tmpl = true;

    public $form_template_name = 'form_query.tpl';

    private $date1;

    private $date2;

    private $people;

    private $childs;

    private $infants;

    private $villa_id;

    private $booking_id;

    function __construct()
    {
        if (!$_POST) {
            $method = 'get';
        } else {
            $method = 'post';
        }

        $this->date1 = DVS::getVar('date1', 'word', $method);
        $this->date2 = DVS::getVar('date2', 'word', $method);
        $this->people = DVS::getVar('people', 'word', $method);
        $this->childs = DVS::getVar('chd', 'int', $method);
        $this->infants = DVS::getVar('inf', 'int', $method);
        $this->villa_id = DVS::getVar('villa_id', 'int', $method);
        $this->booking_id = DVS::getVar('booking_id', 'int', $method);
    }

    function villaInfo()
    {
        $villa_obj = DB_DataObject::factory('villa');
        $villa_obj->get($this->villa_id);
        $this->center_title = "Бронирование объекта №$villa_id \"".($villa_obj->title_rus ? $villa_obj->title_rus : $villa_obj->title)."\"<br>".$this->date1." - ".$this->date2.", ".$this->people." взрослых".($this->childs ? ', детей '.$this->childs : '').($this->infants ? ', малышей '.$this->infants : '');
        $db = $villa_obj->getDatabaseConnection();
        $db->disconnect();

    }


    function guestForm($form, $people=1)
    {
        $form->addElement('static', null, '</div><div class="clear"></div></div>');
        $form->addElement('header', null, 'Информация о гостях');

        for ($i = 1; $i < $people; $i++) {
            $n = $form->createElement('text', 'name_'.$i, $this->fb_fieldLabels['name'].': ');
            $l = $form->createElement('text', 'lastname_'.$i, $this->fb_fieldLabels['lastname'].': ');
            $a = $form->createElement('select', 'age_'.$i, $this->fb_fieldLabels['age'].': ', $this->age_arr);
            $form->addGroup(array($n, $l, $a),'guest_'.$i, '', array('&nbsp;', '&nbsp;'), false);
            //$form->addElement('static', null, '<div class="clear"><hr></div>');
       
            $form->addGroupRule('guest_'.$i, array(
                'name_'.$i => array(
                    //array('Name is letters only', 'lettersonly'),
                    array(DVS_REQUIRED.' информация о гостях "'.$this->fb_fieldLabels['name'].'"!', 'required', null, 'client'),
                        ),
                'lastname_'.$i => array(
                    array(DVS_REQUIRED.' информация о гостях "'.$this->fb_fieldLabels['lastname'].'"!', 'required', null, 'client'),
                        ),
            )); 
            $form->addElement('static', null, '<br><hr>');
        }
    }

    /**
     * 1. Новый пользователь заходит в первый раз. email - 2 password
     * 2. Пользователь зарегистрирован, сессия активна email - freezee
     * 3. Пользователь зарегистрирован. сессия нет. нужна авторизация. email - password - button
       4. Пользователь авторизуется - см. 2
     */
    function emailForm($form)
    {
             //echo '<pre>';
             //print_r($_POST);
         if ($_POST['email']) {
            if (!$this->login()) {
                $this->msg = DVS_ERROR_LOGIN;
            }
         }
         if ($this->isRegistered()) {
             $this->act = 'edit';
            $registered = 1;
            //print_r($this->toArray());
            //$form->setDefaults($this->toArray());
            $form->setConstants($this->toArray());
            $username = $_SESSION['_authsession']['username'];
         }
        if (!$registered) {
            if ($_POST['email'] && $this->msg) {
                $form->addElement('static', null, '<span style="color: #FF0000;">Неправильный логин - пароль!</span>');
            }
            $form->addElement('radio', 'is_reg', 'У вас есть пароль?', 'Да', 'y', array('class'=>'radio', 'onclick' => 'javascript:submit()'));
            $form->addElement('radio', 'is_reg', '', 'Нет', 'n', array('class'=>'radio', 'onclick' => 'javascript:submit()'));
            $form->setDefaults(array('is_reg' => 'n'));
            $form->addElement('text', 'email', $this->fb_fieldLabels['email'].': ');
            $form->addElement('password', 'password1', $this->fb_fieldLabels['password'].': ');
            
            if ($_POST['is_reg'] == 'y') {
                $form->addElement('button', 'login', "Войти", array('id' => 'login', 'onclick' => 'javascript:submit()'));
            } else {
                $form->addElement('password', 'password2', $this->fb_fieldLabels['confirm_password'].': ', array('id' => 'password2'));
            }
        //$form->addElement('text', 'password', $this->fb_fieldLabels['password'].': ');
        } else {
            $form->addElement('text', 'email', $this->fb_fieldLabels['email'].': ');
            $form->addElement('static', null, '<a href="/office/?logout">Выход</a>');
            $form->setDefaults(array('email' => $username));
            $form->freeze('email');
        }
    }



    function userForm($form)
    {
        $this->center_title = $this->words['form_title'];

        if ($this->villa_id) {
            $this->villaInfo();
        }

        if ($_GET['date1']) {
            //$form->setDefaults($_GET);
        }

        $form->addElement('hidden', 'villa_id');
        $form->addElement('hidden', 'date1');
        $form->addElement('hidden', 'date2');
        $form->addElement('hidden', 'numdays');
        $form->addElement('hidden', 'people');
        $form->addElement('hidden', 'chd');
        $form->addElement('hidden', 'inf');
        $form->addElement('hidden', 'booking_id');

        $form->setDefaults(array(
            'villa_id' => $this->villa_id,
            'booking_id' => $this->booking_id,
            'date1' => $this->date1,
            'date2' => $this->date2,
            'numdays' => $this->numdays,
            'people' => $this->people,
            'chd' => $this->childs,
            'inf' => $this->infants,
        ));


        $form->addElement('header', null, 'Внимание!<br><br>Необходимо заполнять все поля формы латинским шрифтом!');

        $this->emailForm(&$form);
        $form->addElement('static', null, '</div><div class="clear"></div></div>');
        $form->addElement('header', null, 'Личная информация');

        $form->addElement('text', 'name', $this->fb_fieldLabels['name'].': ');
        $form->addElement('text', 'lastname', $this->fb_fieldLabels['lastname'].': ');
        $form->addElement('select', 'age', $this->fb_fieldLabels['age'].': ', $this->age_arr);

        $form->addElement('static', null, '</div><div class="clear"></div></div>');
        $form->addElement('header', null, $this->words['form_title2']);

        $form->addElement('text', 'country', $this->fb_fieldLabels['country'].': ');
        $form->addElement('text', 'city', $this->fb_fieldLabels['city'].': ');
        $form->addElement('text', 'street', $this->fb_fieldLabels['street'].': ');
        $form->addElement('text', 'house_num', $this->fb_fieldLabels['house_num'].': ');

        //$form->addElement('text', 'address', $this->fb_fieldLabels['address'].': ');

        $form->addElement('text', 'home_phone', $this->fb_fieldLabels['home_phone'].': Пример:(+7903 123-4455)');
        //$form->addElement('text', 'work_phone', $this->fb_fieldLabels['work_phone'].': ');
        $form->addElement('text', 'mobile_phone', $this->fb_fieldLabels['mobile_phone'].': ');
        
        /*
        if ($this->act == 'new') {
        if (!$this->agree) {
        $form->addElement('checkbox', 'agree', '', $this->words['agree'],  'class=radio');
        }
        
        $form->addElement('static', null, null, ' <a href="/office/?op=users&act=agree" target="_blank">'.$this->words['agreement'].'</a><br class="clear">');
        $form->addRule('agree', $this->words['disagree'], 'required', null, 'client');

        
        }
        */
        $form->addElement('static', null, '</div><div class="clear"></div></div>');

        $form->addElement('header', null, $this->fb_fieldLabels['note'].': ');
        $form->addElement('textarea', 'note', $this->fb_fieldLabels['note'].': ');

        $this->guestForm($form, $this->people + $this->childs + $this->infants);


        $form->addElement('submit', '__submit__', DVS_SAVE);
        $form->addElement('static', null, '</div></div>');

        //$form->freeze('email');
        $form->addRule('name', DVS_REQUIRED.' "'.$this->fb_fieldLabels['name'].'"!', 'required', null, 'client');
        $form->addRule('name', 'Используйте латинский шрифт "'.$this->fb_fieldLabels['name'].'"!', 'lettersonly', null, 'client');
        //$form->addRule('phone', $this->rules['phone'][0], 'regex', $pattern, 'client');
        $form->addRule('lastname', DVS_REQUIRED.' "'.$this->fb_fieldLabels['lastname'].'"!', 'required', null, 'client');
        $form->addRule('lastname', 'Используйте латинский шрифт "'.$this->fb_fieldLabels['lastname'].'"!', 'lettersonly', null, 'client');

        $form->addRule('country', DVS_REQUIRED.' "'.$this->fb_fieldLabels['country'].'"!', 'required', null, 'client');
        $form->addRule('city', DVS_REQUIRED.' "'.$this->fb_fieldLabels['city'].'"!', 'required', null, 'client');
        $form->addRule('street', DVS_REQUIRED.' "'.$this->fb_fieldLabels['street'].'"!', 'required', null, 'client');
        $form->addRule('house_num', DVS_REQUIRED.' "'.$this->fb_fieldLabels['house_num'].'"!', 'required', null, 'client');

        $form->addRule('home_phone', DVS_REQUIRED.' "'.$this->fb_fieldLabels['home_phone'].'"!', 'required', null, 'client');

        $form->addRule('home_phone', $this->words['error_format'].' '.$this->fb_fieldLabels['home_phone'].'!', 'regex', '/^[0-9-+ \(\)]{7,20}$/', 'client');


        $form->addRule('email', DVS_REQUIRED.' "'.$this->fb_fieldLabels['email'].'"!', 'required', null, 'client');
        $form->addRule('email', $this->rules['email'][0].' '.$this->fb_fieldLabels['email'].'"!', 'email', null, 'client');

        $form->addRule('password1', DVS_REQUIRED.' "'.$this->fb_fieldLabels['password'].'"!', 'required', null, 'client');
        $form->addRule('password2', DVS_REQUIRED.' "'.$this->fb_fieldLabels['confirm_password'].'"!', 'required', null, 'client');
        $form->addRule('password1', $this->rules['password'][0], 'minlength', 5, 'client');
        $form->addRule(array('password1', 'password2'), $this->rules['password'][1], 'compare', null, 'client');
        //$form->addRule('email', $this->rules['email'][0].' '.$this->fb_fieldLabels['email'].'"!', 'email', null, 'client');
        $pattern = "/^[+]?[0-9] ?[(]?[0-9]{3,3}[)] *[0-9]{3,3}[-]?[0-9]{2,2}[-]?[0-9]{2,2}$/";
        //$pattern = '/[0-9 \-]+/';
        //$form->addRule('phone', $this->rules['phone'][0], 'regex', $pattern, 'client');

        $form->applyFilter('email', 'strtolower');
        if ($this->act == 'new') {
            $form->setDefaults(array('country' => 'Russia'));
            $form->registerRule('checkEmail', 'callback', 'checkEmail', 'DBO_Users_Form');
            $form->addRule('email', $this->rules['email'][1], 'checkEmail');
        }
    }

    function checkEmail($email)
    {
        $users_obj = DB_DataObject::factory('users');
        $users_obj->email = strtolower($email);
        if ($users_obj->count()) {
            return false;
        }
        return true;
    }

    //Вывод формы
    function getForm()
    {
        $form =& new HTML_QuickForm('', '', $_SERVER['REQUEST_URI'], '');
        //$form->addElement('header', null, ($this->act == 'new' ? DVS_NEW : DVS_EDIT).' '.$this->head_form);
        if ($this->act == 'new') {
            //$this->regForm($form);
            $this->userForm($form);
        } else {
            $this->userForm($form);
        }
        //$form->addElement('submit', '__submit__', DVS_SAVE);
                $form->addElement('static', null, '</div></div>');

        return $form;
    }

    function preProcessForm(&$vals, &$fb)
    {
        $vals['childs'] = $this->childs;
        $vals['infants'] = $this->infants;


        //print_r($_POST);
        if ($this->act == 'new') {
            $this->userEditableFields = array(
                    'email',
                    'password',
                    'name',
                    'phone',
                    'reg_date',
                    'role_id',
                    //'last_date',
                    'last_ip',
                    'note'
            );
            $fb->dateToDatabaseCallback = null;
            $vals['email']          = strtolower($vals['email']);
            $vals['reg_date']       = date(DB_DATE_FORMAT);
            $vals['reg_code']      = md5(uniqid(""));
            $vals['status_id']      = 1;
            //$vals['password']       = $this->getPasswordRandom();
            $vals['role_id']     = 'ou';
            $vals['password']       = $vals['password1'];
            require_once COMMON_LIB.'DVS/Auth.php';
            $vals['last_ip']   = DVS_Auth::getIP();
            //$this->qs = '/';
            $this->msg = DVS_REG_EMAIL;
        } else {
            $this->userEditableFields = array(
                    'email',
                    //'password',
                    'name',
                    'phone',
                    'role_id',
                    'note'
            );
            
        }
        $this->qs = '/pages/newbook';
    }

    function login()
    {
        if (!$_SESSION) {
            session_start();
        }
        $_POST['username'] = $_POST['email'];
        $_POST['password'] = $_POST['password1'];
        require_once COMMON_LIB.'DVS/Auth.php';
        $this->auth_obj = DVS_Auth::factory('a');
        return $this->auth_obj->authpw();
    }


    function postProcessForm(&$vals, &$fb)
    {
        //print_r($vals);
        $booking_log_id = $this->bookingLog($vals['booking_id'], $vals['villa_id'], $this->id, str_replace("/", "-", $vals['date1']), str_replace("/", "-", $vals['date2']), $vals['people'], $vals['childs'], $vals['infants']);
        if ($booking_log_id) {
            $this->saveGuests(&$vals, $booking_log_id);
        }
        $this->login();
        $this->adminLetter($vals['villa_id'], $this->id, str_replace("/", "-", $vals['date1']), str_replace("/", "-", $vals['date2']), $vals['people']);
        //print_r($_POST);
        if ($this->act == 'new') {
            $this->userLetter();
        }
    }

    function bookingLog($booking_id, $villa_id, $user_id, $start, $end, $people, $chd=0, $inf=0)
    {
        require_once ('DVS/Auth.php');
        $booking_log_obj = DB_DataObject::factory('booking_log');
        //DB_DataObject::DebugLevel(1);
        $booking_log_obj->get($booking_id);
        if ($villa_id != $booking_log_obj->villa_id) {
            return false;
        }
        $booking_log_obj->villa_id = $villa_id;
        $booking_log_obj->user_id = $user_id;
        $booking_log_obj->start_date = $start;
        $booking_log_obj->end_date = $end;
        $booking_log_obj->people = $people;
        $booking_log_obj->childs = $chd;
        $booking_log_obj->infants = $inf;
        $booking_log_obj->post_date = date("Y-m-d H:i:s");
        $booking_log_obj->ip = DVS_Auth::getIP();
        $booking_log_obj->update();
        return $booking_log_obj->id; 
        //return $booking_log_obj->insert();
    }

    function isRegistered()
    {
        session_start();
        //print_r($_SESSION);
        //if ($_SESSION['_authsession']['registered'] && $_SESSION['_authsession']['username'] && $this->iface == 'i') {
        if ($_SESSION['_authsession']['registered']) {
            $this->get($_SESSION['_authsession']['data']['id']);
            if ($this->id) {
                return true;
            }
        }
    }

    function userLetter()
    {
        require_once COMMON_LIB.'DVS/Mail.php';
        $data['to'] = $this->email;
        $data['cc'] = MAIL_ADMIN;
        $data['bcc'] = MAIL_ADMIN;
        $data['subject'] = 'ruRenter.ru registration';
        $activate_link = "http://rurenter.ru/activate/?code=".$this->reg_code;
        $data['body'] = DVS_Mail::letter(array('activate_link' => $activate_link) + $this->toArray(), 'reg_user.tpl');
        DVS_Mail::send($data);
    }

    function adminLetter($villa_id, $user_id, $start, $end, $people)
    {
        $villa_obj = DB_DataObject::factory('villa');
        $villa_obj->get($villa_id);

        require_once COMMON_LIB.'DVS/Mail.php';
        $data['to'] = $users_obj->email;
        $data['subject'] = 'villarenters.ru booking';
        //$booking_link = SERVER_URL."/office/?op=booking&act=showcard&id=".$this->id;
        $booking_link = "http://rurenter.ru/admin/?op=booking_log";
        $data_arr = array(
            'booking_link' => $booking_link,
            'villa_id' => $villa_id,
            'villa_name' => $villa_obj->title,
            'user_id' => $this->id,
            'name' => $this->name,
            'lastname' => $this->lastname,
            'age' => $this->age,
            'start_date' => $start,
            'end_date' => $end,
            'people' => $people,

            'country' => $this->country,
            'city' => $this->city,
            'street' => $this->street,
            'house_num' => $this->house_num,
            'email'  => $this->email,
            'home_phone'  => $this->home_phone,
            'mobile_phone'  => $this->mobile_phone,
            );


        $data['body'] = DVS_Mail::letter($data_arr, 'booking_letter.tpl');
        if ($this->email) {
            //DVS_Mail::send($data);
        }

        $data['to'] = 'info@villarenters.ru, irina@villarenters.ru';
        //$data['subject'] = 'ruRenter.ru booking '.$this->id;
        if ($this->note) {
            $data_arr['note'] = 'Примечания: '.$this->note."\n";
        }
        $data['body'] = DVS_Mail::letter($data_arr, 'booking_letter.tpl');
        DVS_Mail::send($data);

        return;

        $data['to'] = $_SESSION['_authsession']['username'];
        $data_arr['booking_link'] = SERVER_URL."/office/?op=booking&act=showcard&id=".$this->id;
        $data['body'] = DVS_Mail::letter($data_arr, 'renter_booking_letter.tpl');
        DVS_Mail::send($data);
        
    }

    function saveGuests(&$vals, $booking_log_id)
    {
        $cnt = $vals['people'] + $vals['childs'] + $vals['infants'];
        if ($booking_log_id) {
            $guests_obj = DB_DataObject::factory('guests');
            for ($i = 1; $i < $cnt; $i++) {
                $guests_obj->booking_log_id = $booking_log_id;
                $guests_obj->guest_name = $vals['name_'.$i];
                $guests_obj->guest_lastname = $vals['lastname_'.$i];
                $guests_obj->age = $vals['age_'.$i];
                $guests_obj->insert();
            }
        }
    }
}