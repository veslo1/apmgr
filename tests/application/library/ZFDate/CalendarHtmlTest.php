<?php
/**
 * Description of CalendarHtmlTest
 *
 * @author jvazquez <jvazquez@debserverp4.com.ar>
 */
class ZFDate_CalendarHtmlTest extends ControllerTestCase {
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

    public function testCalendarHtml() {
    	
        $chtml = new ZFDate_CalendarHtml();
        $this->assertTrue(strlen($chtml->getMonthView(4, 2010))>10);
    }
}
?>
