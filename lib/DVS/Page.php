<?php
/*////////////////////////////////////////////////////////////////////////////
lib/DVS
------------------------------------------------------------------------------
����� ���������� ��� ��������
����� ��������� ������� ��������
------------------------------------------------------------------------------
$Id: Page.php 299 2013-10-16 14:12:20Z xxserg@gmail.com $
////////////////////////////////////////////////////////////////////////////*/

/**
 * @package DVS
 * @version 2.1
 * @author      Serg Fomin <xxserg@gmail.com>
 *
 */

//require_once (COMMON_LIB.'DVS/Constants.php');
define('DVS_PAGE_ERROR_INVALIDCONFIG', -100);
define('DVS_PAGE_ERROR_INVALIDLAYOUT', -101);


$GLOBALS['_DVS']['CONFIG']['INAMES'] = array(
    'iu' => 'user',
    'ou' => 'loginuser',
    'oc' => 'client',
    'aa' => 'admin',
    'ar' => 'redactor',
    'mu' => 'mobile',
);

$GLOBALS['_DVS']['CONFIG']['IFACES'] = array(
    'i' => 'index',
    'o' => 'office',
    'a' => 'admin',
);

$GLOBALS['_DVS']['CONFIG']['DVS_DEFAULT_CLASSES'] = array(
    'new'      => 'ShowForm',
    'edit'     => 'ShowForm',
    'copy'     => 'ShowForm',
    'delete'   => 'Delete',
    'list'     => 'ShowList',
    'card'     => 'ShowCard',
    'mail'     => 'ShowMail',
    'up'       => 'Order',
    'down'     => 'Order',
    'help'     => 'Help',
    //'search'   => 'ShowSearch',
    'carduser' => 'ShowCardUser',
    'cache'    => 'CacheControl',
    'download' => 'ShowCSV',
);

//$GLOBALS['_DVS']['ERROR'] = false;


class DVS_Page
{
    /*
    ������� �� ������� ��������� ������������� ������������ ��������, ������� �� $_GET['op']
    ���� op === static, ������� ����������� ��������
    */
    public $op;

    /*
    �������� ����������� ������. ������� �� $_GET['act']
    ���� op === static, ������� ����
    */
    public $act;


    /* ������ ������ �������� */
    public $page_arr;

    /* ������ ������� HTML_TemplateSigma */
    public $template_obj;

    /* ������������ ���������
       ��������� ��������:
        a => admin.php   - �������������
        o => office.php  - ������������������ ������������
        i => index.php   - ������������
    */
    public $iface;

    /* ���� ������������
        'iu' => 'user',
        'ou' => 'loginuser',
        'oc' => 'client',
        'aa' => 'admin',
        'ar' => 'redactor',
    */
    public $role;

    /* ���� ������� �������� */
    public $default_template_name = 'villa_index.tpl';

    /* ������ ������������ (�� ���������� ����� �� ����������, �������������� ��������)*/
    public $error = false;

    /* �� ���������� �������� */
    public $nocache = false;

    /* ����� � �������, ������� ���� ������ */
    public $hide_blocks;

