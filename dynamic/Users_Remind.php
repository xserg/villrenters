<?php
/**
 * @package web2matrix
 * ����������� ������
 * $Id: Users_Remind.php 70 2011-04-11 07:15:31Z xxserg@gmail.com $
 */

require_once COMMON_LIB.'DVS/Dynamic.php';


class Project_Users_Remind extends DVS_Dynamic
{
    /**
     * �����
     */
    public $perms_arr = array('iu' => 1);

    function getPageData()
    {
 
        $email = strtolower($_POST['email']);
        if ($email) {
            $this->db_obj->get('email', $email);
            if ($this->db_obj->N) {
                $data['to'] = $email;
                $data['subject'] = '����������� ������ �� Web2Matrix.ru';

                $data['body'] = '������ ������������ '.$this->db_obj->email.": ".$this->db_obj->password."\n\n";
                
                require_once COMMON_LIB.'DVS/Mail.php';
                DVS_Mail::send($data);
                $this->msg = "������ ���������!<br><br>";
            } else {
                $this->msg = "������ email �� ���������������<br><br>";
            }
        }
       //else {
            $this->createTemplateObj();
            $this->template_obj->loadTemplateFile('remind.tpl');
            $page_arr['CENTER_TITLE'] = '����������� ������';
            $page_arr['CENTER'] = $this->template_obj->get();
            return $page_arr;
        //}
    }
}

?>