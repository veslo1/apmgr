<?php
/**
 * Test class for User_IndexController.
 * Generated by PHPUnit on 2011-01-09 at 19:14:20.
 */
class User_IndexControllerTest extends ControllerTestCase
{
    /* (non-PHPdoc)
     * @see Framework/PHPUnit_Framework_TestCase::setUp()
     */
    public function setUp()
    {
    	parent::setUp();
    	$this->dataSetStackBuffer = array('users'=>1);
    	$this->loadDataSets();
    }

    /* (non-PHPdoc)
     * @see Framework/PHPUnit_Framework_TestCase::tearDown()
     */
    public function tearDown()
    {
    	$this->unLoadDataSets();
    	parent::tearDown();
    }

    public function testIndexAction()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }
    
    public function testForgotpasswordAction()
    {
    	$postArgs = array('emailAddress'=>'','username'=>'');
		$this->request->setMethod('POST')->setPost($postArgs);
    	$this->dispatch('user/index/forgotpassword');
    	$this->assertQueryContentContains('li',"Value is required and can't be empty");
/**
 * Still dont' know how to test captcha or if it's even possible    	
    	$postArgs = array('emailAddress'=>'lexandchrisrocks@loosers.net','username'=>'ckunt');
		$this->request->setMethod('POST')->setPost($postArgs);
    	$this->dispatch('user/index/forgotpassword');
*/
    }
    
    public function testForgotusernameAction()
    {
    	$postArgs = array('emailAddress'=>'');
		$this->request->setMethod('POST')->setPost($postArgs);
    	$this->dispatch('user/index/forgotusername');
    	$this->assertQueryContentContains('li',"Value is required and can't be empty");
    	$this->resetRequest()->resetResponse();
    	$postArgs = array('emailAddress'=>'tardchitect@sucksdonkeyass.com');
		$this->request->setMethod('POST')->setPost($postArgs);
    	$this->dispatch('user/index/forgotusername');
    	$response = $this->getResponse()->getBody();
    	$this->assertTrue( preg_match("/The given email wasn't found\./",$response)==1);
    }

    public function testForgotinfoAction()
    {
    	$this->dispatch('user/index/forgotinfo');
    	$this->assertQueryContentContains('a', "Forgot your password?",'Missing the forgot password link');
    	$this->assertQueryContentContains('a', "Forgot your username?",'Missing the forgot username link');
    	$this->assertQueryContentContains('p', 'In this page , you will find the links to recover your username or password.','Missing the explanation of the page');
    }

    /**
     * @todo Implement testInfoAction().
     */
    public function testInfoAction()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }
}
?>