<?php
/**
 * Test class for Unit_ViewController.
 * Generated by PHPUnit on 2010-05-12 at 21:47:17.
 */
class Unit_ViewControllerTest extends ControllerTestCase {

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	public function setUp() {
		parent::setup();
		$this->dataSetStackBuffer=array('users'=>1);
        $this->loadDataSets();
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	public function tearDown() {
		$this->unLoadDataSets();
		parent::tearDown();
	}

	/**
	 * @todo Implement testViewallamenitiesAction().
	 */
	public function testViewallamenitiesAction() {
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
                'This test has not been implemented yet.'
                );
	}

	/**
	 * @todo Implement testViewallapartmentsAction().
	 */
	public function testViewallapartmentsAction() {
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
                'This test has not been implemented yet.'
                );
	}

	/**
	 * @todo Implement testViewallunitmodelsAction().
	 */
	public function testViewallunitmodelsAction() {
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
                'This test has not been implemented yet.'
                );
	}

	/**
	 * @todo Implement testViewallmodelrentscheduleAction().
	 */
	public function testViewallmodelrentscheduleAction() {
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
                'This test has not been implemented yet.'
                );
	}

	/**
	 * @todo Implement testViewallunitsAction().
	 */
	public function testViewallunitsAction() {
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
                'This test has not been implemented yet.'
                );
	}

	/**
	 * @todo Implement testViewapartmentAction().
	 */
	public function testViewapartmentAction() {
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
                'This test has not been implemented yet.'
                );
	}

	/**
	 * @todo Implement testViewleaseAction().
	 */
	public function testViewleaseAction() {
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
                'This test has not been implemented yet.'
                );
	}

	/**
	 * @todo Implement testViewleaselistAction().
	 */
	public function testViewleaselistAction() {
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
                'This test has not been implemented yet.'
                );
	}

	/**
	 * @todo Implement testViewmodelrentscheduleAction().
	 */
	public function testViewmodelrentscheduleAction() {
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
                'This test has not been implemented yet.'
                );
	}

	/**
	 * @todo Implement testViewunitAction().
	 */
	public function testViewunitAction() {
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
                'This test has not been implemented yet.'
                );
	}

	public function testUnitsforrentAction()
	{
		$this->markTestIncomplete('This test has not been implemented yet.');
		echo "Running ".__FUNCTION__.PHP_EOL;
		$this->login('jvazquez', 'Test1234');
		$this->dispatch('unit/view/unitsforrent/modelId/1');
		$this->assertQueryContentContains('h1','View Units',$this->getResponse()->getBody());
		$this->assertQueryContentContains('p','test',$this->getResponse()->getBody());
	}

	public function testViewunitgraphicsActionShowsErrorWithMissingId()
	{
		$this->markTestIncomplete('This test has not been implemented yet.');
		echo "Running ".__FUNCTION__.PHP_EOL;
		$this->login('jvazquez', 'Test1234');
		$this->dispatch('unit/view/show/id/6');
		$this->assertQueryContentContains('p','The given id is no longer valid',"Invalid response");
	}

	public function testViewUnitGraphicsShowsWrongParamShowsError()
	{
		$this->markTestIncomplete('This test has not been implemented yet.');
		echo "Running ".__FUNCTION__.PHP_EOL;
		$this->login('jvazquez', 'Test1234');
		$this->dispatch('unit/view/show/dunga/dunga/6');
		$this->assertQueryContentContains('p','The selected resource doesn\'t exists yet.Please,try again later or verify your URL information',"Invalid response");
	}

	public function testViewunitgraphicsActionShowsImageAndInfo()
	{
		$this->markTestSkipped("Fix ViewUnitPictures.xml dataset");
		echo "Running ".__FUNCTION__.PHP_EOL;
		$this->login('jvazquez', 'Test1234');
		$this->dispatch('unit/view/show/id/1');
		$this->assertQueryContentContains('p','test',$this->getResponse()->getBody());
		$this->assertQueryContentContains('p','test address',$this->getResponse()->getBody());
		$this->assertXpath("//image[@src='/images/uploads/1/3/3387-turf-houses.jpg']",'Failed to retrieve the image');
	}
}
?>