<?php
/*////////////////////////////////////////////////////////////////////////////
���������� ���� ������ ������������ �������� �� rentalsystem.com
------------------------------------------------------------------------------

------------------------------------------------------------------------------
$Id: Booking_log_Add.php 70 2011-04-11 07:15:31Z xxserg@gmail.com $
////////////////////////////////////////////////////////////////////////////*/

require_once COMMON_LIB.'DVS/Dynamic.php';

class Project_Booking_log_Add extends DVS_Dynamic
{
    // �����
    public $perms_arr = array('iu' => 1, 'ar' => 1);

//REF}&pref={PREF}&ck=ck&req1="+ req1.value + "&req2=" + req2.value + "&ctype=&rag={RAG}&rcam=

    function getPageData()
    {
        $alias = DVS::getVar('alias');
        echo '<pre>';
        print_r($GET);
        exit;
    }
}

?>