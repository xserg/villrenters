<?php
/*////////////////////////////////////////////////////////////////////////////
lib2/DVS
------------------------------------------------------------------------------
����� ���������� ��� ��������
����� �������� �������� �������
------------------------------------------------------------------------------
$Id: Layout.php 70 2011-04-11 07:15:31Z xxserg@gmail.com $
////////////////////////////////////////////////////////////////////////////*/

class DVS_Layout
{
    // ������ �������� �������
    var $project_obj;

    // �������� �������
    var $template_name;

    // ���������
    var $iface;

    /*
    ���������� ������������ �� ���������� $classname
    ���������� ������ & new $classname
    */
    function factory($iface, $role = 'iu')
    {
        global $_DVS;
        if ($iface == 'i') {
            $filename = 'Layout_User';
        } else {
            $filename = 'Layout_Admin_Office';
        }
        //echo $role;
        include_once COMMON_LIB.'DVS/'.$filename.'.php';
        $classname        = DVS_CLASS_PREFIX.$filename;
        if (!class_exists($classname)) {
            return PEAR::raiseError('Unable to find Layout '.$classname.' class');
        } else {
            $layout_obj        = new $classname;
            $layout_obj->iface = $iface;

            $project_layout_filename = 'Layout_'.ucfirst($_DVS['CONFIG']['INAMES'][$role]);
            @include_once PROJECT_ROOT.LAYOUT_FOLDER.$project_layout_filename.'.php';
            $project_layout_classname = DVS_PROJECT_CLASS_PREFIX.$project_layout_filename;

            if (!class_exists($project_layout_classname)) {
                return PEAR::raiseError('Unable to find Project Layout '.$project_layout_classname.' class');
            } else {
                $project_layout_obj = new $project_layout_classname;
                $layout_obj->project_obj = $project_layout_obj;
            }
        }
        return $layout_obj;
    }

    /* �������� ���� */
    function getMenu($tpl)
    {
        //$menu = array_merge($this->project_obj->menu, $common_menu);
        $menu = $this->project_obj->menu;

        $tpl->loadTemplateFile('menuv.tmpl',1,1);
        foreach ($menu as $arr) {
            switch ($arr[0]) {
                case 'ZAG':
                    $tpl->setVariable('ZAG', $arr[1]);
                    break;
                case 'BR':
                    $tpl->setVariable('TEXT', '<BR>');
                    break;
                case 'reclama':
                    $file = $this->reclama_obj->path.$this->reclama_obj->prefix.$arr[1].'.dat';
                    if (file_exists($file) && filesize($file)>10) {
                        $tpl->setVariable('TEXT_CENTER', file_get_contents($file));
                    }
                    break;
                case '':
                    if (file_exists($file = $arr[1]) && filesize($file)>10) {
                        $tpl->setVariable('TEXT', file_get_contents($file));
                    }
                    break;
                default:
                    //if(!stristr($arr[0], SERVER)) {
                        $tpl->setVariable(array('KEY' => $arr[0], 'VAL' => $arr[1]));
                    //}
                    break;
            }
            $tpl->setVariable('IMG_URL', IMAGE_URL);
            $tpl->parse('MENU');
        }
        return $tpl->get();
    }


}
?>
