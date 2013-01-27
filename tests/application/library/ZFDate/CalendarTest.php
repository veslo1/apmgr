<?php
/**
 * Test for Calendar class
 *
 * @author jvazquez <jvazquez@debserverp4.com.ar>
 */
class ZFDate_CalendarTest extends ControllerTestCase {
    /**
     * Initialize the suite
     * @return unknown_type
     */
    public function setUp() {
        parent::setUp();
    }

    /**
     * Clean the tables
     * @return unknown_type
     */
    public function tearDown() {}

    public function testYieldCalendar() {
    	
        $calendar = new ZFDate_Calendar();
        $result = $calendar->yieldCalendar(2010, 4);
        $this->assertAttributeGreaterThan(10, 'collection', $calendar);
        Zend_Date::setOptions(array('format_type' => 'php'));
        $date = new Zend_Date();
        //  $config = new Zend_Config_Ini(APPLICATION_PATH . "/configs/application.ini", APPLICATION_ENV); Can't read it
        $cal = array();
        foreach($result as $id=>$dateinfo) {
            $date->setTimestamp($dateinfo);
            $cal[$date->toString('D')][]= (double)$dateinfo;
        }
    }
}
?>