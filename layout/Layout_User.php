<?php
/**
 * @package villarenters.ru
 * ------------------------------------------------------------------------------
 * ��������� ���������� ������������
 * ------------------------------------------------------------------------------
 * $Id: Layout_User.php 396 2015-05-13 10:05:53Z xxserg $
 */

/**
 * @package Project_Layout_User
 */

require_once PROJECT_ROOT.LAYOUT_FOLDER.'Layout.php';

class Project_Layout_User extends Project_Layout
{
    public $iface = 'user';

    public $iface_url = 'office';

    /* ���� ������������ */
    public $menu = array(    );

    /* ������ ����������� ������ */
    public $op_arr = array('advertisers', 'booking', 'pages', 'users', 'villa', 'countries', 'comments', 'query', 'articles');

    /* ������� �� ��������� */
    public $op_def = 'users';

    //public $act_def = array('pages' => 'show');

    public $project_title = '';

    public $keywords;

    public $description;


    function mailMe($saddress,$scaption,$stitle){
    //variables
      $eaddress= "";  $sdomain= "";  $aextra = "";

    //begin parsing
      list($eaddress, $sdomain)= split('@', $saddress);
      list($sdomain, $aextra) = split('\?', $sdomain);
      $sdomain = ereg_replace('\.', '#', $sdomain);

    //create the js address
      $smailme = "maMe('".urlencode( $sdomain );
      if($aextra != "" ){
        $smailme .= "?" . $aextra;
      }
      $smailme .= "','" . urlencode( $eaddress ) . "')";

    //build the js events
      $sbuild =" onmouseover=\"javascript:this.href=$smailme;\"";
      $sbuild.=" onfocus=\"javascript:this.href=$smailme;\"";

    //return
      return "<a href=\"/contact/\"$sbuild title=\"$stitle\">$scaption</a>";
    }


    function getPageData($tpl = null)
    {
        require_once COMMON_LIB.'DVS/Dynamic.php';
        //$page_arr['PAGE_TITLE']     = $this->project_title;
        $page_arr['KEYWORDS']       = $this->keywords;
        $page_arr['DESCRIPTION']    = $this->description;
        $page_arr['PAGE_TITLE']       = $this->page_title.' '.$this->project_title;
         $page_arr['LANG'] = 'ru';
         $page_arr['MOBILE_URL'] = SERVER_URL.'?versm=mob';
         /*
         $page_arr['CODEMAIL'] = '<script language="JavaScript">
         <!--
           function maMe(sDom, sUser){
  return("mail"+"to:"+sUser+"@"+sDom.replace(/%23/g,"."));
} 
         //-->
         </script>'.$this->mailMe('info@villarenters.ru','<img src=/img/em.png >','contact us');
         */
        //$page_arr['LOGIN_FORM'] = $this->page_title.' '.$_SESSION['_authsession']['username'];
        //$this->loginInfo($tpl);
        //$this->getMenu($tpl);
        

        if (SERVER_TYPE == 'remote') {
        //if (SERVER_TYPE) {
            //$page_arr['GOOGLE_ANAL_CODE'] = file_get_contents(PROJECT_ROOT.'tmpl/ga.tpl').file_get_contents(PROJECT_ROOT.'tmpl/rambler.tpl').file_get_contents(PROJECT_ROOT.'tmpl/ymetrika.tpl');
            $page_arr['TOP_BANNER'] = file_get_contents(PROJECT_ROOT.'tmpl/top_banner.tpl');

            $page_arr['GOOGLE_ANAL_CODE'] = file_get_contents(PROJECT_ROOT.'tmpl/ga.tpl');
            
            $page_arr['GOOGLE_ANAL_CODE'] .= file_get_contents(PROJECT_ROOT.'tmpl/jivo.tpl');

            $page_arr['LI_CODE'] = file_get_contents(PROJECT_ROOT.'tmpl/liveinternet.tpl');
       
            //if (preg_match("/villarenters/", $_SERVER['HTTP_HOST'])) {
                $page_arr['RECLAMA'] = $this->getReclama2();
            //}
        }
                //$page_arr['RECLAMA'] = $this->getReclama2();


        //$pages_obj = DVS_Dynamic::createDbObj('pages');
        //$pages_obj->getNewsBlock($tpl, 6);
        
        $this->getTopMenu($tpl);

        $tpl->setVariable($page_arr);
        return;
    }

    function getReclama2()
    {
        if (!defined('_SAPE_USER')){
           define('_SAPE_USER', '38d37aac66cf19ee43c60a5da7a17934');
        }
            //require_once($_SERVER['DOCUMENT_ROOT'].'/'._SAPE_USER.'/sape.php');
        require_once(PROJECT_ROOT."WWW/38d37aac66cf19ee43c60a5da7a17934/sape.php");
        
        //$sape_context = new SAPE_context();
        //return '<div>'.$sape_context->replace_in_text_segment(' ').'</div>';
        //$o[ 'force_show_code' ] = true; 
        $o['host'] = 'villarenters.ru';
        $sape = new SAPE_client($o);
        unset($o);
        return '<div>'.$sape->return_links().'</div>';
    }

    public static function sapeArticles()
    {
         if (!defined('_SAPE_USER')){
            define('_SAPE_USER', '38d37aac66cf19ee43c60a5da7a17934');
         }
         require_once($_SERVER['DOCUMENT_ROOT'].'/'._SAPE_USER.'/sape.php');
         $s[ 'force_show_code' ] = false;  
         $sape_article = new SAPE_articles($s);
         $ret = $sape_article->return_announcements(1);
         $ret .= '<br><br>'.$sape_article->return_announcements(2);
         $ret .= '<br><br>'.$sape_article->return_announcements(3);
         return $ret;
    }

}
?>
