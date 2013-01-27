<?php
/**
 * Test class for Messages_CreateController.
 * Generated by PHPUnit on 2010-07-28 at 20:59:51.
 */
class Messages_CreateControllerTest extends ControllerTestCase {
    /**
     * @var Messages_CreateController
     */
    protected $object;

    /* (non-PHPdoc)
     * @see tests/application/ControllerTestCase::setUp()
     */
    public function setUp()
    {
        parent::setUp();
        $this->dataSetStackBuffer = array('users'=>1);
		$this->loadDataSets();
    }


    /* (non-PHPdoc)
     * @see ControllerTestCase::tearDown()
     */
    public function tearDown()
    {
    	$this->unLoadDataSets();
    	parent::tearDown();
    	$this->db->query("DELETE FROM messages WHERE identifier='testMessage'");
    }

    public function testIndexActionBasicForm()
    {
    	echo "Running ".__FUNCTION__.PHP_EOL;
        $this->login('jvazquez', 'Test1234');
        $this->dispatch('messages/create');
        $this->assertQueryCount('form', 1);
        $this->assertXpath("//input[@id='identifier']");
        $this->assertXpath("//select[@id='category']");
        $this->assertXpath("//input[@id='locked']");
        $this->assertXpath("//textarea[@id='message']");
        $this->assertXpath("//input[@id='submit']");
    }

    public function testCreateRedirects()
    {
    	echo "Running ".__FUNCTION__.PHP_EOL;
        $this->login('jvazquez', 'Test1234');
        $this->request->setMethod('POST')
                      ->setPost(array('identifier' => 'testMessage','category'=>'error','locked'=>0,'message'=>'this is a test'));
        $this->dispatch('messages/create');
        $this->assertRedirect();
    }

    public function testCreateWithWrongDataShowsErrorMessage()
    {
    	echo "Running ".__FUNCTION__.PHP_EOL;
        $this->login('jvazquez', 'Test1234');
        $this->request->setMethod('POST')
                      ->setPost(array('identifier' => '','category'=>'error','locked'=>0,'message'=>'this is a test'));
        $this->dispatch('messages/create');
        $this->assertQueryContentContains('li','Value is required and can\'t be empty','The error message is not present on the form');
    }
}
?>
