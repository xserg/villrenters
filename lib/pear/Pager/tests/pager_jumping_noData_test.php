<?php
// $Id: pager_jumping_noData_test.php 70 2011-04-11 07:15:31Z xxserg@gmail.com $

require_once 'simple_include.php';
require_once 'pager_include.php';

class TestOfPagerJumpingNoData extends UnitTestCase {
    var $pager;
    function TestOfPagerJumpingNoData($name='Test of Pager_Jumping - no data') {
        $this->UnitTestCase($name);
    }
    function setUp() {
        $options = array(
            'totalItems' => 0,
            'perPage'  => 2,
            'mode'     => 'Jumping',
        );
        $this->pager = Pager::factory($options);
    }
    function tearDown() {
        unset($this->pager);
    }
    function testOffsetByPageId() {
        $this->assertEqual(array(1, 0), $this->pager->getOffsetByPageId());
    }
    function testPageIdByOffset() {
        $this->assertEqual(false, $this->pager->getPageIdByOffset(0));
    }
    function testPageIdByOffset2() {
        $this->assertEqual(1, $this->pager->getPageIdByOffset(1));
    }
    function testPageIdByOffset3() {
        $this->assertEqual(1, $this->pager->getPageIdByOffset(2));
    }
}
?>