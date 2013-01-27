<?php
// phpunit --no-configuration --bootstrap application/bootstrap.php application/modules/financial/models/Financial_Model_PaymentCreationTest.php
// mysqldump -udev -pdev --opt --complete-insert --add-drop-table apmgr | mysql -udev -pdev -C apmgr_tests -h localhost
class Financial_Model_PaymentCreationTest extends ControllerTestCase {

    protected $object;
    /**
     * (non-PHPdoc)
     * @see tests/application/ControllerTestCase#setUp()
     */
    public function setUp() {
        parent::setUp();
        $this->loadData();
	$this->login('jvazquez', 'Test1234'); // sets the userId in the session
        $this->object = new Financial_Model_PaymentCreation();
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

    public function testGetAccountLink()
    {
    	
        $accountLinkObj = new Financial_Model_AccountLink();
        $link = $accountLinkObj->findById(1);

        $this->object->setAccountLink( $link );
        $this->assertEquals( $link,$this->object->getAccountLink());
    }

    public function testReuseDetailId()
    {
    	
        $value = true;
        $this->object->setReuseDetailId( $value );
        $this->assertEquals( $value,$this->object->getReuseDetailId());
    }

    public function testPostPaymentSuccess()
    {
    	
      //  $this->loadPaymentData();

        $row = array( 'BillId'=>1,
		      'PaymentType'=>'check',
		      'AmountPaid'=>100.00,
		      'Payor'=>'Johnny Johnson'
                     );

	$alModel = new Financial_Model_AccountLink();
	$accountLink = $alModel->findByKey( array('search'=>array( 'name'=>'paidRent' )) );

        $this->object->setAmountPaid( $row['AmountPaid'] );
	$this->object->setBillId( $row['BillId'] );
	$this->object->setPaymentType( $row['PaymentType'] );
	$this->object->setTotalAmount( $row['AmountPaid'] );
	$this->object->setPayor( $row['Payor'] );
	$this->object->setAccountLink( array_shift($accountLink) );

        $result = $this->object->postPayment();

	$billObj = new Financial_Model_Bill();
	$billItem = $billObj->findById( $row['BillId'] );

	$pmtObj = new Financial_Model_Payment();
	$pmtItem = array_shift($pmtObj->findByKey( array('search'=>array( 'billId'=>$row['BillId'] ) ) ));

        // pmt item
        $pmtDetailId = $pmtItem->getPaymentDetailId();

        $pmtDetailObj = new Financial_Model_PaymentDetail();
	$pmtDetailItem = $pmtDetailObj->findById( $pmtDetailId );

        $acctTransObj = new Financial_Model_AccountTransaction();
	$acctTransItems = $acctTransObj->findByKey( array('search'=>array( 'transactionId'=>$pmtItem->getTransactionId() )));

	$this->assertEquals( true, $result);
	$this->assertEquals( 1, $billItem->getIsPaid());
        $this->assertEquals( $row['BillId'] , $pmtItem->getBillId());
        $this->assertEquals( $row['AmountPaid'] , $pmtItem->getAmtPaid());
        $this->assertEquals( $row['AmountPaid'] , $pmtDetailItem->getTotalAmount());
        $this->assertEquals( $row['PaymentType'] , $pmtDetailItem->getPaymentType());
        $this->assertEquals( $row['Payor'] , $pmtDetailItem->getPayor());
	$this->assertEquals( $pmtItem->getTransactionId() , $acctTransItems[0]->getTransactionId());
	$this->assertEquals( $row['AmountPaid'] , $acctTransItems[0]->getAmount());
    }

    public function testPostPaymentReuseDetailIdTrue(){
    //    $this->loadPaymentData();

        $row = array( 'BillId'=>1,
		      'PaymentType'=>'check',
		      'AmountPaid'=>100.00,
		      'Payor'=>'Johnny Johnson'
                     );
	$row2 = array( 'BillId'=>2,
		      'PaymentType'=>'check',
		      'AmountPaid'=>100.00,
		      'Payor'=>'Johnny Johnson'
                     );
	$row3 = array( 'BillId'=>3,
		      'PaymentType'=>'check',
		      'AmountPaid'=>50.00,
		      'Payor'=>'Johnny Johnson'
                     );

	$alModel = new Financial_Model_AccountLink();
	$accountLink = $alModel->findByKey( array('search'=>array( 'name'=>'paidRent' )) );

        $this->object->setAmountPaid( $row['AmountPaid'] );
	$this->object->setBillId( $row['BillId'] );
	$this->object->setPaymentType( $row['PaymentType'] );
	$this->object->setTotalAmount( $row['AmountPaid'] );
	$this->object->setPayor( $row['Payor'] );
	$this->object->setAccountLink( array_shift($accountLink) );
	$this->object->setReuseDetailId( true );

        $result = $this->object->postPayment();

	$this->object->setAmountPaid( $row2['AmountPaid'] );
	$this->object->setBillId( $row2['BillId'] );
	$this->object->setPaymentType( $row2['PaymentType'] );
	$this->object->setTotalAmount( $row2['AmountPaid'] );
	$this->object->setPayor( $row2['Payor'] );

	// test
	$result2 = $this->object->postPayment();

	$this->object->setAmountPaid( $row3['AmountPaid'] );
	$this->object->setBillId( $row3['BillId'] );
	$this->object->setPaymentType( $row3['PaymentType'] );
	$this->object->setTotalAmount( $row3['AmountPaid'] );
	$this->object->setPayor( $row3['Payor'] );
	$this->object->setReuseDetailId( false );

	$result3 = $this->object->postPayment();

	$pmtObj = new Financial_Model_Payment();
	$pmtItem = array_shift($pmtObj->findByKey( array('search'=>array( 'billId'=>$row['BillId'] ) ) ));
	$pmtItem2 = array_shift($pmtObj->findByKey( array('search'=>array( 'billId'=>$row2['BillId'] ) ) ));
	$pmtItem3 = array_shift($pmtObj->findByKey( array('search'=>array( 'billId'=>$row3['BillId'] ) ) ));

	$this->assertEquals( true, $result);
	$this->assertEquals( true, $result2);
	$this->assertEquals( $pmtItem->getPaymentDetailId(), $pmtItem2->getPaymentDetailId());
	$this->assertNotEquals( $pmtItem->getPaymentDetailId(), $pmtItem3->getPaymentDetailId());
    }
    
    private function loadData(){
	$this->dataSetStackBuffer = array( 'users'=>1,
					  'accountsAndLinks'=>1,
					  'depositsAndFees'=>1,
					  'apartmentsUnitsAndModels'=>1,
					  'bills'=>1,
					  );	
	$this->loadDataSets();        	
    } 
    
}
