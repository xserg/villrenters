<?php
/**
 * ������ �����
 * @package villa
 * $Id: Countries_Index.php 388 2015-04-30 08:59:18Z xxserg $
 */


require_once COMMON_LIB.'DVS/Dynamic.php';

class Project_Countries_Index extends DVS_Dynamic
{
    // �����

    public $perms_arr = array('iu' => 1, 'mu' => 1, 'oc' => 1);

    private $lang_ru = array(
        'Self-catering_holiday_rentals_around_the_World' => '������ ���� �� ����� ����',
        'Show_All' => '�������� ���',
        'View_this_property' => '���������...',
        'Holiday_villas_in' => '',
        'World_Holiday_Destinations' => '�� ��������',
    );


    function getPageData()
    {

        $this->createTemplateObj();
        $this->template_obj->loadTemplateFile('countries_index.tpl');

        //$this->db_obj->limit(0, PER_PAGE);
        $this->db_obj->parent_id=0;
        $this->db_obj->orderBy('id, rus_name');
        //$this->db_obj->find();

        $this->db_obj->getList(0);


        while ($this->db_obj->fetch()) {
            //echo $this->db_obj->name;
            $region_name = $this->db_obj->getAlias();
            $region_link = 'regions/'.$region_name.'/';
            if ($this->db_obj->name == 'Russia') {
                //$region_link = 'http://rurenter.ru/regions/russia/';
            }
            $this->template_obj->setVariable(array(
            //'REGION_LINK'      => '?op=villa&act=index&cid='.$this->db_obj->id,
            'REGION_LINK'      => $region_link,
            'REGION_ALL_LINK' => 'regions/'.$region_name.'/',
            'REGION_NAME' => $this->db_obj->getLocalName(),
            'REGION_CNT' => $this->db_obj->counter,

            ));

            $�ountries_obj = DB_DataObject::factory('countries');
            //$�ountries_obj->whereAdd("counter > 100");

            $�ountries_obj->parent_id = $this->db_obj->id;
            $cnt = $�ountries_obj->count();
            $�ountries_obj->orderBy('rus_name');


            //$�ountries_obj->find();
            //echo $cnt.'<br>';

            $�ountries_obj->getList($this->db_obj->id);

            $i = 0;
            while ($�ountries_obj->fetch()) {
                $country_link = 'regions/'.$�ountries_obj->getAlias().'/';
                if ($�ountries_obj->name == 'Moscow') {
                    $country_link = 'http://rurenter.ru/regions/moscow/';
                }
                $this->template_obj->setVariable(array(
                //'COUNTRY_LINK'  => '?op=villa&act=index&loc='.$�ountries_obj->id,
                //'COUNTRY_LINK'  => 'regions/'.$region_name.'/'.$�ountries_obj->getAlias().'/',
                'COUNTRY_LINK'  => $country_link,
                'COUNTRY_NAME' => $�ountries_obj->getLocalName(),
                'COUNTRY_CNT' => $�ountries_obj->counter,
                ));
                $i++;
                $this->template_obj->parse('COUNTRY_ROW');
                if ($cnt >= 3) {
                    if (!($i % ($cnt / 3))) {
                        $this->template_obj->parse('COUNTRIES_COLUMN');
                    }
                } else {
                    $this->template_obj->parse('COUNTRIES_COLUMN');
                }
            }
            $this->template_obj->parse('REGION');
        }

        $this->template_obj->setVariable(array('ALL_CNT' => $this->getAllcnt()));

        $img_arr = array(2,3,5,6,7,8,9,10,11);

        if ($this->role != 'mu') {
            $this->template_obj->setVariable(array(
                //'ALL_CNT' => $this->getAllcnt(),
                'image_header' => '<img src=/img/header/Header'.$img_arr[array_rand($img_arr)].'.jpg alt="������ ����" title="������ ����, ������������, �����, ���������">',
                //'SEARCH_FORM' => $this->searchForm(),
                //'ANNONCE_TITLE' => '������� �������',
                //'news' => file_get_contents(PROJECT_ROOT.'conf/news.txt'),
                'news' => file_get_contents(PROJECT_ROOT.'tmpl/adsense_b1.tpl').Project_Layout_User::sapeArticles(),
                'FBLIKE' => file_get_contents(PROJECT_ROOT.'tmpl/fblikebox.tpl').file_get_contents(PROJECT_ROOT.'tmpl/vkontakte.tpl'),
            ));
        }
        //$this->searchForm();

        $this->villa_obj->getSpecial($this->template_obj);
        //$this->villa_obj->getSpecialMain(& $this->template_obj);
        //$this->getSpecial();
        $this->getAnnonce();
        $this->getBookings();
        $this->getComments();

        $villa_special_obj = DB_DataObject::factory('villa');
        $villa_special_obj->getRurenterLatest($this->template_obj);

        $this->template_obj->setGlobalVariable($this->lang_ru);




        $page_arr['BODY_CLASS']     = 'landing';
        //$page_arr['BODY_CLASS']     = 'homePage';
        //$page_arr['CENTER_TITLE']   = $this->db_obj->name;
        $page_arr['PAGE_TITLE'] = $this->layout_obj->project_title.' - ������ ����, ������������, �����, ���������';

        $page_arr['CENTER']         = $this->template_obj->get();
        $page_arr['JSCRIPT']        = $this->page_arr['JSCRIPT'];
        return $page_arr;
    }

