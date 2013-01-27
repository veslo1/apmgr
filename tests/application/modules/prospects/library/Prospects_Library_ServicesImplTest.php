<?php
/**
 * Test class for Prospects_Library_ServicesImpl.
 * Generated by PHPUnit on 2011-02-13 at 16:13:30.
 */
class Prospects_Library_ServicesImplTest extends ControllerTestCase
{
	/**
	 * (non-PHPdoc)
	 * @see Framework/PHPUnit_Framework_TestCase::setUp()
	 */
    public function setUp()
    {
    	parent::setUp();
    }

    /**
     * (non-PHPdoc)
     * @see Framework/PHPUnit_Framework_TestCase::tearDown()
     */
    public function tearDown()
    {
    	parent::tearDown();
    }
    
    public function testSaveTransaction()
    {
    	$args = array(
    			'firstName'=>'Test','lastName'=>'user','email'=>'test@email.com',
    			'contactMode'=>1,'howDidYouHear'=>1,'rentRange'=>800,'modelType'=>array(1),
    			'possibleMoveInDate'=>'2011-05-01','pets'=>1,'occupants'=>0,
    			'notes'=>null,'status'=>1,'phone'=>'3255555555'
    	);
    	$dao = $this->getMock('Prospects_Library_Dao', array('saveTransaction') );
    	$dao->expects($this->once())
    		->method('saveTransaction')
    		->will($this->returnValue(true));
    	$service = new Prospects_Library_ServiceImpl();
    	$service->setDao($dao);
    	$this->assertTrue($service->saveTransaction($args)!=false,'We did not expect a false return');
    }

    public function testFetchAll()
    {
    	$args = array(
    			'id'=>1,'firstName'=>'Test','lastName'=>'user','email'=>'test@email.com',
    			'contactMode'=>1,'howDidYouHear'=>1,'rentRange'=>800,'modelType'=>1,
    			'possibleMoveIntDate'=>'2011-05-01','pets'=>1,'occupants'=>0,
    			'notes'=>null,'status'=>1 , 'dateCreated'=>'2010-12-01 10:00:00'
    	);
    	$secondArgs = array('id'=>2,'firstName'=>'Auser','lastName'=>'LastnameUser','email'=>'test@email.com',
    			'contactMode'=>1,'howDidYouHear'=>1,'rentRange'=>800,'modelType'=>1,
    			'possibleMoveIntDate'=>'2011-05-01','pets'=>1,'occupants'=>0,
    			'notes'=>null,'status'=>1,'dateCreated'=>'2011-01-05 10:00:00'
    	);
		$row = new Zend_Db_Table_Row(array('data'=>array( $args ,$secondArgs) ) );
		$dao = $this->getMock('Prospects_Library_Dao' , array('fetchAll') );
		$dao->expects($this->once())
			->method('fetchAll')
			->will($this->returnValue($row));
		$service = new Prospects_Library_ServiceImpl();
		$service->setDao($dao);
		$list = $service->fetchAll();
		$this->assertInternalType('array' ,$list ,'We expect a result of type array');
		$this->assertTrue( count($list)>0,'We expect to have more than one result' );
    }
    
    public function testGetForm()
    {
    	$args = array(
    			'id'=>1,'name'=>'testModelFake','dateCreated'=>'2011-01-01 10:00:00','size'=>200,
    			'numBeds'=>1,'numBaths'=>1,'numFloors'=>1
    	);
    	$secondArgs = array('id'=>1,'name'=>'testModelFake','dateCreated'=>'2011-01-01 10:00:00','size'=>200,
    			'numBeds'=>1,'numBaths'=>1,'numFloors'=>1
    	);
		$row = new Zend_Db_Table_Row(array('data'=>array( $args ,$secondArgs) ) );
    	$dao = $this->getMock('Unit_Library_Impl_Dao',array('setTemplate','fetchAll'),array(new Unit_Model_DbTable_UnitModel()));
    	$dao->expects($this->once())
    		->method('fetchAll')
    		->will($this->returnValue($row));
    	$service = new Prospects_Library_ServiceImpl();
    	$args = array('name'=>'Prospects_Form_Add','set'=>true,'dao'=>$dao);
    	$form = $service->getForm($args);
    	$this->assertInstanceOf('Zend_Form', $form,'We expect an object of the type Zend_Form');
    }
    
