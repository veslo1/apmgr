<?php
/**
 *  This particular unit test may take a bit longer in case the model/controller is refactored a bit.
 */
class Unit_Model_LeaseWizardTest extends ControllerTestCase {

    protected $object;
    /**
     * (non-PHPdoc)
     * @see tests/application/ControllerTestCase#setUp()
     */
    public function setUp() {
        parent::setUp();
        $this->object = new Unit_Model_LeaseWizard();
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
    	
         //$this->assertEquals(1,0);
	 $this->markTestIncomplete(
                    'This test has not been implemented yet.'
         );
    }
}