<?php
/**
 * @package villarenters.ru
 * @description Языковый файл Русский язык
 * $Id: Lang_ru.php 357 2014-10-17 12:24:44Z xxserg $
 */

$lang = array();

/**
 * Общие константы
 */
$lang['constant']['dvs_error'] = 'Ошибка!';
$lang['constant']['dvs_error_404'] = 'Нет такого файла на сервере...';
$lang['constant']['dvs_error_login'] = 'Неправильный логин или пароль';
$lang['constant']['dvs_error_not_exist'] = 'Запись не существует';
$lang['constant']['dvs_error_db_not_exist'] = 'БД не существует';
$lang['constant']['dvs_error_dynamic_not_exist'] =  'Ошибка! Не существует класса Dynamic!';
$lang['constant']['dvs_error_layout_not_exist'] = 'Ошибка! Не существует класса Layout!';
$lang['constant']['dvs_error_service'] = 'Сервис временно недоступен. Приносим свои извинения';
$lang['constant']['dvs_error_forbidden1'] = 'Операция запрещена! (#1)';
$lang['constant']['dvs_error_forbidden2'] = 'Операция запрещена! (#2)';
$lang['constant']['dvs_error_forbidden3'] = 'Операция запрещена! (#3)';
$lang['constant']['dvs_error_forbidden4'] = 'Операция запрещена! (#4)';
$lang['constant']['dvs_error_forbidden5'] = 'Операция запрещена! (#5)';
$lang['constant']['dvs_error_method'] = 'Метода не существует!';
$lang['constant']['dvs_error_href'] = 'Неправильная ссылка!';
$lang['constant']['dvs_error_help'] = 'Помощь отсутствует!';
$lang['constant']['dvs_error_exist'] = 'Внимание! Похожие или аналогичные записи в базе уже есть!';
$lang['constant']['dvs_add_row'] = 'Запись добавлена!';
$lang['constant']['dvs_delete_row'] = 'Запись удалена!';
$lang['constant']['dvs_update_row'] = 'Запись изменена!';
$lang['constant']['dvs_send_letter'] = 'Письмо отправлено!';
$lang['constant']['dvs_new'] = 'Добавить';
$lang['constant']['dvs_edit'] = 'Редактировать';
$lang['constant']['dvs_delete'] = 'Удалить';
$lang['constant']['dvs_save'] = 'Сохранить';
$lang['constant']['dvs_next'] = 'Дальше';
$lang['constant']['dvs_prev'] = 'Назад';
$lang['constant']['dvs_required'] = 'Заполните поле';
$lang['constant']['dvs_error_status'] = 'Непроверенный статус';
$lang['constant']['dvs_error_pay'] = 'Недостаточная сумма на счету!';
$lang['constant']['dvs_no_records'] = 'Записей нет';
$lang['constant']['dvs_cnt_records'] = 'Всего записей:';
$lang['constant']['dvs_confirm'] = 'Вы уверены, что хотите удалить эту запись?';
$lang['constant']['dvs_moder'] = 'Запись добавлена, ожидает модерации администратором';

/**
 * Администратор
 */
$lang['layout']['admin']['page_title'] = 'Администратор';
$lang['layout']['admin']['login_title'] = 'Администратор';
$lang['layout']['admin']['menu_text']['?op=users'] = 'Пользователи';
//$lang['layout']['admin']['menu_text']['?op=users&role_id=1'] = 'Администраторы';
//$lang['layout']['admin']['menu_text']['?op=users&role_id=2'] = 'Редакторы';
//$lang['layout']['admin']['menu_text']['?op=users&role_id=3'] = 'Владельцы';
//$lang['layout']['admin']['menu_text']['?op=users&role_id=4'] = 'Туристы';

//$lang['layout']['admin']['menu_text']['zag5'] = 'Настройки';
$lang['layout']['admin']['menu_text']['?op=countries'] = 'Страны';
$lang['layout']['admin']['menu_text']['?op=option_groups'] = 'Группы';
$lang['layout']['admin']['menu_text']['?op=options'] = 'Опции';
$lang['layout']['admin']['menu_text']['?op=query'] = 'Вопросы';
//$lang['layout']['admin']['menu_text']['?op=pay_services'] = 'Платежные системы';
$lang['layout']['admin']['menu_text']['?op=pages'] = 'Страницы';
$lang['layout']['admin']['menu_text']['?op=villa'] = 'Виллы';
$lang['layout']['admin']['menu_text']['?op=comments'] = 'Отзывы';


/**
 * Редактор
 */

$lang['layout']['redactor']['page_title'] = 'Администратор';
$lang['layout']['redactor']['login_title'] = 'Модератор';
$lang['layout']['redactor']['menu_text']['zag2'] = 'Модерация';


/**
 * Рекламодатель
 */
$lang['layout']['client']['page_title'] = 'Администратор';
$lang['layout']['client']['login_title'] = 'Рекламодатель';
$lang['layout']['client']['menu_text']['?op=campaigns'] = 'Рекламные кампании';
$lang['layout']['client']['menu_text']['?op=advertisers&act=show'] = 'Реквизиты';
$lang['layout']['client']['menu_text']['?op=transactions'] = 'Личный счет';
$lang['layout']['client']['menu_text']['?op=pay_services&act=select'] = 'Пополнить счет';