    /*
    ���������� � ����������� �� ���������� $classname
    ���������� ������ & new $classname
    */
    function factory($op, $act, $iface)
    {
        global $_DVS;
        require_once 'PEAR.php';
        //��������� ������
        PEAR::setErrorHandling(PEAR_ERROR_CALLBACK, array('DVS_Page', "showError"));
        $op = preg_replace("/\.\./", "", $op);
        $act = preg_replace("/\.\./", "", $act);

        $prefix = DVS_CLASS_PREFIX;
        //������������� $role
        $role = DVS_Page::_getRole($iface);

        require_once PROJECT_ROOT.'layout/Layout.php';
        $layout_obj = Project_Layout::factory($role);
        if (!$op) {
            $op = $layout_obj->op_def;
        }
        if (!$act) {
            if (isset($layout_obj->act_def[$op]) && $layout_obj->act_def[$op] != '') {
                $act = $layout_obj->act_def[$op];
            } else {
                $act = 'list';
            }
        }
        $layout_obj->op = $op;
        $layout_obj->act = $act;
        if ($op == 'static') {
            $filename = 'Static';
            $fullpath = COMMON_LIB.'DVS/'.$filename.'.php';
        } else if (in_array($act, array_keys($_DVS['CONFIG']['DVS_DEFAULT_CLASSES']))){
            $filename = $_DVS['CONFIG']['DVS_DEFAULT_CLASSES'][$act];
            $fullpath = COMMON_LIB.'DVS/'.$filename.'.php';
        } else {
            $prefix   = DVS_PROJECT_CLASS_PREFIX;
            $filename = ucfirst($op).'_'.ucfirst($act);
            $fullpath = PROJECT_ROOT.'dynamic/'.$filename.'.php';
        }

        if (file_exists($fullpath)) {
            include_once $fullpath;
        }

        $classname = $prefix.$filename;
        if (!class_exists($classname)) {
            //PEAR::setErrorHandling(PEAR_ERROR_DIE);
            return PEAR::raiseError('Unable to include the '.$classname.'.php file', DVS_PAGE_ERROR_INVALIDCONFIG);
        } else {
            $page_obj =  new $classname;
            //print_r($page_obj);
            /* ������������� ������� $page_obj */
            if ($layout_obj) {
                $page_obj->layout_obj = $layout_obj;
            }
            /* ������������� ��������� */
            if (isset($_SESSION['message'])) {
                $page_obj->msg = $_SESSION['message'];
                unset($_SESSION['message']);
            }
            $page_obj->op    = $op;
            $page_obj->act   = $act;
            $page_obj->iface = $iface;
            $page_obj->role  = $role;
            //$page_obj->qs    = '?op='.$op;
            return $page_obj;
        }
    }

    /* �������� role */
    function _getRole($iface)
    {

        $role = $_SESSION['_authsession']['data']['role_id'] ? $_SESSION['_authsession']['data']['role_id'] : 'iu';
        if(preg_match('/^m/', $_SERVER['HTTP_HOST'])) {
            $role = 'mu';
        }
        return $role;
        switch ($_SESSION['_authsession']['data']['role_id']) {
            case 1:
                $role = 'aa';
                break;
            case 2:
                $role = 'ar';
                break;
            case 3:
                $role = 'oc';
                break;
            default:
                $role = 'iu';
                break;
        }
        return $role;
    }

    function createTemplateObj()
    {
        if (!$this->template_obj) {
            if ($this->iface == 'a' && !file_exists(PROJECT_ROOT.CACHE_FOLDER.'tmpl')) {
                mkdir(PROJECT_ROOT.CACHE_FOLDER.'tmpl');
                chmod(PROJECT_ROOT.CACHE_FOLDER.'tmpl', 0775);
            }
            require_once 'HTML/Template/Sigma.php';
            $this->template_obj = new HTML_Template_Sigma(PROJECT_ROOT.TMPL_FOLDER, PROJECT_ROOT.CACHE_FOLDER.'tmpl');
        }
    }

    function loadTemplate()
    {
        if (!isset($this->template_name)) {
            if (isset($this->layout_obj->template_name)) {
                $this->template_name = $this->layout_obj->template_name;
            } else {
                $this->template_name = $this->default_template_name;
            }
        }
        $this->template_obj->loadTemplateFile($this->template_name, 1, 1);
    }

    function parsePage()
    {
        $this->template_obj->setVariable($this->page_arr);
        
        if ($this->hide_blocks) {
            if (is_array($this->hide_blocks)) {
                foreach ($this->hide_blocks as $block) {
                    $this->template_obj->hideBlock($block);
                    $hide_ride = ($block == 'RIGHT') || $hide_ride;
                }
            } else {
                $this->template_obj->hideBlock($this->hide_blocks);
                $hide_ride = $this->hide_blocks == 'RIGHT';
            }
        }
        
        if (isset($this->src_files)) {
            $this->parseBlock($this->src_files);
        }
        return $this->template_obj->get();
    }

    /**
     * ������� ������ - �������� � �����
     * @param array $data = array(
     *                          'JS_SRC'  => array(file1, file2...),
     *                          'CSS_SRC' => array(file1, file2...),
     *                           ....
     *                       );
     */
    public function parseBlock($data = array())
    {
        //DVS::dump($data);
        //foreach ($data as $data_arr) {
            foreach ($data as $block_name => $block_val) {
                foreach ($block_val as $val) {
                    $this->template_obj->setVariable(array($block_name => $val,
                        'NL' => "\n"
                    ));
                    $this->template_obj->parse($block_name);
                }
            }
        //}
    }

