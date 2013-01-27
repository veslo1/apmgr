<?php

class Role_Model_RolePermissionsTest extends ControllerTestCase {

	/**
	 * (non-PHPdoc)
	 * @see tests/application/ControllerTestCase#setUp()
	 */
	public function setUp() {
		parent::setUp();
		$this->db->query('DELETE FROM rolePermission WHERE roleId=2 AND permissionId=1');
	}

	/**
	 * (non-PHPdoc)
	 * @see tests/application/ControllerTestCase#tearDown()
	 */
	public function tearDown() {
		parent::tearDown();
	}


	public function testFetchRoleByPermissionId()
	{
		
		$rolePermission = new Role_Model_RolePermissions();
		$rolePermission->setPermissionId(1);
		$result = $rolePermission->fetchRoleByPermissionId();
		$this->assertEquals(1, count($result));

	}

	public function testSaveWillPass()
	{
		
		$data = array('roleId'=>2,'permissionId'=>1);
		$rolePermission = new Role_Model_RolePermissions($data);
		$saved = $rolePermission->save();
		$this->assertTrue($saved!=false,'We expected an int');
	}

	public function testSaveWillFailOnDuplicateRecord()
	{
		
		$data = array('roleId'=>2,'permissionId'=>1);
		$rolePermission = new Role_Model_RolePermissions($data);
		$saved = $rolePermission->save();
		$this->assertTrue($saved!=false,'We expected an int');
		$data = array('roleId'=>1,'permissionId'=>1);
		$rolePermission = new Role_Model_RolePermissions($data);
		$saved = $rolePermission->save();
		$this->assertFalse($saved,'The operation save should have failed');
	}

	public function testDeleteWillPass()
	{
		
		$data = array('roleId'=>2,'permissionId'=>1);
		$rolePermission = new Role_Model_RolePermissions($data);
		$saved = $rolePermission->save();
		$this->assertTrue($saved!=false,'We expected an int');
		$result = $rolePermission->delete(array('field'=>'id','value'=>$saved));
		$this->assertTrue($saved!=false,'We expected an int');
	}

	public function testFechAllRoleAccess()
	{
		
		$data = array('roleId'=>1,'permissionId'=>1);
		$rolePermission = new Role_Model_RolePermissions($data);
		$saved = $rolePermission->save();
		$rolePermission = new Role_Model_RolePermissions();
		$result = $rolePermission->fetchAllRoleAccess();
		$this->assertTrue(empty($result)==false);
	}
}
?>