/**
 * Frontend
 */
$lang['layout']['user']['project_title'] = 'Villarenters.ru';


$lang['layout']['user']['keywords'] = 'аренда виллы, аренда апартаментов, аренда коттеджа, аренда дома, аренда шале, бронирование online, снять дом, снять коттедж, отдых заграницей';
$lang['layout']['user']['description'] = 'Аренда вилл, домов, апартаментов, квартир на прямую без посредников. Он-лайн бронирование. Страхование платежей. Отзывы туристов. Низкие цены.';
//$lang['layout']['user']['menu_text']['zag1'] = 'Villarenters';
$lang['layout']['user']['menu_text']['/'] = 'Главная';
//$lang['layout']['user']['menu_text']['/pages/about/'] = 'О проекте';
$lang['layout']['user']['menu_text']['/pages/faq/'] = 'Вопрос-Ответ';
$lang['layout']['user']['menu_text']['http://rurenter.ru/sale/'] = 'Продажа';
//$lang['layout']['user']['menu_text']['/?op=pages&act=avia'] = 'Авиабилеты';
//$lang['layout']['user']['menu_text']['/?op=pages&act=cars'] = 'Прокат авто';

//$lang['layout']['user']['menu_text']['http://villarenters.com/renter/'] = 'Регистрация';
//$lang['layout']['user']['menu_text']['http://rurenter.ru/lorem/'] = 'Форум';
$lang['layout']['user']['menu_text']['/pages/vng-europe/'] = 'ВНЖ в Европе';
$lang['layout']['user']['menu_text']['http://rurenter.ru/reg/'] = 'Добавить объект';
//$lang['layout']['user']['menu_text']['/?op=users&act=new'] = 'Регистрация';

//$lang['layout']['user']['menu_text']['/office/'] = 'Вход в офис';


/**
 * DBO
 */


/**
 * comments
 */
$lang['dbo']['comments']['center_title'] = 'Отзывы';
$lang['dbo']['comments']['head_form'] = 'Добавить отзыв';
$lang['dbo']['comments']['fb_fieldLabels']['author'] = 'Имя';
$lang['dbo']['comments']['fb_fieldLabels']['last_name'] = 'Фамилия';
$lang['dbo']['comments']['fb_fieldLabels']['email'] = 'E-mail';


/**
 * Countries
 */
$lang['dbo']['countries']['center_title'] = 'Регионы';
$lang['dbo']['countries']['head_form'] = 'регион';
$lang['dbo']['countries']['fb_fieldLabels']['name'] = 'Название';
$lang['dbo']['countries']['fb_fieldLabels']['rus_name'] = 'Рус.';


/**
 * option_groups
 */
$lang['dbo']['option_groups']['center_title'] = 'Группы опций';
$lang['dbo']['option_groups']['head_form'] = 'группу';
$lang['dbo']['option_groups']['fb_fieldLabels']['name'] = 'Название';
$lang['dbo']['option_groups']['fb_fieldLabels']['rus_name'] = 'Рус.';


/**
 * options
 */
$lang['dbo']['options']['center_title'] = 'Опций';
$lang['dbo']['options']['head_form'] = 'опцию';
$lang['dbo']['options']['fb_fieldLabels']['group_id'] = 'Группа';
$lang['dbo']['options']['fb_fieldLabels']['name'] = 'Название';
$lang['dbo']['options']['fb_fieldLabels']['rus_name'] = 'Рус.';

/**
 * villa
 */
$lang['dbo']['villa']['center_title'] = 'Виллы';
$lang['dbo']['villa']['head_form'] = 'виллу';
$lang['dbo']['villa']['fb_fieldLabels']['main_image'] = '&nbsp;';
$lang['dbo']['villa']['fb_fieldLabels']['title'] = 'Название';
$lang['dbo']['villa']['fb_fieldLabels']['title_name'] = 'Рус.';


/**
 * query
 */
$lang['dbo']['query']['center_title'] = 'Вопрос';
$lang['dbo']['query']['head_form'] = '';
$lang['dbo']['query']['fb_fieldLabels']['first_name'] = 'Имя';
$lang['dbo']['query']['fb_fieldLabels']['last_name'] = 'Фамилия';
$lang['dbo']['query']['fb_fieldLabels']['email'] = 'E-mail';
$lang['dbo']['query']['fb_fieldLabels']['email2'] = 'Повторите E-mail';

$lang['dbo']['query']['fb_fieldLabels']['phone'] = 'Телефон';

$lang['dbo']['query']['fb_fieldLabels']['email_not_match'] = 'E-mail не совпадает!';

$lang['dbo']['query']['fb_fieldLabels']['title_name'] = 'Рус.';

/**
 * Users
 */
$lang['dbo']['users']['center_title'] = 'Пользователи';
$lang['dbo']['users']['head_form'] = 'пользователя';
$lang['dbo']['users']['fb_fieldLabels']['email'] = 'E-mail';
$lang['dbo']['users']['fb_fieldLabels']['password'] = 'Пароль (мин 5 символов)';
$lang['dbo']['users']['fb_fieldLabels']['confirm_password'] = 'Повторите пароль';

