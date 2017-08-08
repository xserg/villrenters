<?php
/**
 * @package villarenters.ru
 * @description �������� ���� ������� ����
 * $Id: Lang_ru.php 357 2014-10-17 12:24:44Z xxserg $
 */

$lang = array();

/**
 * ����� ���������
 */
$lang['constant']['dvs_error'] = '������!';
$lang['constant']['dvs_error_404'] = '��� ������ ����� �� �������...';
$lang['constant']['dvs_error_login'] = '������������ ����� ��� ������';
$lang['constant']['dvs_error_not_exist'] = '������ �� ����������';
$lang['constant']['dvs_error_db_not_exist'] = '�� �� ����������';
$lang['constant']['dvs_error_dynamic_not_exist'] =  '������! �� ���������� ������ Dynamic!';
$lang['constant']['dvs_error_layout_not_exist'] = '������! �� ���������� ������ Layout!';
$lang['constant']['dvs_error_service'] = '������ �������� ����������. �������� ���� ���������';
$lang['constant']['dvs_error_forbidden1'] = '�������� ���������! (#1)';
$lang['constant']['dvs_error_forbidden2'] = '�������� ���������! (#2)';
$lang['constant']['dvs_error_forbidden3'] = '�������� ���������! (#3)';
$lang['constant']['dvs_error_forbidden4'] = '�������� ���������! (#4)';
$lang['constant']['dvs_error_forbidden5'] = '�������� ���������! (#5)';
$lang['constant']['dvs_error_method'] = '������ �� ����������!';
$lang['constant']['dvs_error_href'] = '������������ ������!';
$lang['constant']['dvs_error_help'] = '������ �����������!';
$lang['constant']['dvs_error_exist'] = '��������! ������� ��� ����������� ������ � ���� ��� ����!';
$lang['constant']['dvs_add_row'] = '������ ���������!';
$lang['constant']['dvs_delete_row'] = '������ �������!';
$lang['constant']['dvs_update_row'] = '������ ��������!';
$lang['constant']['dvs_send_letter'] = '������ ����������!';
$lang['constant']['dvs_new'] = '��������';
$lang['constant']['dvs_edit'] = '�������������';
$lang['constant']['dvs_delete'] = '�������';
$lang['constant']['dvs_save'] = '���������';
$lang['constant']['dvs_next'] = '������';
$lang['constant']['dvs_prev'] = '�����';
$lang['constant']['dvs_required'] = '��������� ����';
$lang['constant']['dvs_error_status'] = '������������� ������';
$lang['constant']['dvs_error_pay'] = '������������� ����� �� �����!';
$lang['constant']['dvs_no_records'] = '������� ���';
$lang['constant']['dvs_cnt_records'] = '����� �������:';
$lang['constant']['dvs_confirm'] = '�� �������, ��� ������ ������� ��� ������?';
$lang['constant']['dvs_moder'] = '������ ���������, ������� ��������� ���������������';

/**
 * �������������
 */
$lang['layout']['admin']['page_title'] = '�������������';
$lang['layout']['admin']['login_title'] = '�������������';
$lang['layout']['admin']['menu_text']['?op=users'] = '������������';
//$lang['layout']['admin']['menu_text']['?op=users&role_id=1'] = '��������������';
//$lang['layout']['admin']['menu_text']['?op=users&role_id=2'] = '���������';
//$lang['layout']['admin']['menu_text']['?op=users&role_id=3'] = '���������';
//$lang['layout']['admin']['menu_text']['?op=users&role_id=4'] = '�������';

//$lang['layout']['admin']['menu_text']['zag5'] = '���������';
$lang['layout']['admin']['menu_text']['?op=countries'] = '������';
$lang['layout']['admin']['menu_text']['?op=option_groups'] = '������';
$lang['layout']['admin']['menu_text']['?op=options'] = '�����';
$lang['layout']['admin']['menu_text']['?op=query'] = '�������';
//$lang['layout']['admin']['menu_text']['?op=pay_services'] = '��������� �������';
$lang['layout']['admin']['menu_text']['?op=pages'] = '��������';
$lang['layout']['admin']['menu_text']['?op=villa'] = '�����';
$lang['layout']['admin']['menu_text']['?op=comments'] = '������';


/**
 * ��������
 */

$lang['layout']['redactor']['page_title'] = '�������������';
$lang['layout']['redactor']['login_title'] = '���������';
$lang['layout']['redactor']['menu_text']['zag2'] = '���������';


/**
 * �������������
 */
$lang['layout']['client']['page_title'] = '�������������';
$lang['layout']['client']['login_title'] = '�������������';
$lang['layout']['client']['menu_text']['?op=campaigns'] = '��������� ��������';
$lang['layout']['client']['menu_text']['?op=advertisers&act=show'] = '���������';
$lang['layout']['client']['menu_text']['?op=transactions'] = '������ ����';
$lang['layout']['client']['menu_text']['?op=pay_services&act=select'] = '��������� ����';


