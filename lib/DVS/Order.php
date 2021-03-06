<?php
/*////////////////////////////////////////////////////////////////////////////
lib2/DVS
------------------------------------------------------------------------------
����� ���������� ��� �������� AUTO.RU
����� ��������� ������� ���������� �������
------------------------------------------------------------------------------
$Id: Order.php 70 2011-04-11 07:15:31Z xxserg@gmail.com $
////////////////////////////////////////////////////////////////////////////*/

require_once COMMON_LIB.'DVS/Dynamic.php';

class DVS_Order extends DVS_Dynamic
{
    // ���� ����������
    var $field_order = 'sorder';

    // ������� ������
    var $condition_arr = array('up' => '<', 'down' => '>');

    // ���������� ��� ������
    var $order_arr = array('up' => 'DESC', 'down' => 'ASC');

    // �������� �������
    function getPageData()
    {
        // ������������� ���� ����������
        if ($this->db_obj->field_order) {
            $this->field_order = $this->db_obj->field_order;
        }

        // ��������� �������
        $this->checkOrder();

        // �������� ������ ����� ��������
        $this->db_obj->query("SELECT * FROM ".$this->db_obj->__table." WHERE id=".$this->db_obj->id);
        $this->db_obj->fetch();

        // ����� ����������(up) ��� ���������(down) ������
        $db_obj = DB_DataObject::factory($this->db_obj->__table);
        $db_obj->whereAdd($this->field_order.$this->condition_arr[$this->act].$this->db_obj->{$this->field_order});
        $db_obj->orderBy($this->field_order.' '.$this->order_arr[$this->act]);
        $db_obj->limit(0,1);
        $db_obj->find(true);

        // ������
        if (!$db_obj->N) {
            $this->msg = 'error';
            $this->goLocation();
        }

        // ������� ������� = ������� ����������(up) ��� ���������(down)
        $this->updateOrder($this->db_obj->id, $db_obj->{$this->field_order});

        // ������� ����������(up) ��� ���������(down) = �������
        $this->updateOrder($db_obj->id, $this->db_obj->{$this->field_order});

        // ������� �� �������� �� �������
        $this->msg = 'update_rel';
        $this->goLocation();
    }

    // ��������� �������
    function checkOrder()
    {
        $db_obj = DB_DataObject::factory($this->db_obj->__table);
        $db_obj->orderBy($this->field_order);
        $db_obj->find();
        while ($db_obj->fetch()) {
            if (++$number != $db_obj->{$this->field_order}) {
                $this->updateOrder($db_obj->id, $number);
            }
        }
    }

    // ������ update
    function updateOrder($id, $value)
    {
        $this->db_obj->query("UPDATE ".$this->db_obj->__table." SET ".$this->field_order."=".$value." WHERE id=".$id);
    }
}
?>