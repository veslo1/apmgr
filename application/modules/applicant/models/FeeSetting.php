<?php
/**
 *
 * @author Jorge Vazquez <jvazquez@debserverp4.com.ar>
 */
class Applicant_Model_FeeSetting extends ZFModel_ParentModel {

	/**
	 * @var int $feeId
	 */
	protected $feeId;

	/**
	 * Constructor of the class
	 * @param array $options
	 */
	public function __construct(array $options=null) {
		parent::__construct($options);
		$this->setDbTable('Applicant_Model_DbTable_FeeSetting');
	}

	/**
	 * Set feeId
	 * @param int $feeId
	 * @return Applicant_Model_FeeSetting
	 */
	public function setFeeId($feeId) {
		$this->feeId=$feeId;
		return $this;
	}

	/**
	 * Get feeId
	 * @return int
	 */
	public function getFeeId() {
		return $this->feeId;
	}

	/**
	 * Process an array and proceed to save
	 * @param array $args
	 * @return boolean
	 * @throws Zend_Db_Statement_Exception
	 */
	public function process(array $args=null) {
		$result = true;
		$operation = array();
		if( !empty($args) ) {
			$result = $this->validateIds(array_values($args));
			if(true==$result) {
				foreach($args as $id=>$feeId) {
					$this->setFeeId($feeId);
					$rest = $this->save();
				}
			}
		}
		return !in_array(false,$operation);
	}

	/**
	 *
	 * Process a key of id's and determine if they are enabled an exists
	 * @param array $array
	 * @example validateIds(array(0=>1,1=>2));
	 * @return boolean
	 */
	public function validateIds($array) {
		$valid = array();
		$result = false;
		$enabled = false;

		$fee = new Financial_Model_Fee();
		foreach($array as $id=>$feeId) {
			$valid[] = $this->exists(array('table'=>'fee','column'=>'id'), $feeId);
			$enabled = $fee->findById($feeId)->getEnabled();
			if (false==$enabled) {
				$valid[] = false;
			}
		}
		return !in_array(false, $valid);
	}

	/**
	 *
	 * Perform an array intersect between the enabled fee's and the fee's that you have on your table of applicantFeeSetting
	 * @param array $args
	 * @return array
	 * @example retrieveEnabledFees(array('column'=>'name','sort'=>'ASC'));
	 */
	public function retrieveEnabledFees(array $args=null) {
		$enabledFees = array();
		$resultSet = array();
		$oder = null;
		$order = isset($args['sort'])?$args['sort']:null;
		$column = isset($args['column'])?$args['column']:null;
		if( $order!==null and $column!==null ) {
			$validColumn = $this->filterSort($column,array('name,amount'));
			$validOrder = $this->filterOrder($order);
			if($validColumn and $validOrder) {
				$order ='ORDER BY '.$column.' '.$sort;
			}
		}
		$query = "SELECT F.name,F.amount,AFS.id FROM `applicantFeeSetting` AFS INNER JOIN fee F ON (AFS.feeId=F.id) WHERE F.enabled=1 ";
		if($order!==null) {
			$query .=$order;
		}
		$db = $this->getDbTable()->getAdapter();
		$resultSet = $db->query($query);
		if( count($resultSet) > 0 ) {
			foreach($resultSet as $id=>$value) {
				$enabledFees[] = $value;
			}
		}
		return $enabledFees;
	}
}