    function getAllcnt()
    {
            $this->villa_obj = DB_DataObject::factory('villa');
            return $this->villa_obj->count();
    }

    /**
    DEPRECATED
    C� Villa.php
    ���� ���� � ���������� ������
    */
    function getSpecial()
    {
        //$this->villa_obj->special_offer = 1;
        $this->villa_obj->limit(0,5);
        $this->villa_obj->find();
        $i = 0;
        while ($this->villa_obj->fetch()) {
               $i++;
                $this->template_obj->setVariable(array(
                'TOP_VILLA_LINK'      => '/villa/'.$this->villa_obj->id.'.html',
                //'TOP_VILLA_LINK'  => '?op=villa&act=show&id='.$this->villa_obj->id,
                'TOP_VILLA_TITLE' => $this->villa_obj->title_rus,
                'TOP_VILLA_IMAGE' => VILLARENTERS_IMAGE_URL.$this->villa_obj->main_image,
                'last' => $i == 5 ? 'last' : ''
                ));
            $this->template_obj->parse('TOP_VILLA');
        }
    }

    function getAnnonce()
    {
        $pages_obj = DB_DataObject::factory('pages');
        //$pages_obj->get('alias', 'annonce');
        $pages_obj->get('alias', 'about2');

        $this->template_obj->setVariable(array(
        'ANNONCE_TITLE' => $pages_obj->title,
        'ANNONCE' => nl2br(substr($pages_obj->body, 0, 490).'...').'<br><a href="/pages/about2">���������...</a>'));
    }

    function getComments()
    {
        $comments_obj = DB_DataObject::factory('comments');
        $comments_obj->orderBy("id DESC");
        $comments_obj->status_id = 2;
        //$comments_obj->id = 91098;
        $comments_obj->limit(0,1);
        $comments_obj->find();
        while ($comments_obj->fetch()) {
            $this->template_obj->setVariable(array(
                'AUTHOR' => $comments_obj->author,
                'CITY' => $comments_obj->city,
                'COMMENT_TEXT' => substr($comments_obj->article, 0, 256 ),
                'COMMENT_LINK' => '/?op=comments&act=show&id='.$comments_obj->id,
                'Review_Submitted' => '���������',
                'DATE' => DVS_Page::RusDate($comments_obj->post_date),
            ));
            $this->template_obj->parse('COMMENT');
        }
    }

    function getBookings()
    {
        $booking_obj = DB_DataObject::factory('booking');
        $booking_obj->getLatest($this->template_obj);
    }

    function searchForm()
    {
        //$this->template_obj->loadTemplateFile('villa_search_f.tpl');
        $tpl = new HTML_Template_Sigma(PROJECT_ROOT.TMPL_FOLDER, PROJECT_ROOT.CACHE_FOLDER.'tmpl');
        //$tpl->loadTemplateFile('villa_search_f.tpl');
        $tpl->loadTemplateFile('search_form.tpl');
        //$this->template_obj->addBlockFile('SEARCH_FORM', 'SEARCH_FORM', 'villa_search_f.tpl');

        $this->src_files = array(

            'JS_SRC' => array(  '/js/jquery-1.3.1.min.js',
                                '/js/date.js',
                                '/js/date_ru_win1251.js',
                               '/js/datePicker2.js',
                                //'/js/datepicker-ru.js',

        ),

            'CSS_SRC'  => array(
                                '/css/datePicker.css',
                                '/css/demo1.css',
                                '/css/search.css',
        )
        );

         $this->page_arr['JSCRIPT'] = "
            $.dpText = {
                TEXT_PREV_YEAR		:	'����. ���',
                TEXT_PREV_MONTH		:	'����. �����',
                TEXT_NEXT_YEAR		:	'����. ���',
                TEXT_NEXT_MONTH		:	'����. �����',
                TEXT_CLOSE			:	'�������',
                TEXT_CHOOSE_DATE	:	'�������� ����'
            }
            $(function()
            {
                $('.datepicker').datePicker({clickInput:true});
            });";

        return $this->villa_obj->getSearchFormDate($tpl);
    }

}

?>
