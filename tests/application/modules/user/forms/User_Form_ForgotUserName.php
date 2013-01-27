<?php
/**
 * Test for form User_Forms_ForgotUserName
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @package tests.application.modules.user.forms
 */
class User_IndexControllerTest extends ControllerTestCase
{
	/* (non-PHPdoc)
	 * @see tests/application/ControllerTestCase::setUp()
	 */
	public function setUp()
	{
		parent::setUp();
	}
	
	/* (non-PHPdoc)
	 * @see tests/application/ControllerTestCase::tearDown()
	 */
	public function tearDown()
	{
		parent::tearDown();
	}
	
	public function testHasEmail()
	{
		$form = new User_Form_ForgotUserName();
		$form->setForm();
		$this->assertTrue( $form->getElement('emailAddress')!=null , 'We require an input that says email' );
		$this->assertFalse( $form->getElement('emailAddress')->isValid(null) ,'The email validator should reject a null email');
		$this->assertTrue($form->getElement('emailAddress')->isValid('myemail@gmail.com'),'The email validator should accpet the email myemail@gmail.com');
	}
}