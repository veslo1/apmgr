<?php
/**
 * Test class for Email_Context.
 * Generated by PHPUnit on 2011-01-11 at 20:16:29.
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @package tests.application.library.email
 */
class Email_ContextTest extends ControllerTestCase
{
	public function setUp()
    {
    	parent::setUp();
    }

    public function tearDown()
    {
    	parent::tearDown();
    }
    
    public function testDeliverEmail()
    {
    	$mail = new ZFEmail_Html();
    	$context = new ZFEmail_Context(APPLICATION_FAKEMAILS.DIRECTORY_SEPARATOR.'testmail.eml');
    	$args = array('nameFrom'=>'Jorge Vazquez','from'=>'jorgeomar.vazquez@gmail.com','nameTo'=>'Ck LOL','to'=>'bigheadmutant@lolsmart.com','subject'=>'lol wing your code','body'=>'~@andiheartheloltrain@~');
    	$result = $context->send($mail->build($args));
    }
}
?>
