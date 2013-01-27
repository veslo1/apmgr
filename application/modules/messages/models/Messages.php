<?php
/**
 * @author Jorge Omar Vazquez<jvazquez@debserverp4.com.ar>
 * @date 01-11-2009
 * @package application.modules
 * @subpackage messages.models
 * <p>Unified model for system messages.
 * It holds three categories
 * <ul>
 * 	<li>Success</li>
 * 	<li>Error</li>
 *  <li>Warning</li>
 * </ul>
 */

class Messages_Model_Messages extends ZFModel_ParentModel {

	/**
	 * @var string identifier
	 */
	protected $identifier;

	/**
	 *@var successMessage
	 */
	protected $message;

	/**
	 * @var $category
	 */
	protected $category;

	/**
	 * @var string The language that is used to create this message
	 */
	protected $language;

	/**
	 * @var int Is this message locked
	 */
	protected $locked;

	/**
	 * Constant value for Error Messages
	 * @var const ERRTYPE
	 */
	const ERRTYPE = "error";

	/**
	 * Constant value for Success messages.
	 * @var const SUCCESSTYPE
	 */
	const SUCCESSTYPE = "success";

	/**
	 * Constant value for Warning messages.
	 * @var const WARNTYPE
	 */
	const WARNTYPE ="warning";

	/**
	 * Constructor of this object
	 */
	public function __construct(array $options = null) {
		parent::__construct($options);
		$this->setDbTable('Messages_Model_DbTable_Messages');
	}

	/**
	 * Sets the identifier for this message
	 */
	public function setIdentifier($identifier) {
		$this->identifier = $identifier;
	}

	/**
	 * Returns the identifier of this record
	 * @return string
	 */
	public function getIdentifier() {
		return $this->identifier;
	}

	/**
	 * Returns successMessage
	 */
	public function getMessage() {
		return $this->message;
	}

	/**
	 * Sets successMessage
	 */
	public function setMessage($message) {
		$this->message = $message;
	}

	/**
	 * Returns the category of the message
	 * @return string
	 */
	public function getCategory() {
		return $this->category;
	}

	/**
	 * Sets category of the message
	 */
	public function setCategory($category) {
		$this->category = $category;
	}

	/**
	 * @return string The language this message was created
	 */
	public function getLanguage() {
		return $this->language;
	}

	/**
	 * Sets the language of this message
	 * @param string language The Full Locale name that was used to create this message
	 */
	public function setLanguage($language) {
		$this->language = $language;
	}

	/**
	 * Assume the default value of true, to avoid problems in the save method if
	 * the user did not define the state
	 * @return int Is this message locked and you can't delete it
	 */
	public function getLocked() {
		return $this->locked;
	}

	/**
	 * @param int locked Toggle this message as locked
	 */
	public function setLocked($locked) {
		$this->locked = $locked;
	}

	/**
	 * Saves or updates a record in this model
	 * @return int
	 */
	public function save() {
		$result = false;
		$data = array( 'message'=>$this->getMessage(),'identifier'=>$this->getIdentifier(),'category'=>$this->getCategory(),'language'=>$this->getLanguage(),'locked'=>$this->getLocked());
		if (null === ($id = $this->getId())) {
			unset ($data['id']);
			$data['dateCreated'] = date('Y-m-d H:i:s');
			$result =(int) $this->getDbTable()->insert($data);
		} else {
			$data['dateUpdated'] = date('Y-m-d H:i:s');
			$result = $this->getDbTable()->update($data, array ('id = ?' => $this->getId() ),'integer');
		}
		return $result;
	}

	/**
	 * (non-PHPdoc)
	 * @see library/Zend/Db/Table/Zend_Db_Table_Abstract#delete($where)
	 */
	public function delete($id) {
		$result = false;
		if ( $id ) {
			$message =  new Messages_Model_Messages();
			$msg = $message->findById($id);
			if( $msg!=null and $msg->getLocked()==false) {
				$db = $this->getDbTable()->getAdapter();
				$where = $db->quoteInto('id=?',$id,'integer');
				$result = $this->getDbTable()->delete($where,'messages');
			}
		}
		return $result;
	}
}