    /**
     * 
     * @expectedException Exception
     */
    public function testPrepareSave()
    {
    	$args = array(
    			'firstName'=>'Test','lastName'=>'user','email'=>'test@email.com',
    			'contactMode'=>1,'howDidYouHear'=>1,'rentRange'=>800,
    			'possibleMoveIntDate'=>'2011-05-01','pets'=>1,'occupants'=>0,
    			'notes'=>null,'status'=>1
    	);
    	$service = new Prospects_Library_ServiceImpl();
    	$service->prepareSave($args);
    }
/*    
     * @todo Implement testUpdate().
    public function testUpdate()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

     * @todo Implement testDelete().
    public function testDelete()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

     * @todo Implement testFindById().
    public function testFindById()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }
    */
    public function testViewAllProspects()
    {
    	$service = new Prospects_Library_ServiceImpl();
    	$sort = $this->getMock('ZFDb_SortHelper',array('isSorting','prepareOrderQuery','setValidColumns')); 
		$sort->expects($this->once())
			 ->method('isSorting')
			 ->will($this->returnValue(true));
		$sort->expects($this->once())
			->method('prepareOrderQuery')
			->will($this->returnValue('firstName ASC'));
		$args = array(
    			'id'=>1,'firstName'=>'Test','lastName'=>'user','email'=>'test@email.com',
    			'contactMode'=>1,'howDidYouHear'=>1,'rentRange'=>800,'modelType'=>1,
    			'possibleMoveIntDate'=>'2011-05-01','pets'=>1,'occupants'=>0,
    			'notes'=>null,'status'=>1 , 'dateCreated'=>'2010-12-01 10:00:00'
    	);
    	$secondArgs = array('id'=>2,'firstName'=>'Auser','lastName'=>'LastnameUser','email'=>'test@email.com',
    			'contactMode'=>1,'howDidYouHear'=>1,'rentRange'=>800,'modelType'=>1,
    			'possibleMoveIntDate'=>'2011-05-01','pets'=>1,'occupants'=>0,
    			'notes'=>null,'status'=>1,'dateCreated'=>'2011-01-05 10:00:00'
    	);
		$row = new Zend_Db_Table_Row(array('data'=>array( $args ,$secondArgs) ) );
		$dao = $this->getMock('Prospects_Library_Dao' , array('fetchAll') );
		$dao->expects($this->once())
			->method('fetchAll')
			->with($this->equalTo(null),$this->equalTo('firstName ASC'),$this->equalTo(null),$this->equalTo(null))
			->will($this->returnValue($row));
		$service->setDao($dao);
		$service->setSortHelper($sort);
		$service->viewAllProspects(array(ZFDb_SortHelper::MODE=>ZFDb_SortHelper::ASCVIEW,ZFDb_SortHelper::COLUMN=>'firstName'));
    }
    
    public function testViewProspectId()
    {
    	$service = new Prospects_Library_ServiceImpl();
    	$args = array(
    			'firstName'=>'Test','lastName'=>'user','email'=>'test@email.com',
    			'contactMode'=>1,'howDidYouHear'=>1,'rentRange'=>800,
    			'possibleMoveInDate'=>'2011-05-01','pets'=>1,'occupants'=>0,
    			'notes'=>null,'status'=>1,'phone'=>'3255555555'
    	);
    	$unitModelRow = new Zend_Db_Table_Row( array('data'=>array('id'=>1,'name'=>'Ph','dateCreated'=>date('Y-m-d H:i:s'),'size'=>200,'numBeds'=>2,'numBaths'=>1,'numFloors'=>1) ) ) ;
    	$answerRow = new Zend_Db_Table_Row( array('data'=>array( array('unitModelId'=>1,'prospectId'=>1,'id'=>1),array('unitModelId'=>2,'prospectId'=>1,'id'=>2) ) ));
    	$daoRow = new Zend_Db_Table_Row(array('data'=>$args));
    	$dao = $this->getMock('Prospects_Library_Dao',array('findById'));
    	$dao->expects($this->once())
    		->method('findById')
    		->with($this->equalTo(1))
    		->will($this->returnValue($daoRow));
    	$answerDao = $this->getMock('Prospects_Library_ProspectAnswersDao',array('fetchAll'));
    	$answerDao->expects($this->once())
    			  ->method('fetchAll')
    			  ->with($this->equalTo('prospectId=1'))
    			  ->will($this->returnValue($answerRow));
    	$unitModelDao = $this->getMock('Unit_Library_UnitModelDao',array('findById'));
    	$unitModelDao->expects($this->any())
    				 ->method('findById')
    				 ->will($this->returnValue($unitModelRow));
    	$service->setDao($dao);
    	$service->setProspectAnswersDao($answerDao);
    	$service->setUnitModelDao($unitModelDao);
    	$result = $service->viewProspectId(1);
    	$this->assertInternalType('array',$result);
    }
}
?>