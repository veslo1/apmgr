<?php
class Unit_Model_ApplicantStatusTest extends ControllerTestCase {

    protected $object;
    /**
     * (non-PHPdoc)
     * @see tests/application/ControllerTestCase#setUp()
     */
    public function setUp() {
        parent::setUp();
        $this->object = new Applicant_Model_ApplicantStatus();
    }

    /**
     * (non-PHPdoc)
     * @see tests/application/ControllerTestCase#tearDown()
     */
    public function tearDown()
    {
    	parent::tearDown();
    }

    public function testGetName()
    {
    	
        $this->object->setName('test');
        $this->assertEquals('test',$this->object->getName());
    }
}
?>