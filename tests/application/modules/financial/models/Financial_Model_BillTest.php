<?php
class Financial_Model_BillTest extends ControllerTestCase {

    protected $object;
    /**
     * (non-PHPdoc)
     * @see tests/application/ControllerTestCase#setUp()
     */
    public function setUp() {
        parent::setUp();
        $this->object = new Financial_Model_Bill();
    }

    /**
     * (non-PHPdoc)
     * @see tests/application/ControllerTestCase#tearDown()
     */
    public function tearDown()
    {
    	parent::tearDown();
    }

    public function testGetOriginalAmountDue()
    {
    	
        $this->object->setOriginalAmountDue( 222.22 );
        $this->assertEquals( 222.22,$this->object->getOriginalAmountDue());
    }

    public function testGetDueDate()
    {
    	
        $this->object->setDueDate( '2010-05-01' );
        $this->assertEquals('2010-05-01',$this->object->getDueDate());
    }

    public function testGetIsPaid()
    {
    	
        $this->object->setIsPaid( 1 );
        $this->assertEquals( 1,$this->object->getIsPaid());
    }

    /**
     *  Use xml dataset
     */
    public function testGetCurrentAmountDue()
    {
    	
         $this->markTestIncomplete(
          'This test has not been implemented yet - is waiting on payment module.'
        );
    }

}