/**
 * Frontend
 */
$lang['layout']['user']['project_title'] = 'Villarenters.ru';


$lang['layout']['user']['keywords'] = '������ �����, ������ ������������, ������ ��������, ������ ����, ������ ����, ������������ online, ����� ���, ����� �������, ����� ����������';
$lang['layout']['user']['description'] = '������ ����, �����, ������������, ������� �� ������ ��� �����������. ��-���� ������������. ����������� ��������. ������ ��������. ������ ����.';
//$lang['layout']['user']['menu_text']['zag1'] = 'Villarenters';
$lang['layout']['user']['menu_text']['/'] = '�������';
//$lang['layout']['user']['menu_text']['/pages/about/'] = '� �������';
$lang['layout']['user']['menu_text']['/pages/faq/'] = '������-�����';
$lang['layout']['user']['menu_text']['http://rurenter.ru/sale/'] = '�������';
//$lang['layout']['user']['menu_text']['/?op=pages&act=avia'] = '����������';
//$lang['layout']['user']['menu_text']['/?op=pages&act=cars'] = '������ ����';

//$lang['layout']['user']['menu_text']['http://villarenters.com/renter/'] = '�����������';
//$lang['layout']['user']['menu_text']['http://rurenter.ru/lorem/'] = '�����';
$lang['layout']['user']['menu_text']['/pages/vng-europe/'] = '��� � ������';
$lang['layout']['user']['menu_text']['http://rurenter.ru/reg/'] = '�������� ������';
//$lang['layout']['user']['menu_text']['/?op=users&act=new'] = '�����������';

//$lang['layout']['user']['menu_text']['/office/'] = '���� � ����';


/**
 * DBO
 */


/**
 * comments
 */
$lang['dbo']['comments']['center_title'] = '������';
$lang['dbo']['comments']['head_form'] = '�������� �����';
$lang['dbo']['comments']['fb_fieldLabels']['author'] = '���';
$lang['dbo']['comments']['fb_fieldLabels']['last_name'] = '�������';
$lang['dbo']['comments']['fb_fieldLabels']['email'] = 'E-mail';


/**
 * Countries
 */
$lang['dbo']['countries']['center_title'] = '�������';
$lang['dbo']['countries']['head_form'] = '������';
$lang['dbo']['countries']['fb_fieldLabels']['name'] = '��������';
$lang['dbo']['countries']['fb_fieldLabels']['rus_name'] = '���.';


/**
 * option_groups
 */
$lang['dbo']['option_groups']['center_title'] = '������ �����';
$lang['dbo']['option_groups']['head_form'] = '������';
$lang['dbo']['option_groups']['fb_fieldLabels']['name'] = '��������';
$lang['dbo']['option_groups']['fb_fieldLabels']['rus_name'] = '���.';


/**
 * options
 */
$lang['dbo']['options']['center_title'] = '�����';
$lang['dbo']['options']['head_form'] = '�����';
$lang['dbo']['options']['fb_fieldLabels']['group_id'] = '������';
$lang['dbo']['options']['fb_fieldLabels']['name'] = '��������';
$lang['dbo']['options']['fb_fieldLabels']['rus_name'] = '���.';

/**
 * villa
 */
$lang['dbo']['villa']['center_title'] = '�����';
$lang['dbo']['villa']['head_form'] = '�����';
$lang['dbo']['villa']['fb_fieldLabels']['main_image'] = '&nbsp;';
$lang['dbo']['villa']['fb_fieldLabels']['title'] = '��������';
$lang['dbo']['villa']['fb_fieldLabels']['title_name'] = '���.';


/**
 * query
 */
$lang['dbo']['query']['center_title'] = '������';
$lang['dbo']['query']['head_form'] = '';
$lang['dbo']['query']['fb_fieldLabels']['first_name'] = '���';
$lang['dbo']['query']['fb_fieldLabels']['last_name'] = '�������';
$lang['dbo']['query']['fb_fieldLabels']['email'] = 'E-mail';
$lang['dbo']['query']['fb_fieldLabels']['email2'] = '��������� E-mail';

$lang['dbo']['query']['fb_fieldLabels']['phone'] = '�������';

$lang['dbo']['query']['fb_fieldLabels']['email_not_match'] = 'E-mail �� ���������!';

$lang['dbo']['query']['fb_fieldLabels']['title_name'] = '���.';

/**
 * Users
 */
$lang['dbo']['users']['center_title'] = '������������';
$lang['dbo']['users']['head_form'] = '������������';
$lang['dbo']['users']['fb_fieldLabels']['email'] = 'E-mail';
$lang['dbo']['users']['fb_fieldLabels']['password'] = '������ (��� 5 ��������)';
$lang['dbo']['users']['fb_fieldLabels']['confirm_password'] = '��������� ������';

