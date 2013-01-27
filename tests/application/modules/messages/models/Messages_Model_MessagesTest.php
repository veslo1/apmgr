<?php
/**
 * We won't test much of the setters and getters, because
 * this is handled by the parent model, and testing in this
 * level of the hierarchy doesn't makes much sense
 */
class Messages_Model_MessagesTest extends ControllerTestCase {

	static $DFTMSG = 'unhandledMsg';

	/* (non-PHPdoc)
	 * @see ControllerTestCase::setUp()
	 */
	public function setUp() {
		parent::setUp();
		$this->curdate = date('Y-m-d');
	}

	/* (non-PHPdoc)
	 * @see ControllerTestCase::tearDown()
	 */
	public function tearDown()
	{
		parent::tearDown();
		$this->db->query("DELETE FROM messages WHERE identifier='doop'");
	}

	public function testFetchAll()
	{
		
		$messages = new Messages_Model_Messages();
		$result = $messages->fetchAll();
		$this->assertGreaterThan(1,$result,'We expected a default amount of messages');
	}

	public function testFetchAllWillReturnEmptyArray()
	{
		
		$stubMessage = $this->getMock('Messages_Model_Messages');
		$stubMessage->expects($this->any())
		->method('fetchAll')
		->will($this->returnValue(array()));
		$this->assertTrue(count($stubMessage->fetchAll())==0);
	}

	/**
	 * @expectedException Zend_Db_Statement_Exception
	 */
	public function testSaveWillFailWithNoMessage()
	{
		
		$message = new Messages_Model_Messages();
		$message->setIdentifier('doop');
		$message->setCategory('error');
		$message->setLanguage('es_AR');
		$result = $message->save();
		$this->assertFalse($result);
	}

	/**
	 * @expectedException Zend_Db_Statement_Exception
	 */
	public function testSaveWillFailWithNoIdentifier()
	{
		
		$message = new Messages_Model_Messages();
		$message->setCategory('error');
		$message->setLanguage('es');
		$result = $message->save();
		$this->assertFalse($result);
	}

	/**
	 * @expectedException Zend_Db_Statement_Exception
	 */
	public function testSaveWillFailWithNoCategory()
	{
		
		$message = new Messages_Model_Messages();
		$message->setLanguage('es');
		$result = $message->save();
		$this->assertFalse($result);
	}

	public function testSaveWillPass()
	{
		
		$message = new Messages_Model_Messages();
		$message->setIdentifier('doop');
		$message->setCategory('error');
		$message->setLanguage('es_AR');
		$message->setLocked(1);
		$message->setMessage('test');
		$result = $message->save();
		$this->db->query("DELETE FROM messages WHERE identifier='doop'");
		$this->assertTrue($result!=false);
	}

	public function testUpdateWillPass()
	{
		
		$message = new Messages_Model_Messages();
		$message->setIdentifier('doop');
		$message->setCategory('error');
		$message->setLanguage('es_AR');
		$message->setMessage('test');
		$message->setLocked(1);
		$result = $message->save();
		$this->assertTrue($result!=false);
		$content = $message->findById($result);
		$content->setMessage('testTest');
		$result = $content->save();
		$this->db->query("DELETE FROM messages WHERE identifier='doop'");
		$this->assertTrue($result!=false);
	}

	public function testSetLockedWillReturnLocked()
	{
		
		$message = new Messages_Model_Messages();
		$message->setIdentifier('doop');
		$message->setCategory('error');
		$message->setLanguage('es_AR');
		$message->setMessage('test');
		$message->setLocked(1);
		$result = $message->save();
		$this->assertTrue($result!=false);
		$content = $message->findById($result);
		$this->assertTrue($content->getLocked()==1);
		$this->db->query("DELETE FROM messages WHERE identifier='doop'");
	}

	public function testDeleteMessageWillPass()
	{
		
		$message = new Messages_Model_Messages();
		$message->setIdentifier('doop');
		$message->setCategory('error');
		$message->setLanguage('es_AR');
		$message->setMessage('test');
		$message->setLocked(0);
		$result = $message->save();
		$this->assertTrue($result!=false);
		$content = $message->delete($result);
		$this->assertTrue($content!=false);
	}

	public function testDeleteFakeMessageWillReturnFalse()
	{
		
		$message = new Messages_Model_Messages();
		$content = $message->delete(null);
		$this->assertTrue($content==false);
	}

	public function testDeleteProtectedMessageWillFail()
	{
		
		$message = new Messages_Model_Messages();
		$message->setIdentifier('doop');
		$message->setCategory('error');
		$message->setLanguage('es_AR');
		$message->setMessage('test');
		$message->setLocked(1);
		$result = $message->save();
		$this->assertTrue($result!=false);
		$content = $message->delete($result);
		$this->assertFalse($content);
	}
	//TODO Test that we can't delete a protected message, and that we can't update the *locked* of a procted message
}
