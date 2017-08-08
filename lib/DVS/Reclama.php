<?php
/*////////////////////////////////////////////////////////////////////////////
lib2/DVS
------------------------------------------------------------------------------
����� ���������� ��� �������� AUTO.RU
����� ���������� ����������� ��������
------------------------------------------------------------------------------
$Id: Reclama.php 70 2011-04-11 07:15:31Z xxserg@gmail.com $
////////////////////////////////////////////////////////////////////////////*/

/*
    ������� �������                                   prefix_l1.dat (auto_l1.dat)
    ������� ����������� ������ 468                    prefix_stat.dat (auto_stat.dat)
    ������� ����������� ������ 468 �� �������� �����  mark_stat.dat (audi_stat.dat)
    ������ ������������� � �������:
    ��������� �� ������� ��������                     prefix_skyscraper.dat
    ��������� �� �������� �����                       mark_skyscraper.dat (audi_skyscraper.dat)
*/

class DVS_Reclama
{
    // ���������� �������
    var $path;

    // ������� �������� ������
    var $prefix;

    // ����� ����������� 468
    var $rtb468;

   // ����� ����������� 120x600
    var $rtb120x600;


    function DVS_Reclama()
    {
        if (defined('RECLAMA_PREFIX')) {
            $this->prefix = RECLAMA_PREFIX.'_';
        } else {
            $this->prefix = SERVER.'_';
        }
        if (defined('ROTOBANNER_468LOGIN')) {
            $this->rtb468 = ROTOBANNER_468LOGIN.($_GET['mark']? '-'.$_GET['mark'] : '');
        } else {
            $this->rtb468 = 'ar-'.SERVER;
        }
        if (defined('ROTOBANNER_120x600LOGIN')) {
            $this->rtb120x600 = ROTOBANNER_120x600LOGIN.($_GET['mark'] && defined('SKYSCRAPER_MARK_DEFAULT') ? '-'.$_GET['mark'] : '');
        } else {
            $this->rtb120x600 = 'ar-'.SERVER;
        }

        $this->path = PROJECT_ROOT.RECLAMA_FOLDER;
    }

    function checkFile($file)
    {
        if (file_exists($file) && filesize($file) > 10) {
            return true;
        }
    }

    //��������� ������� ��������
    function getLeftRightBanner($side = 'r')
    {
        $page_arr = array();
        for ($i = 1; $i < 4; $i++) {
        $r = $this->path.$this->prefix.$side.$i.'.dat';
            if ($this->checkFile($r)) {
                $page_arr['RECLAMA_'.strtoupper($side).$i] = file_get_contents($r);
            }
        }
        //print_r($page_arr);
        return $page_arr;
    }

    //��������� ������ ����� ��������
    function getLeftBottomBanners()
    {
        $r = COMMON_LIB.'tmpl/rtcomm.dat';
        if ($this->checkFile($r)) {
            return array('RECLAMA_L4' => file_get_contents($r));
        }
    }

    function get468Banner()
    {
        $r = '';
        if ($_SERVER['REQUEST_URI'] == '/') {
            $r = $this->path.$this->prefix.'stat.dat';
        } else if (isset($_GET['mark'])) {
            $r = PROJECT_ROOT.RECLAMA_FOLDER.$_GET['mark'].'_stat.dat';
        }
        if ($r && $this->checkFile($r)) {
            return array('RECLAMA_C1' => file_get_contents($r));
        } else {
            return array('ROTOBANNER_468LOGIN' => $this->rtb468);
        }
    }

    function get120x600Banner()
    {
        $r = '';
        if (defined('SKYSCRAPER_FIRST') && $_SERVER['REQUEST_URI'] == '/') {
            $r = $this->path.$this->prefix.'skyscraper.dat';
        } else if (defined('SKYSCRAPER_MARK') && $_GET['mark']) {
            $r = PROJECT_ROOT.RECLAMA_FOLDER.$_GET['mark'].'_skyscraper.dat';
        }
        if ($this->checkFile($r)) {
            return array('RECLAMA_SKY' => file_get_contents($r));
        } else if (defined('ROTOBANNER_120x600LOGIN')) {
            if ($_GET['mark']) {
                if (defined('SKYSCRAPER_MARK_DEFAULT')) {
                    return array('ROTOBANNER_120x600LOGIN' => $this->rtb120x600);
                }
            } else {
                return array('ROTOBANNER_120x600LOGIN' => $this->rtb120x600);
            }
        } else {
            return array();
        }
    }

    /*
    ���������� ������� ��� ��������
    ������� ���������� ������ �� ���������, ����� ������ �������, �������� ������� ���������� � $this->project_methods
    ������������ � ������ Project_Reclama
    */
    function getPageReclama()
    {
        $page_arr = array_merge(
            $this->getLeftRightBanner('r'),
            $this->get468Banner(),
            $this->get120x600Banner(),
            $this->getLeftBottomBanners()
        );
        /*
        if (is_array($this->project_methods)) {
            foreach ($this->project_methods as $method) {
                $page_arr = array_merge($page_arr, $this->$method());
            }
        }
        */
        return $page_arr;
    }
}
?>