$lang['dbo']['users']['fb_fieldLabels']['last_ip'] = 'Ip';
$lang['dbo']['users']['fb_fieldLabels']['name'] = '���, ��������';
$lang['dbo']['users']['fb_fieldLabels']['phone'] = '�������';
$lang['dbo']['users']['fb_fieldLabels']['reg_date'] = '���� �����������';
$lang['dbo']['users']['fb_fieldLabels']['last_date'] = '��������� ����';
$lang['dbo']['users']['fb_fieldLabels']['role_id'] = '����';
$lang['dbo']['users']['fb_fieldLabels']['note'] = '���. ����������';
$lang['dbo']['users']['rules']['email'][] = '������������ ������ ����';
$lang['dbo']['users']['rules']['email'][] = '����� E-mail ��� ���������������!';
$lang['dbo']['users']['rules']['phone'][] = '������� ������� � ������� +7(495)111-22-33" !';

////////////////////////////////////////////////////////////////////////////////////////////////
$lang['dbo']['users']['center_title'] = '������������';

$lang['dbo']['users']['words']['form_title'] = '���������';
$lang['dbo']['users']['words']['form_title2'] = '�����, ��������';
$lang['dbo']['users']['words']['agree'] = ' � �������� � �������� � ��������� �������������� ������� ';
$lang['dbo']['users']['words']['agreement'] = '������� �������������� �������';
$lang['dbo']['users']['words']['error_format'] = '������������� ������ ����';
$lang['dbo']['users']['words']['disagree'] = '�� �� �������� � ��������� �������!';

$lang['dbo']['users']['head_form'] = '�������� ������������';
$lang['dbo']['users']['fb_fieldLabels']['email'] = 'E-mail';
$lang['dbo']['users']['fb_fieldLabels']['password'] = '������';
$lang['dbo']['users']['fb_fieldLabels']['confirm_password'] = '��������� ������';

$lang['dbo']['users']['fb_fieldLabels']['last_ip'] = 'Ip';
$lang['dbo']['users']['fb_fieldLabels']['name'] = '���';
$lang['dbo']['users']['fb_fieldLabels']['lastname'] = '�������';
$lang['dbo']['users']['fb_fieldLabels']['address'] = '�����';

$lang['dbo']['users']['fb_fieldLabels']['country'] = '������';
$lang['dbo']['users']['fb_fieldLabels']['city'] = '�����';
$lang['dbo']['users']['fb_fieldLabels']['street'] = '�����';
$lang['dbo']['users']['fb_fieldLabels']['house_num'] = '���';
$lang['dbo']['users']['fb_fieldLabels']['age'] = '�������';
$lang['dbo']['users']['fb_fieldLabels']['company'] = '��������';
$lang['dbo']['users']['fb_fieldLabels']['home_phone'] = '�������� �������';
$lang['dbo']['users']['fb_fieldLabels']['work_phone'] = '������� �������';
$lang['dbo']['users']['fb_fieldLabels']['mobile_phone'] = '��������� �������';
$lang['dbo']['users']['fb_fieldLabels']['reg_date'] = '���� �����������';
$lang['dbo']['users']['fb_fieldLabels']['last_date'] = '��������� ����';
$lang['dbo']['users']['fb_fieldLabels']['role_id'] = '����';
$lang['dbo']['users']['fb_fieldLabels']['status_id'] = '������';

$lang['dbo']['users']['fb_fieldLabels']['note'] = '���. ����������';
$lang['dbo']['users']['rules']['email'][] = '������������ ������ ����';
$lang['dbo']['users']['rules']['email'][] = '����� E-mail ��� ���������������!';
$lang['dbo']['users']['rules']['phone'][] = '������� ������� � ������� +7(495)111-22-33" !';

$lang['dbo']['users']['words']['reg_title'] = '����������� ������ ������������';
$lang['dbo']['users']['words']['reg_help'] = '������� ����������� ����� ����������� �����.<br>��� ����� ������ ��� ��� ������������� �����������';
$lang['dbo']['users']['fb_fieldLabels']['role_id_title'] = '�� ������';
$lang['dbo']['users']['fb_fieldLabels']['role_id_label1'] = '����� (��� ����������)';
$lang['dbo']['users']['fb_fieldLabels']['role_id_label2'] = '����� (��� �����������)';
$lang['dbo']['users']['rules']['password'][] = '����� ������ ������ ���� �� ����� 5 ��������!';
$lang['dbo']['users']['rules']['password'][] = '������ �� ���������!';

/**
 * Dynamic Countries_Index
 */
//$lang['dynamic']['countries_index']['center_title'] = '�����';


?>
