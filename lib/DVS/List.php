<?php
/*////////////////////////////////////////////////////////////////////////////
lib2/DVS
------------------------------------------------------------------------------
����� ���������� ��� �������� AUTO.RU
����� ������ ������
------------------------------------------------------------------------------
$Id: List.php 70 2011-04-11 07:15:31Z xxserg@gmail.com $
////////////////////////////////////////////////////////////////////////////*/

class DVS_List
{
    // ���-�� �������
    var $columns_count = 2;

    // ������ ������ ������
    var $start_i = 0;

    // ������ ������� � %
    var $column_width = 10;

    // �������� ������� � ���-���
    var $use_colomn_cnt = false;

    // ������ ������
    function buildList($db_obj, $template_obj)
    {
        // ��� �������
        if (!$db_obj->N) { 
            return '������� ���';
        }

        // ������� ������ �������
        if ($db_obj->N < $this->columns_count) {
            $this->columns_count = $db_obj->N;
        }

        // ������ �������
        if ($this->columns_count > 1) {
            $this->column_width = ceil(100/$this->columns_count);
        }

        // ���������� ������� � ����� �������
        $count_column_rows = ceil($db_obj->N/$this->columns_count);

        // ������
        $data_arr = $this->getDataList(&$db_obj, $count_column_rows);

        // ������
        $template_obj->loadTemplateFile('list.tmpl');
        for ($i = 1; $i <= count($data_arr['name']); $i++) {
            $template_obj->setVariable('NAME', $data_arr['name'][$i]);
            if ($this->use_colomn_cnt) {
                $template_obj->setVariable('CNT', $data_arr['cnt'][$i]);
            }
            // ����������� ����� ���������
            if ($i < $this->columns_count) {
                $template_obj->setVariable('IMG_URL', IMAGE_URL);
            }
            $template_obj->parse('CELL');
        }
        $template_obj->setVariable('WIDTH', $this->column_width);
        return $template_obj->get();
    }

    // ������� ������ ������ �� ����
    function getDataList($db_obj, $count_column_rows)
    {
        $col_i = 1;
        while ($db_obj->fetch()) {
            // ��������
            if (method_exists($db_obj, 'listRow')) {
                $values = $db_obj->listRow();
            } else {
                $values = $db_obj->toArray();
            }

            $data_arr['name'][$col_i] .= $values['name'].'<br>';
            $data_arr['cnt'][$col_i]  .= $values['cnt'].'<br>';

            // ���-�� ������� � ������� ��������� ����������� ���-��
            if (++$this->start_i >= $count_column_rows) {
                // ����������� ���-�� ������� � ������� �������
                if ($col_i < $this->columns_count) {
                    $db_obj->N -= $count_column_rows;
                    $count_column_rows = ceil($db_obj->N/($this->columns_count - $col_i));
                }
                $col_i++;
                $this->start_i = 0;
            }
        }
        return $data_arr;
    }
}

?>