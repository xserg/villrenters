<?php
/**
 *
 *
 * -----------------------------------------------------------
 * $Id: Layout_Redactor.php 70 2011-04-11 07:15:31Z xxserg@gmail.com $
 */

require_once PROJECT_ROOT.LAYOUT_FOLDER.'Layout.php';

class Project_Layout_Redactor extends Project_Layout
{
    var $iface_url = 'admin';

    var $login_title = '��������';

    /* ���� �������������� */
    var $menu = array(
        array('',                                   '�������������'),
        array('?op=advertisers&status_id=1',        '�����'),
        array('?op=advertisers',                    '���'),

        array('',                                   '���������'),
        array('?op=pages',                          '��������'),

        //array('?op=adm_units',          '��� �������'),

        array('',                                   '����������'),
        array('?op=campaigns',                      '��������'),
        array('?op=transactions',                   '������'),


/*
        array('?op=advertiser_status',  '������ ��������������'),
        array('?op=campaign_status',  '������ ��������'),
        array('?op=housing_type',       '���� �����'),
        array('?op=face_type',          '���� ��������������'),
*/

    );

    /* ������ ����������� ������ */
    var $op_arr = array('advertisers', 'campaigns', 'campaigns_statistics', 'content', 'pages', 'transactions');

    /* ������� �� ��������� */
    var $op_def = 'advertisers';

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
