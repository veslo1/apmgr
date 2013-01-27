<?php
/**
 * @author jvazquez
 *
 */
class Role_Model_RoleTest extends ControllerTestCase {

    protected $role;

    protected $curdate;

    public function setUp() {
        parent::setUp();
        $this->role = new Role_Model_Role();
        $this->curdate = date('Y-m-d');
    }

    public function tearDown() {
        //	Clear all the trash we created
        parent::tearDown();
        $this->db->query('DELETE FROM role WHERE id>8');
    }

    public function testInstantiateWithParametersWillReturnSameResults()
    {
    	
        $data = array('id'=>1,'name'=>'specialadmin','protected'=>1,'dateCreated'=>$this->curdate,'dateUpdated'=>$this->curdate );
        $role = new Role_Model_Role($data);
        $this->assertEquals($role->getId(),$data['id']);
        $this->assertEquals($role->getName(),$data['name']);
        $this->assertEquals($role->getProtected(),$data['protected']);
        $this->assertEquals($role->getDateCreated(),$data['dateCreated']);
        $this->assertEquals($role->getDateUpdated(),$data['dateUpdated']);
    }

    /**
     * This method guarantees that the basic roles are on the system.
     * @return unknown_type
     */
    public function testFecthAllWillReturnBasicRoles()
    {
    	
        $this->assertTrue(count($this->role->fetchAll())>3,'We expected three roles, we have ('.count($this->role->fetchAll()).')');
        $stub = $this->getMock('Role_Model_Role',array('fetchAll'));
    }

    public function testSaveWillReturnNotFalse()
    {
    	
        $data = array('name'=>'specialadmin','protected'=>0);
        $role = new Role_Model_Role($data);
        $result = $role->save();
        $this->assertTrue($result!=false,'The save method in role, failed');
    }

    public function testSaveUpdateWillReturnTrue()
    {
    	
        $data = array('name'=>'specialadmin','protected'=>0);
        $role = new Role_Model_Role($data);
        $id = $role->save();
        $newRole = $role->findById($id);
        $newRole->setName('New Name');
        $updated = $newRole->save();
        $this->assertType('numeric',$updated,'The update operation failed while trying to update a record');
        $this->assertTrue($updated!=false);
    }

    public function testfindByIdWillReturnNull()
    {
    	
        $role = $this->role->findById('a');
        $this->assertNull($role,'We expected a false result');
    }

    public function testDeleteProctedRoleWillReturnFalse()
    {
    	
        //$result = $this->role->delete(1);
        $data = array('name'=>'specialadmin','protected'=>1);
        $role = new Role_Model_Role($data);
        $id = $role->save();
        $result = $this->role->delete($id);
        $this->assertFalse($result,'A protected role was deleted');
    }

    public function testDeleteUnprotectedRoleWillReturnTrue()
    {
    	
        $data = array('name'=>'specialadmin','protected'=>0);
        $role = new Role_Model_Role($data);
        $this->assertTrue($role->getProtected()==0,'The setter failed');
        $id = $role->save();
        $result = $this->role->delete($id);
        $this->assertTrue($result==1,'An unprotected role couldn\'t be deleted');
    }
}