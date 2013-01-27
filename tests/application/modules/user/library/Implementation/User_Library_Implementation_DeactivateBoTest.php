<?php
/**
 * test for the DeactivateBo implementation
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @package tests.user.library.implementation
 */
class User_Library_Implementation_DeactivateBoTest extends ControllerTestCase
{
	/**
	 * (non-PHPdoc)
	 * @see tests/application/ControllerTestCase::setUp()
	 */
	public function setUp()
	{
		parent::setUp();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see tests/application/ControllerTestCase::tearDown()
	 */
	public function tearDown()
	{
		parent::tearDown();
	}
	
	public function testSave()
	{
		$args = array('userId'=>2,'author'=>1,'description'=>'Testing disable users');
		$impl = new User_Library_Implementation_DeactivateBo();
		$dao = $this->getMock('User_Library_Implementation_DeactivateDao', array('save'), array($args) );
		$dao->expects($this->any())->method('save')->will($this->returnValue(true));
		$userDao = $this->getMock('User_Library_Implementation_Dao',array('exists'),array(2));
		$userDao->expects($this->any())
				->method('exists')
				->with($this->equalTo(array('table'=>'user','column'=>'id'), 2,2))
				->will($this->returnValue(true));
				
		$impl->setDao($dao);
		$impl->setUserDao($userDao);
		$save=$impl->save($args);
		$msg = $impl->getMessageState();
		$this->assertTrue( $save , 'We expect a true result after a save operation.'.$msg['msg']);
		
		unset($userDao);
		unset($dao);
		
		$userDao = $this->getMock('User_Library_Implementation_Dao',array('exists'),array(1));
		$userDao->expects($this->any())
				->method('exists')
				->with($this->equalTo(array('table'=>'userDeactivations','column'=>'id'), 1,1))
				->will($this->returnValue(false));
		$impl->setUserDao($userDao);
		$this->assertFalse( $impl->save($args) , 'We expect a false result for a fake id');
		$this->assertEquals(array('msg'=>'userIdMissing','type'=>'error'), $impl->getMessageState());
		
		unset($userDao);
		unset($dao);
		unset($args);
		
		$args = array('description'=>'Because i say so');
		$this->assertFalse($impl->save($args),'We expect a false result because the id is missing');
		$this->assertEquals(array('msg'=>'userIdMissing','type'=>'error'), $impl->getMessageState());
	}
	
	public function testIsValid()
	{
		$impl = new User_Library_Implementation_DeactivateBo();
		$userDao = $this->getMock('User_Library_Implementation_Dao',array('exists'),array(1));
		$userDao->expects($this->once())
				->method('exists')
				->with($this->equalTo(array('table'=>'userDeactivations','column'=>'id'), 1,1))
				->will($this->returnValue(true));
		$impl->setUserDao($userDao);
		$this->assertTrue($impl->isValid(1),'We expect a valid result');
	}
	
	public function testValidate()
	{
		$impl = new User_Library_Implementation_DeactivateBo();
		$args = array('userId'=>1,'author'=>1,'description'=>'Because i do');
		$userDao = $this->getMock('User_Library_Implementation_Dao',array('exists'),array(1));
		$userDao->expects($this->any())
				->method('exists')
				->with($this->equalTo(array('table'=>'userDeactivations','column'=>'id'), 1,1))
				->will($this->returnValue(true));
		$impl->setUserDao($userDao);
		$this->assertTrue( $impl->validateSave($args) , 'We expect a valid validate response' );
	}
}