$lang['dbo']['users']['fb_fieldLabels']['last_ip'] = 'Ip';
$lang['dbo']['users']['fb_fieldLabels']['name'] = 'Имя, Название';
$lang['dbo']['users']['fb_fieldLabels']['phone'] = 'Телефон';
$lang['dbo']['users']['fb_fieldLabels']['reg_date'] = 'Дата регистрации';
$lang['dbo']['users']['fb_fieldLabels']['last_date'] = 'Последняя дата';
$lang['dbo']['users']['fb_fieldLabels']['role_id'] = 'Роль';
$lang['dbo']['users']['fb_fieldLabels']['note'] = 'Доп. информация';
$lang['dbo']['users']['rules']['email'][] = 'Недопустипый формат поля';
$lang['dbo']['users']['rules']['email'][] = 'Такой E-mail уже зарегистрирован!';
$lang['dbo']['users']['rules']['phone'][] = 'Введите телефон в формате +7(495)111-22-33" !';

////////////////////////////////////////////////////////////////////////////////////////////////
$lang['dbo']['users']['center_title'] = 'Пользователи';

$lang['dbo']['users']['words']['form_title'] = 'Реквизиты';
$lang['dbo']['users']['words']['form_title2'] = 'Адрес, контакты';
$lang['dbo']['users']['words']['agree'] = ' Я прочитал и согласен с условиями предоставления сервиса ';
$lang['dbo']['users']['words']['agreement'] = 'условия предоставления сервиса';
$lang['dbo']['users']['words']['error_format'] = 'Непроавильный формат поля';
$lang['dbo']['users']['words']['disagree'] = 'Вы не согласны с условиями сервиса!';

$lang['dbo']['users']['head_form'] = 'Добавить пользователя';
$lang['dbo']['users']['fb_fieldLabels']['email'] = 'E-mail';
$lang['dbo']['users']['fb_fieldLabels']['password'] = 'Пароль';
$lang['dbo']['users']['fb_fieldLabels']['confirm_password'] = 'Повторите пароль';

$lang['dbo']['users']['fb_fieldLabels']['last_ip'] = 'Ip';
$lang['dbo']['users']['fb_fieldLabels']['name'] = 'Имя';
$lang['dbo']['users']['fb_fieldLabels']['lastname'] = 'Фамилия';
$lang['dbo']['users']['fb_fieldLabels']['address'] = 'Адрес';

$lang['dbo']['users']['fb_fieldLabels']['country'] = 'Страна';
$lang['dbo']['users']['fb_fieldLabels']['city'] = 'Город';
$lang['dbo']['users']['fb_fieldLabels']['street'] = 'Улица';
$lang['dbo']['users']['fb_fieldLabels']['house_num'] = 'Дом';
$lang['dbo']['users']['fb_fieldLabels']['age'] = 'Возраст';
$lang['dbo']['users']['fb_fieldLabels']['company'] = 'Компания';
$lang['dbo']['users']['fb_fieldLabels']['home_phone'] = 'Домашний телефон';
$lang['dbo']['users']['fb_fieldLabels']['work_phone'] = 'Рабочий телефон';
$lang['dbo']['users']['fb_fieldLabels']['mobile_phone'] = 'Мобильный телефон';
$lang['dbo']['users']['fb_fieldLabels']['reg_date'] = 'Дата регистрации';
$lang['dbo']['users']['fb_fieldLabels']['last_date'] = 'Последняя дата';
$lang['dbo']['users']['fb_fieldLabels']['role_id'] = 'Роль';
$lang['dbo']['users']['fb_fieldLabels']['status_id'] = 'Статус';

$lang['dbo']['users']['fb_fieldLabels']['note'] = 'Доп. информация';
$lang['dbo']['users']['rules']['email'][] = 'Недопустипый формат поля';
$lang['dbo']['users']['rules']['email'][] = 'Такой E-mail уже зарегистрирован!';
$lang['dbo']['users']['rules']['phone'][] = 'Введите телефон в формате +7(495)111-22-33" !';

$lang['dbo']['users']['words']['reg_title'] = 'Регистрация нового пользователя';
$lang['dbo']['users']['words']['reg_help'] = 'Введите действующий адрес электронной почты.<br>Вам будет выслан код для подтверждения регистрации';
$lang['dbo']['users']['fb_fieldLabels']['role_id_title'] = 'Вы хотите';
$lang['dbo']['users']['fb_fieldLabels']['role_id_label1'] = 'Сдать (для владельцев)';
$lang['dbo']['users']['fb_fieldLabels']['role_id_label2'] = 'Снять (для арендаторов)';
$lang['dbo']['users']['rules']['password'][] = 'Длина пароля должна быть не менее 5 символов!';
$lang['dbo']['users']['rules']['password'][] = 'Пароли не совпадают!';

/**
 * Dynamic Countries_Index
 */
//$lang['dynamic']['countries_index']['center_title'] = 'Опций';


?>
