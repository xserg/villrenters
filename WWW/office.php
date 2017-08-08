<?php
/*////////////////////////////////////////////////////////////////////////////
web2matrix
------------------------------------------------------------------------------

------------------------------------------------------------------------------
$Id: office.php 70 2011-04-11 07:15:31Z xxserg@gmail.com $
////////////////////////////////////////////////////////////////////////////*/
//phpinfo();
//exit;
require_once '../conf/config.inc';
require_once COMMON_LIB.'DVS/Admin_Office.php';

$page_obj =& new DVS_Admin_Office('a');
//print_r($page_obj);
echo $page_obj->showPage();

if (PEAR::isError($page_obj)) {
    PEAR::raiseError('Unable to create DVS_Admin_Office');
}

?>
