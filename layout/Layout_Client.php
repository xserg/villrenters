<?php
/**
 *
 *
 * -----------------------------------------------------------
 * $Id: Layout_Client.php 70 2011-04-11 07:15:31Z xxserg@gmail.com $
 */

require_once PROJECT_ROOT.LAYOUT_FOLDER.'Layout.php';

class Project_Layout_Client extends Project_Layout
{
    public $iface_url = 'admin';

    public $login_title = '�������������';

    public $perms_fieldname = 'advertiser_id';

    /* ���� �������������� */
    var $menu = array(

        //array('',                                   '����������'),
        array('?op=campaigns',                                  '��������� ��������'),
        array('?op=advertisers&act=show',                       '���������'),
        array('?op=transactions',                               '������ ����'),
        array('?op=pay_services&act=select',                    '��������� ����'),


/*
        array('?op=advertiser_status',  '������ ��������������'),
        array('?op=campaign_status',  '������ ��������'),
        array('?op=housing_type',       '���� �����'),
        array('?op=face_type',          '���� ��������������'),
*/

    );

    /* ������ ����������� ������ */
    var $op_arr = array('advertisers',
                        'campaigns',
                        'campaigns_statistics',
                        'content',
                        'info_change',
                        'pages',
                        'pay_services',
                        'transactions',
                        'users'
    );

    /* ������� �� ��������� */
    var $op_def = 'campaigns';

    var $page_title = '�������������';

    function getPageData($tpl = null)
    {
        $page_arr['PAGE_TITLE']       = $this->page_title.' '.$this->project_title;
        //$page_arr['LOGIN_FORM'] = $this->page_title.' '.$_SESSION['_authsession']['username'];
        $this->loginInfo($tpl);
        $this->getMenu($tpl);
        //$this->getMenuAdmin($tpl);
        //$this->setSearch($tpl);
        $tpl->setVariable($page_arr);
        return;
    }

    function setSearch($tpl)
    {
        if ($_GET['find']) {
            $find = $_GET['find'];
        } else {
            $find = '';
        }
        $tpl->addBlockFile('NAVIGATION', 'SEARCH', 'search.tpl');
        //$tpl->addBlockfile('SEARCH_FORM', 'SEARCH_FORM', 'search.tpl');
        $tpl->setVariable(array(
            'ACTION' => '',
            'FIND' => $find,
            'SEARCH_IMG' => 'search.png',
            'search_op' => $_GET['op'],
        ));
        $tpl->parse('SEARCH');
    }

}
?>
