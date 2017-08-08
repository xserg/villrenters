<?php
/*////////////////////////////////////////////////////////////////////////////
lib2/DVS
------------------------------------------------------------------------------
����� ���������� ��� �������� AUTO.RU
����� �������� �������� ������� � ���������� office.php
------------------------------------------------------------------------------
$Id: Layout_User.php 70 2011-04-11 07:15:31Z xxserg@gmail.com $
////////////////////////////////////////////////////////////////////////////*/

require_once COMMON_LIB.'DVS/Reclama.php';

class DVS_Layout_User extends DVS_Layout
{
    /* ������ ������� */
    var $reclama_obj;

    function createReclamaObj()
    {
        $filename = 'Reclama';
        if (file_exists(PROJECT_ROOT.LAYOUT_FOLDER.$filename.'.php')) {
            require_once PROJECT_ROOT.LAYOUT_FOLDER.$filename.'.php';
            $classname = DVS_PROJECT_CLASS_PREFIX.$filename;
        } else {
            require_once COMMON_LIB.'DVS/Reclama.php';
            $classname = DVS_CLASS_PREFIX.$filename;
        }
        
        return new $classname;
    }

    /* ������� � ���������� ������ �������� */
    function getPageData($tpl = null)
    {
        require_once 'Cache/Lite.php';
        $this->cache =& new Cache_Lite(array(
                            'cacheDir'           => COMMON_CACHE_FOLDER,
                            'cache_group'        => 'autoru',
                            'lifeTime'           => REFRESH_TIME,
                            'fileNameProtection' => 0,
                            'automaticSerialization' => true,
                            ));
        
        //$this->reclama_obj = $this->createReclamaObj();
        //$page_arr = $this->reclama_obj->getPageReclama();

        
        //$page_arr['TOPSIC']           = $this->getTopsic();
        $page_arr['PAGE_TITLE']       = $this->project_obj->project_title;
        $page_arr['IMAGE_L1']         = 'l1.gif';
        $page_arr['LEFT_SUB_TITLE']   = '�� �������';
        $page_arr['IMAGE_C1']         = 'c1.gif';
        $page_arr['CENTER_SUB_TITLE'] = $this->project_obj->project_name;
        $page_arr['IMG_URL']          = IMAGE_URL;
        $page_arr['YEAR']             = date('Y');

        // ����������� �������������� ������ � ������� ������� ������� � �������
        // ����������� � ������� Project_Layout_User, Project_Reclama
        if (method_exists($this->project_obj, 'getPageData')) {
            $page_arr = array_merge($page_arr, $this->project_obj->getPageData($tpl));
        }

        // ��������
        /*
        $tpl->loadTemplateFile('counter.tmpl',1,1);
        $tpl->setVariable(array(
            'RAMBLER' => $page_arr['RAMBLER'],
            'TOPLIST' => $page_arr['TOPLIST'],
            'SPYLOG' => $page_arr['SPYLOG'],
            'P' => $page_arr['P']
                )
            );
        $page_arr['COUNTER_TMPL']     = $tpl->get();
        */
        if (defined('RAMBLER') && defined('TOPLIST') && defined('SPYLOG')) {
            $tpl->loadTemplateFile('counter.tmpl',1,1);
            $tpl->setVariable(array(
                'RAMBLER' => RAMBLER,
                'TOPLIST' => TOPLIST,
                'SPYLOG' => SPYLOG,
                'P' => 0
                    )
                );
            $page_arr['COUNTER_TMPL']     = $tpl->get();
        }
        //$page_arr = array_merge($page_arr, $this->reclama_obj->getPageReclama());
        $page_arr['MENU']             = $this->getMenu($tpl);
        $page_arr['EMAIL']            = FEEDBACK_SERVER.(SERVER != 'autoru' ? SERVER.'/' : '');
        
        return $page_arr;
    }

}
?>
