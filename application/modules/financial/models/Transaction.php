<?php
/**
 * Created on Feb 4, 2010 by rnelson
 * @name apmgr
 * @package application.modules.financial.models
 * <p>
 * Model for transaction
 * </p>
 */


class Financial_Model_Transaction extends ZFModel_ParentModel {

	/**
	 *@var userId
	 */
	protected $userId;

	/**
	 *@var comment
	 */
	protected $comment;

	/**
	 *@var action
	 */
	protected $action;
	 
	 
	/**
	 * Constructor of this object
	 */
	public function __construct(array $options = null) {
		parent::__construct( $options );
		$this->setDbTable('Financial_Model_DbTable_Transaction');

		try{
			$userId = User_Library_Helper_Utils::currentUserId();
			if($userId){
				$this->setUserId( $userId );
			}
			else{
				throw new Exception('Missing User Id in transaction.  Is the user logged in?');
			}
		}
		catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
	}
	 
	/**
	 * userId
	 */
	public function setUserId( $var ) {
		$this->userId = $var;
	}

	public function getUserId() {
		return $this->userId;
	}
	 
	/**
	 * comment
	 */
	public function setComment( $var ) {
		$this->comment = $var;
	}

	public function getComment() {
		return $this->comment;
	}

	/**
	 * action
	 */
	public function setAction( $var ) {
		$this->action = $var;
	}

	public function getAction() {
		return $this->action;
	}
}
?>
