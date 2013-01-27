<?php
/**
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 *
 */
class User_Model_UserTest extends ControllerTestCase {
    /* (non-PHPdoc)
     * @see tests/application/ControllerTestCase::setUp()
     */
    
	public function setUp() {
        parent::setup();
    }

    /* (non-PHPdoc)
     * @see tests/application/ControllerTestCase::tearDown()
     */
    public function tearDown() {
        parent::tearDown();
    }

    public function testConstructSetsAttributes()
    {
    	
        $args = array(
                'firstName' => 'firstname',
                'lastName' => 'lastname',
                'emailAddress' => 'example@example.com',
                'username' => 'username',
                'password' => 'Test1234'
        );
        $user = new User_Model_User($args);
        $this->assertEquals('firstname',$user->getFirstName(),$user->getFirstName());
        $this->assertEquals('lastname',$user->getLastName());
        $this->assertEquals('example@example.com',$user->getEmailAddress());
        $this->assertEquals('username',$user->getUsername());
        $this->assertEquals('Test1234',$user->getPassword());
    }
}