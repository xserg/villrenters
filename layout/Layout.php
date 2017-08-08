<?php
/**
 * @package villarenters.ru
 * ------------------------------------------------------------------------------
 * Класс инициилизирует свойства пректа, общие для всех интерфейсов
 * ------------------------------------------------------------------------------
 * $Id: Layout.php 70 2011-04-11 07:15:31Z xxserg@gmail.com $
 */

class Project_Layout
{
    public $op;

    public $act;

    public $project_name = 'villarenters.ru';

    /* Заголовок страницы проекта */
    public $project_title = 'villarenters.ru';

    public $registered = false;

    public $username;

    public $active_menu;

    public $language;

    private $menu_text;

    /**
     * @param $role string
     * @return Layout Object
     */
    function factory($role = 'iu')
    {
        global $_DVS;
        $project_layout_filename = 'Layout_'.ucfirst($_DVS['CONFIG']['INAMES'][$role]);
        $project_layout_classname = DVS_PROJECT_CLASS_PREFIX.$project_layout_filename;
        DVS::loadClass($project_layout_classname, PROJECT_ROOT.LAYOUT_FOLDER.$project_layout_filename.'.php');
        $project_layout_obj = new $project_layout_classname;
        return $project_layout_obj;
    }

    function __construct()
    {
        $this->language = LANG;
        $lang_file = PROJECT_ROOT.LAYOUT_FOLDER.'Lang_'.$this->language.'.php';
        if (!file_exists($lang_file)) {
            $lang_file = PROJECT_ROOT.LAYOUT_FOLDER.'Lang_ru.php';
        }
        require_once $lang_file;
        $GLOBALS['_DVS']['LANG'] = $lang;
        foreach ($GLOBALS['_DVS']['LANG']['constant'] as $ck => $cv) {
            define(strtoupper($ck), $cv);
        }
        foreach ($GLOBALS['_DVS']['LANG']['layout'][$this->iface] as $ik => $iv) {
            $this->$ik = $iv;
        }
        if ($username = $this->getUsername()) {
            $this->username = $username;
            $this->registered = true;
        }
    }


    function getTopMenu($tpl)
    {
        $op = DVS::getVar('op');
        $tpl->addBlockfile('TOP', 'TOP', 'menu_top.tpl');
        $i = 0;
        foreach ($this->menu_text as $href => $text) {
            $i++;
                $tpl->setVariable(array(
                    'MENU_HREF' => $href,
                    'MENU_TEXT' => $text
                    //'LICLASS' => ' class=c'
                    )
                );
                if (preg_match("/^http/", $href)) {
                $tpl->setVariable(array(
                    'noindex1' => '<noindex>',
                    'noindex2' => '</noindex>',
                    'nofollow' => ' rel="nofollow"'
                    )
                );
                }
                $tpl->parse('MENU_ITEM');
        }
    }

    function getMenu($tpl)
    {
        //print_r($_COOKIE);
        //print_r($_SESSION);
        //print_r($GLOBALS);
        $op = DVS::getVar('op');
        $tpl->addBlockfile('LEFT', 'LEFT', 'menu.tpl');
        $i = 0;
        foreach ($this->menu_text as $href => $text) {
            //$text = $GLOBALS['_DVS']['LANG']['layout'][$this->iface]['menu'][$i];
            //$text = $this->menu_text[$i];
            $i++;
            //if (empty($arr[0])) {
            if (preg_match("/^zag/", $href)) {
                $tpl->parse('MENU_SECTION');
                $tpl->setVariable(array('MENU_SECTION_NAME' => $text, 'LICLASS' => ' class=o'));
            } else {
                if (isset($this->menu_counters) && in_array($i, array_keys($this->menu_counters))) {
                    $text .= ' ('.$this->menu_counters[$i].')';
                }
                $tpl->setVariable(array(
                    'MENU_HREF' => $href,
                    'MENU_TEXT' => $text
                    //'MENU_TEXT' => $arr[1],
                    //'LICLASS' => ' class=c'
                    )
                );
                $tpl->parse('MENU_ITEM');
            }
        }
    }


    function loginInfo($tpl)
    {
        $tpl->addBlockfile('LOGIN_FORM', 'LOGIN_FORM', 'login_info.tpl');
        //$tpl->touchBlock('LOGIN_FORM');
        $page_arr['HELLO'] = $this->login_title;
        $page_arr['USERNAME'] = $this->username;
        //$page_arr['IFACE'] = '/'.$this->iface_url.'/';
        $tpl->setVariable($page_arr);
    }

    function loginData()
    {
        //echo basename  ( $_SERVER["SCRIPT_FILENAME"]);
        $page_arr['USERNAME']  = $_POST['username'] ? $_POST['username'] : ($_COOKIE['username'] ? $_COOKIE['username'] : '');
        $page_arr['PASSWORD']  = $_COOKIE['password'] ? $_COOKIE['password'] : ($_POST['password'] ? '' : '');
        
        //$page_arr['PASSWORD_TYPE'] = $_COOKIE['password'] ? 'password' : 'text';
        $page_arr['CHECKED']   = $_COOKIE['password'] ? ' CHECKED' : '';
        //print_r($page_arr);
        return $page_arr;

    }

    function getUsername()
    {
        if ($_COOKIE['PHPSESSID'] || $_SESSION['_authsession']) {
            if ($_SESSION['_authsession']['registered'] && $_SESSION['_authsession']['username']) {
                return $_SESSION['_authsession']['username'];
            }
            return false;
        }
    }
}
?>
