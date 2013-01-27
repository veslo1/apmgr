<?php
/**
 * Created on June 5, 2010 by rnelson
 * @name apmgr
 * @package application.modules.financial.models
 * <p>
 * Model for bulk rent payment
 * </p>
 */
defined('APPLICATION_CSVUPLOADS') || define('APPLICATION_CSVUPLOADS',APPLICATION_PATH.'/../public/uploads');

class Financial_Model_BulkRentPayment extends ZFModel_ParentModel {

	/**
	 *@var paymentDetailId
	 */
	protected $uploadFile;

	protected $data;  // unvalidated data loaded from csv

	protected $errors;

	private $uniqueArray;

	private $processArray;  // array for inserting into payments

	private $unprocessedArray;  // array holding rows that weren't processed

	/**
	 * Constructor of this object
	 */
	public function __construct(array $options = null) {
		//parent::__construct( $options );
		//$this->setDbTable('Financial_Model_DbTable_Payment');
	}

	/**
	 * uploadFile
	 */
	public function setUploadFile( $var ) {
		$this->uploadFile = $var;
	}

	public function getUploadFile() {
		return $this->uploadFile;
	}

	/**
	 * data
	 */
	private function setData( $var ) {
		$this->data = $var;
	}

	private function getData() {
		return $this->data;
	}

	/**
	 * errors
	 */
	public function setErrors( $var ) {
		$this->errors = $var;
	}

	public function getErrors() {
		return $this->errors;
	}

	/**
	 * final array to process
	 */
	public function setProcessArray( $var ) {
		$this->processArray = $var;
	}

	public function getProcessArray() {
		return $this->processArray;
	}

	/**
	 * unprocessed
	 */
	public function setUnprocessedArray( $var ) {
		$this->unprocessedArray = $var;
	}

	public function getUnprocessedArray() {
		return $this->unprocessedArray;
	}

	/**
	 * Used to check that the record exists in both the csv file and the database
	 **/
	private function checkRecord( $rowId, $row, $row2 ){
		$errorArray = array();
	  
		if( (float)$row['originalAmountDue'] != (float)$row2['AmountPaid'] ){
			$error = array( 'row'=>$rowId, 'column'=>'AmountPaid', 'value'=>$row2['AmountPaid'] , 'messages'=>'bulkUploadAmountPaidMismatch' );
			array_push( $errorArray,$error);
		}

		if( $row['dueDate'] != $row2['RentDueDate'] ){
			$error = array( 'row'=>$rowId,'column'=>'RentDueDate', 'value'=>$row2['RentDueDate'] , 'messages'=>'bulkUploadRentDueMismatch' );
			array_push( $errorArray,$error);
		}

		if( trim($row['number']) != trim($row2['UnitNumber'])) {
			$error = array( 'row'=>$rowId,'column'=>'UnitNumber', 'value'=>$row2['UnitNumber'] , 'messages'=>'bulkUploadUnitNumberMismatch' );
			array_push( $errorArray,$error);
		}
		return $errorArray;
	}
	 
	private function getDBRecords() {
	 $uniqueArray = $this->getUnique();

	 // grab amount due, due date, is paid, unit id, and unit number from the db.  the query looks for the unique values from teh unit number, amoutn paid, and due date
	 // this should limit this to 1 query total instead of one query per csv row.  the trade off is the results need to be looped through to check that the pulled data matches the csv rows
	 $db = Zend_Registry::get('db');
	 $query = $db->select()
	 ->from( 'lease',array() )
	 ->join(array( 'ls'=>'leaseSchedule' ), 'lease.id=ls.leaseId', array())
	 ->join(array( 'b'=>'bill' ), 'ls.billId=b.id', array( 'billId'=>'id',
								      'originalAmountDue'=>'originalAmountDue',
								      'dueDate'=>'dueDate',
								      'isPaid'=>'isPaid' ))
	 ->join(array( 'u'=>'unit' ), 'lease.unitId=u.id', array('unitId'=>'lease.unitId', 'number'=>'u.number'))
	 ->where( 'b.isPaid=0' )
	 ->where( 'u.number IN(?)', $uniqueArray['UnitNumber'] )
	 ->where( 'b.originalAmountDue IN (?)', $uniqueArray['AmountPaid'] )
	 ->where( 'b.dueDate IN (?)', $uniqueArray['RentDueDate'] );	 	
	 
	 $resultSet = $db->query( $query );	 

	 $container = array();
	 foreach ($resultSet as $row)
	 $container[] = $row;

	 return $container;
	}


