<?php
/**
 * Created on August 14, 2010 by rnelson
 *
 * // phpunit --no-configuration --bootstrap application/bootstrap.php application/modules/financial/models/Financial_Model_FinancialAccountSettingTest.php
// mysqldump -udev -pdev --opt --complete-insert --add-drop-table apmgr | mysql -udev -pdev -C apmgr_tests -h localhost
 */
class Financial_Model_FinancialAccountSettingTest extends ControllerTestCase {

    protected $object;
    /**
     * (non-PHPdoc)
     * @see tests/application/ControllerTestCase#setUp()
     */
    public function setUp() {
        parent::setUp();
        $this->loadData();
        $this->object = new Financial_Model_FinancialAccountSetting();
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

    public function testGetSettingName()
    {
    	
        $var = 'test';
        $this->object->setSettingName($var);
        $this->assertEquals($var,$this->object->getSettingName());
    }

   public function testGetAccountId()
   {
   		
        $var = 1;
        $this->object->setAccountId($var);
        $this->assertEquals($var,$this->object->getAccountId());
    }

    public function testGetDescription()
    {
    	
        $var = 'testDesc';
        $this->object->setDescription($var);
        $this->assertEquals($var,$this->object->getDescription());
    }

    public function testGetAccount()
    {
    	
        //$this->dSet->loadDataSet(APPLICATION_FAKESETS.'/accountsAndLinks.xml');
        $var = 1;
        $name = 'account1';
        $this->object->setAccountId($var);
        $this->assertEquals($name,$this->object->getAccount()->getName());
    }
    
    private function loadData(){
	$this->dataSetStackBuffer = array( 'accountsAndLinks'=>1 );	
	$this->loadDataSets();        
    }
}