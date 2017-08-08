<?php
/*////////////////////////////////////////////////////////////////////////////
@package lib2/DVS
------------------------------------------------------------------------------
����� ���������� �����
------------------------------------------------------------------------------
$Id: Cache.php 299 2013-10-16 14:12:20Z xxserg@gmail.com $
////////////////////////////////////////////////////////////////////////////*/

class DVS_Cache
{

    // ���������� ��������
    var $_caching;
    // �������� ������ CacheLite
    var $_cacheopt;
    /*
    ����������� ���������, ����� �� ��� ��� ��������, ���������� � ������������ �������.
    � ������������ ������� ���������� ����� ���������� �������� ��� ��������.
    
        $cached_pages = array(

                    'op1' => array(
                        'act1'      => array(
                            'cacheDir'           => PROJECT_ROOT.CACHE_FOLDER.$this->get['board'].'/',
                            'lifeTime'           => MSG_REFRESH_TIME*100,
                            'fileNameProtection' => 0,
                            'cache_id'           => $this->get['id'].($_REQUEST['st'] ? '_st' : '').($_GET['archive'] == 2 ? '_old' : ''),
                            'cache_group'        => 'msg',
                            //'automaticSerialization' => true,
                            ),
    ................
    );
    */

    //����������� ��������� ����������� �������� � ���������� �������� �����������
    function DVS_Cache($get = null)
    {
        $this->get = $get ? $get : $_GET;
        //print_r($this->get);
        // ����� �� ���������� ��� ��������
        if (is_array($this->cached_pages[$this->get['op']]) && in_array($this->get['act'], array_keys($this->cached_pages[$this->get['op']]))) {
            $this->_caching = true;
            $this->_cacheopt = $this->cached_pages[$this->get['op']][$this->get['act']];
        }

        if ($this->get['op'] == 'static') {
            $this->_caching = true;
            $this->_cacheopt = array(
                            'cacheDir'           => PROJECT_ROOT.CACHE_FOLDER.'static/',
                            'lifeTime'           => REFRESH_TIME,
                            'fileNameProtection' => 0,
                            'cache_id'           => $this->get['act'],
                            'cache_group'        => 'static',
                            );
        }
    }

    function showCachedPage($iface='i')
    {
        if (!$content = $this->getContent()) {
            require_once COMMON_LIB.'DVS/Page.php';
            $page_obj = DVS_Page::factory(DVS::getVar('op'), DVS::getVar('act'), $iface);
            $content = $page_obj->showPage();
            if (!$page_obj->nocache) {
                $this->saveCache($content);
            }
        }
        return $content;
    }

    // ������ CacheLite ��������� ������ � ������ ���� �������� ����������
    function getContent($doNotTestCacheValidity = false)
    {
        if ($this->_caching) {
            $this->createCacheObject();
            return $this->cache->get($this->_cacheopt['cache_id'], $this->_cacheopt['cache_group'], $doNotTestCacheValidity);
        } else {
            return false;
        }
    }

    // �������� ������� CacheLite
    function createCacheObject()
    {
        require_once 'Cache/Lite.php';
        $this->cache = new Cache_Lite($this->_cacheopt);
    }

    function makeCachedir($dir, $dirmode = 0775)
    {
       if (!empty($dir)) {
           if (!file_exists($dir)) {
               preg_match_all('/([^\/]*)\/?/i', $dir,$atmp);
               $base="";
               foreach ($atmp[0] as $key=>$val) {
                   $base=$base.$val;
                   if(!file_exists($base))
                       if (mkdir($base,$dirmode)) {
                            chmod($base, $dirmode);
                       } else {
                           echo "Error: Cannot create ".$base;
                           return 0;
                       }
               }
           } else if (!is_dir($dir)) {
                   echo "Error: ".$dir." exists and is not a directory";
                   return -2;
           }
       }
       return 0;
    }

    // ���������� ����
    function saveCache($content)
    {
        global $_DVS;

        if ($this->_caching && !$_DVS['NOCACHE']) {
            if (defined('TEST_CACHE')) {
                echo "CACHING ".$this->_cacheopt['cacheDir']
                    ." ====".$this->_cacheopt['cache_id']."++++++".$this->_cacheopt['cache_group']."--".$this->_cacheopt['fileNameProtection'];
            }
            $this->makeCachedir($this->_cacheopt['cacheDir']);
            $this->cache->save($content);
        }
    }

    // ������� ����
    function deleteCache($remove_group = false)
    {
        $this->createCacheObject();
        if ($remove_group) { // ������� ������ ����
            $this->cache->clean($this->_cacheopt['cache_group']);
        } else { // ������� ���������������� �����
            $this->cache->remove($this->_cacheopt['cache_id'], $this->_cacheopt['cache_group']);
        }
    }

    function getArray($op)
    {
        require_once 'Cache/Lite.php';
        $this->cache = new Cache_Lite(array(
                            'cacheDir'           => PROJECT_ROOT.CACHE_FOLDER.'array/',
                            'cache_id'           => $op,
                            'cache_group'        => 'array',
                            'lifeTime'           => REFRESH_TIME,
                            'fileNameProtection' => 0,
                            'automaticSerialization' => true,
                            ));
        if (!$array = $this->cache->get($op, 'array', 1)) {
            require_once 'DB/DataObject.php';
            $db_obj = DB_DataObject::factory($op);
            $array = $db_obj->selArray();
            $this->cache->save($array);
        }
        return $array;
    }
}
?>