	/**
	 *  Called from validateDBData to fetch the unique values from the csv file
	 */
	private function getUnique(){
		$uniqueArray = array();
		foreach( $this->getData() as $id=>$row )
		foreach( $row as $key=>$value ) {
			if(!array_key_exists( $key,$uniqueArray  ))
			$uniqueArray[$key] = array();

			if( !in_array( $value, $uniqueArray[$key] ) )
			array_push($uniqueArray[$key], $value);
		}
		return $uniqueArray;
	}

	/**
	 *  Loads and parses the file
	 */
	private function loadFile() {
		Zend_Loader::loadClass('parsecsv',
		array(APPLICATION_PATH.'/../library/ParseCsv')
		);
		# create new parseCSV object.
		$csv = new parseCSV();
		$file = $this->getUploadFile();
		//$csv->auto( $file );

		# ...or if you know the delimiter, set the delimiter character
		# if its not the default comma...
		// $csv->delimiter = "\t";   # tab delimited
		$csv->delimiter = ',';   # tab delimited

		# ...and then use the parse() function.
		$csv->parse( $file );

		# Output result.
		$data = $csv->data;
		 
		if( $data ) {
			$this->setData( $data );
			return true;
		}
		else
		return false;
	}

	/**
	 *  Inserts the payments into the tables
	 */
	private function processPayments() {
		//  refactor payment class (maybe payment detail also)
		/*
		array(8) {
		["AmountPaid"]=>
		string(3) "100"
		["Payor"]=>
		string(12) "Bill Johnson"
		["PaymentType"]=>
		string(5) "check"
		["PaymentNumber"]=>
		string(15) "123456789012345"
		["UnitId"]=>
		string(1) "2"
		["BillId"]=>
		string(1) "2"
		}
		*/
	  
		$pmtCreationObj = new Financial_Model_PaymentCreation();

		$alModel = new Financial_Model_AccountLink();
		//$accountLink = $alModel->findByKey( array('search'=>array( 'name'=>'paidRent' )) );
		$alItem = array_shift($alModel->findByKey( array( 'search'=>array( 'name'=>'rentRevenue' ) ) ));		
				
		if( empty( $alItem ) ){
			$this->setMessageState( 'noAccountLinkSet' );
			throw new Exception( 'Missing Account Link in rent payments' );
		}
		    
		$creditAccountId = $alItem->getDebitAccountId();
		$debitAccountId = $this->getDebitAccountId();  
		if( empty( $creditAccountId ) ){
			$this->setMessageState( 'noAccountLinkSet' );
			throw new Exception( 'Missing Debit Id' );
		}

		//if( !$accountLink ) {
		//	$this->setMessageState( 'noAccountLinkSet' );
		//	return false;
		//}
		//else {
		        $accountLink = new Financial_Model_AccountLink(array( 'debitAccountId'=> $debitAccountId, 'creditAccountId'=>$creditAccountId ));			
			$pmtCreationObj->setAccountLink( $accountLink );

			if( $this->getProcessArray() ) {
				foreach( $this->getProcessArray() as $id=>$row) {
					$pmtCreationObj->setAmountPaid( $row['AmountPaid'] );
					$pmtCreationObj->setBillId( $row['BillId'] );
					$pmtCreationObj->setPaymentType( $row['PaymentType'] );
					$pmtCreationObj->setTotalAmount( $row['AmountPaid'] );
					$pmtCreationObj->setPayor( $row['Payor'] );

					/*
					 protected 'billId' => string '3' (length=1)
					 protected 'amtPaid' => string '76.59' (length=5)
					 protected 'transactionId' => null
					 protected 'paymentDetailId' => null
					 protected 'id' => null
					 protected 'dateCreated' => null
					 protected 'dateUpdated' => null
		    */
					if( !$pmtCreationObj->postPayment() ) {
						$this->setMessageState( 'errorPostingPayment' );
						return false;
					}
				}
				return true;
			}
			else {
				$this->setMessageState( 'noRowsToProcess' );
				return false;
			}
		//}
	}
	
	/**
	 *  Returns account id for putting the cash payment
	 */
	private function getDebitAccountId(){
		$fasObj = new Financial_Model_FinancialAccountSetting();
		$param = array( 'returnClassObject'=>true, 'search'=> array( 'settingName'=>'leaseRentCashAccount' ));
		$fasItem = $fasObj->findByKey( $param );
		
		if( empty($fasItem) ) {
			return false;
		} else {
			$item = array_shift( $fasItem );
			$accountId = $item->getAccountId();
			return ($accountId)?$accountId:false;
		}
	}
	
