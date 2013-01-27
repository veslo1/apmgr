<?php
//phpunit --no-configuration --bootstrap application/bootstrap.php application/modules/financial/models/Financial_Model_BulkRentPaymentTest.php
// mysqldump -udev -pdev --opt --complete-insert --add-drop-table apmgr | mysql -udev -pdev -C apmgr_tests -h localhost
class Financial_Model_BulkRentPaymentTest extends ControllerTestCase {

    protected $object;
    /**
     * (non-PHPdoc)
     * @see tests/application/ControllerTestCase#setUp()
     */
    public function setUp() {
        parent::setUp();
	$this->loadData();
	$this->login('jvazquez', 'Test1234'); // sets the userId in the session
        $this->object = new Financial_Model_BulkRentPayment();
    }

    /**
     * (non-PHPdoc)
     * @see tests/application/ControllerTestCase#tearDown()
     */
    public function tearDown()
    {
	$this->unLoadDataSets();
    	parent::tearDown();
    }

    public function testSetUploadFile()
    {
    	
        $file = APPLICATION_CSVUPLOADS.'/testPayment.csv';
        $this->object->setUploadFile( $file );
        $this->assertEquals( $file, $this->object->getUploadFile() );
    }

    /**
     *  Tests that each validation fails properly
     */
    public function testUploadRentPaymentsFailValidation()
    {
    	
        $file = APPLICATION_CSVUPLOADS.'/testPaymentFail.csv';
        $this->object->setUploadFile( $file );
        $result = $this->object->uploadRentPayments();
        $this->assertEquals( false, $result );
        $this->assertEquals( 7, count($this->object->getErrors()) ); //first 8 non header rows have errors (one for each column)
    }

     /**
     *  Test the db validation portion of the bulk upload.  This one will test the Success case
     **/
    public function testUploadRentPaymentsDBSuccessRecord()
    {
    	
        $file = APPLICATION_CSVUPLOADS.'/testPaymentDBSuccess.csv';
        $this->object->setUploadFile( $file );       
        $result = $this->object->uploadRentPayments();	
        $this->assertEquals( true, $result );
    }

    /**
     *  TODO: Create this test file and verify that the test fails db validation.  Will need a few different checks here.
     *  */
    /*
    public function testUploadRentPaymentsDBFailRecord() {
        $file = APPLICATION_CSVUPLOADS.'/testPayment.csv';
        $this->object->setUploadFile( $file );
        $result = $this->object->uploadRentPayments();
        $this->assertEquals( false, $result );
    }
    */
    public function testUploadedFileFailsWhenUploadedFileIsFake()
    {
    	
    	$file = NULL;
        $this->object->setUploadFile($file);
        $this->assertFalse($this->object->isValid(),'We expected a false result');
    }
    
    private function loadData(){
	$this->dataSetStackBuffer = array('users'=>1, 
					  'accountsAndLinks'=>1,
					  'depositsAndFees'=>1,
					  'apartmentsUnitsAndModels'=>1,
					  'bills'=>1,
					  'leases'=>1,
					  );	
	$this->loadDataSets();        
    }    

}