    //��������� ������ PEAR
    function showError($err)
    {
        //exit;
        //return;
        //echo '<pre>'; print_r($err);
        //echo $err->userinfo;
        //$fatal         = 1;
        $err_code      = $err->getCode();
        $error_message = 'error_service';
        $error_debug   = 'error';
        //echo $err_code;
        if (is_a($err, 'PEAR_Error') && $err_code) {
            switch ($err_code) {
                case DVS_PAGE_ERROR_INVALIDCONFIG:
                    $fatal         = 1;
                    $error_message = 'error_404';
                    $error_debug   = 'DVS_ERROR_DYNAMIC_NOT_EXIST';
                    break;
                case DVS_PAGE_ERROR_INVALIDLAYOUT:
                    $fatal         = 1;
                    $error_message = 'error_404';
                    $error_debug   = 'DVS_ERROR_LAYOUT_NOT_EXIST';
                    break;
            }
        }

        if ($fatal) {
            //echo $err->getMessage().'<br>'.$err->getDebugInfo();
            exit;
            require_once COMMON_LIB.'DVS/ShowError.php';
            $page_obj           = new DVS_ShowError();
            $page_obj->iface    = DVS_Page::_getIface();
            $page_obj->role     = DVS_Page::_getRole($page_obj->iface);
            $page_obj->err_code = $err_code;
            if ($_SERVER['REMOTE_ADDR'] == OFFICE_IP || SERVER_TYPE ==  'local') {
                $page_obj->msg         = $error_debug;
                $page_obj->error_debug = $err->getMessage().'<br>'.$err->getDebugInfo();
            } else {
                $page_obj->msg         = $error_message;
                echo $page_obj->showPage();
                exit;
            }

        }
    }

    function show404()
    {
        header("HTTP/1.0 404 Not Found");
        $this->msg = 'error_404';
        $this->error = true;
    }

        /* ����� ��������� � ������ �������� �������� page_arr */
    function showMessage($message_code)
    {
        /* ����� */
        $message = 'DVS_'.strtoupper($message_code);

        /* ���� */
        if ($message == 'DVS_ERROR_404') { /* ������ */
            $color = '#000000';
            $type = '';
        } else {
            if (strstr($message, 'ERROR')) { /* ������� */
                $color = '#FF0000';
                $type  = 'error';
            } else { /* ������� */
                $color = '#339900';
                $type  = 'info';
            }
        }
        //��������� ��� �������� DVS_
        if (!defined($message)) {
            $message = strtoupper($message_code);
        }
        $this->page_arr['MESSAGE_TEXT']  = defined($message) ? constant($message) : $message;
        $this->page_arr['MESSAGE_TYPE']  = $type;
        $this->page_arr['MESSAGE_COLOR'] = $color;
        if (isset($_SESSION['message'])) {
            unset($_SESSION['message']);
        }
    }

    // ���������� ��� ������ �� ��������
    function htmlChars($str)
    {
        $output = array(
            '"' => '&quot;',
            '<' => '&lt;',
            '>' => '&gt;',
            "'" => '&quot;',
            '�' => '&quot;',
            '�' => '&quot;',
            '�' => '&curren;',
            '�' => '&copy;',
            '�' => '&not;',
            '�' => '&shy;',
            '�' => '&reg;',
            '�' => '&deg;',
            '�' => '&plusmn;',
            '�' => '&para;',
            '�' => '&sup1;',
            //'&#' => '&amp;#',
        );
        return strtr($str, $output);
    }

    /* ����������� ���� ������� 0000-00-00 � ������ */
    function rusDate($date, $format = 'd.m.Y')
    {
        return date($format, strtotime($date));
    }

    /* �������� iface */
    function _getIface()
    {
        $iface = $_SERVER['PHP_SELF'][1];
        if (!$GLOBALS['_DVS']['CONFIG']['IFACES'][$iface]) {
            $iface = 'i';
        }
        return $iface;
    }

}
?>
