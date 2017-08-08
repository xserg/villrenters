<?php
/*////////////////////////////////////////////////////////////////////////////

------------------------------------------------------------------------------

------------------------------------------------------------------------------
$Id: Layout_Loginuser.php 193 2012-09-24 13:26:36Z xxserg@gmail.com $
////////////////////////////////////////////////////////////////////////////
*/

require_once PROJECT_ROOT.LAYOUT_FOLDER.'Layout.php';

class Project_Layout_Loginuser extends Project_Layout
{
    var $iface_url = 'office';

    var $login_title = 'Привет!';

    /* Меню пользователя */
    var $menu = array(
            array('?op=users&act=edit',             'Профиль', 'n-reg'),
            array('/office/',                       'Видео', 'n-vid'),
            array('/office/?op=v_video&act=new',    'Загрузить', 'n-upl'),
            array('/office/?op=messages&act=inbox',           'Сообщения', 'n-tag'),
            array('/office/?op=friends',            'Друзья', 'n-tag'),
            //array('/tags/',                         'Таги', 'n-tag'),
            array('/doc/help',                      'Помощь', 'n-hel')
    );

    /* Массив разрешенных таблиц */
    var $op_arr = array('booking_log');

    /* Таблица по умолчанию */
    public $op_def = 'booking_log';

    public $perms_fieldname = 'user_id';

    function getPageData($tpl = null)
    {

        require_once COMMON_LIB.'DVS/Dynamic.php';

        $page_arr['PAGE_TITLE']     = $this->project_title;
        $page_arr['KEYWORDS']       = $this->keywords;
        $page_arr['DESCRIPTION']    = $this->description;
        //$page_arr['PAGECLASS'] = ' class="inside"';
        $this->loginInfo($tpl);
        $this->getMenu($tpl);
        $user_obj = DVS_Dynamic::createDbObj('users');
        $user_obj->get($_SESSION['_authsession']['data']['id']);
        $tpl->addBlockfile('CATEGORY', 'CATEGORY', 'user.tpl');
        $user_obj->userInfo($tpl, 'Мой аккаунт');
            $tpl->setVariable(array('friend_id' => $user_obj->id));
            $tpl->parse('FRIEND_LENT');
        $tpl->parse('CATEGORY');

        $pages_obj = DB_DataObject::factory('pages');
        $pages_obj->getNewsBlock($tpl, 6);

        //$tpl->touchBlock('CATEGORY');
        //print_r($tpl);
        /*
        $this->setSearch($tpl);
        //$cat_obj = DB_DataObject::factory('v_cats');
        $cat_obj = DVS_Dynamic::createDbObj('v_cats');
        $cat_obj->catBlock($tpl);
        if ($cat_obj->cur_name) {
            $page_arr['CENTER_TITLE'] = $cat_obj->cur_name;
        }
        //$tag_obj = DB_DataObject::factory('v_tags');
        //$tag_obj->tagBlock($tpl, 100, 'TAGS');
        */
        $tpl->setVariable($page_arr);
        
        return;
    }

}
?>
