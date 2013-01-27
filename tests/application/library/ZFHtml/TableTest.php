<?php
/**
 * Testing the dom table
 *
 * @author jvazquez <jvazquez@debserverp4.com.ar>
 */
class ZFHtml_TableTest extends ControllerTestCase {

    /**
     * Initialize the suite
     * @return unknown_type
     */
    public function setUp() {
        parent::setUp();
    }

    public function testYield() {
    	
        $options = array('month'=>4,'year'=>2010);
        $table = new ZFHtml_Table($options);
        $cal = $table->yield();
        $this->assertNotNull($cal,'Calendar failed');
    }

    public function testInterval() {
    	
        $options = array('month'=>4,'year'=>2010);
        $table = new ZFHtml_Table($options);
        $result = $table->yieldIntervalHours();
        $this->assertTrue(count($result)>0,'We failed generating an array');
    }
}
?>