	/**
	 *  Function to upload rent payments
	 */
	public function uploadRentPayments() {
		$return = false;
		if( $this->loadFile() ) {
			if($this->validateData()) {
				$unprocessedRows = $this->validateDBData();
				if( empty( $unprocessedRows ) ) {
					if( $this->processPayments() )
					$return = true;
				}
				else {
					$this->setUnprocessedArray( $unprocessedRows );
					$this->setMessageState( 'errorUnprocessedRows' );
				}
			}
			else{
				$this->setMessageState( 'errorFailedValidation' );
			}
		}
		return $return;
	}


	/**
	 *  Validates the data from the file
	 */
	private function validateData(){
		/**
		 *  Validation:
		 *
		 *  UnitNumber - Alphanumeric
		 *  AmountPaid - Decimal
		 *  RentDueDate - Date
		 *  Payor - Alpha
		 *  PaymentType - Alpha
		 *  Payment Number - Whole Number
		 *  CC Name - Credit Card
		 *  CC Expiration Date - Date
		 *
		 */

		$alphanumeric = new Zend_Validate_Alnum();
		$alpha = new Zend_Validate_Alpha(array('allowWhiteSpace' => true));
		$date = new Zend_Validate_Date('YYYY-MM-DD');
		$decimal = new Zend_Validate_Regex(array('pattern'=>'/^\d+(\.\d{1,2})?$/'));
		$paymenttype = new Zend_Validate_InArray(array('cash','creditcard','check','moneyorder'));

		$validation = array( 'UnitNumber'=> $alphanumeric,
                             'AmountPaid'=> $decimal,
			     'RentDueDate'=> $date,
			     'Payor'=> $alpha,
			     'PaymentType'=> $paymenttype );

		$errorArray = array();

		foreach( $this->getData() as $id=>$row )
		foreach( $row as $key=>$value ) {
			if( isset( $validation[$key] ) ) {
				if( !$validation[$key]->isValid( $value ) ){	// if validation error, flag the error message
					$error = array( 'row'=>$id+1, 'column'=>$key, 'value'=>$value, 'messages'=>implode(',', $validation[$key]->getMessages()) );
					array_push( $errorArray, $error );
				}
			}
			else {
				$error = array( 'row'=>'header', 'column'=>$key, 'value'=>null, 'messages'=>'invalidColumn' );
				array_push( $errorArray, $error );
			}
		}
		if( $errorArray ){
			$this->setErrors( $errorArray );
			return false;
		}
		else
		return true;
	}

	/**
	 *  Check that the data in the csv file matches what is in the database
	 *  Bills are paid in full
	 */
	public function validateDBData() {
		$dbRecords = $this->getDBRecords();
		$finalArray = array();
		$csvArray = array();

		if ( $dbRecords ) {
			// loop through the db rows and see if they are in the csv file.  if so, push the row off the
			// csv file and add the unitId to the row.  Then unset the row from the db records.
			// that way both are reduced.
			// make sure the amount, unit, and date match (mkae sure both unit id and unit number are returned in the db results )
			$csvArray = $this->getData();
			$errors = array();

			// loop through dbRecords
			foreach( $dbRecords as $id=>$row )  {
				/**
				 array(6) {
	    ["billId"]=>
	    string(1) "1"
	    ["originalAmountDue"]=>
	    string(6) "100.00"
	    ["dueDate"]=>
	    string(10) "2010-05-01"
	    ["isPaid"]=>
	    string(1) "0"
	    ["unitId"]=>
	    string(1) "1"
	    ["number"]=>
	    string(2) "A "
	    }
	    */
				// loop through csv file and compare to db records
				foreach( $csvArray as $id2=>$row2 ) {
					/*
					 array(6) {
		    ["UnitNumber"]=>
		    string(2) "1A"
		    ["AmountPaid"]=>
		    string(3) "100"
		    ["RentDueDate"]=>
		    string(10) "2010-05-01"
		    ["Payor"]=>
		    string(12) "Bill Johnson"
		    ["PaymentType"]=>
		    string(5) "check"
		    ["PaymentNumber"]=>
		    string(15) "123456789012345"
		    }
		    */

					$result = $this->checkRecord( $id2+1, $row, $row2 );
					if( empty($result) ) {
						$row2['UnitId']	= $row['unitId'];
						$row2['BillId']	= $row['billId'];
						unset( $row2['RentDueDate'] );
						unset( $row2['UnitNumber'] );
						$finalArray[] = $row2;
						unset( $csvArray[$id2] );
						break;
					}
					else {
						$this->setErrors( $result );
					}
				}
			}
		}
		if(!empty($finalArray))
		$this->setProcessArray( $finalArray );

		return $csvArray;  // return non processed rows
	}


	/**
	 * Determine if the file exists or not.
	 * @return boolean
	 */
	public function isValid() {
		return file_exists($this->getUploadFile());
	}
}
?>
