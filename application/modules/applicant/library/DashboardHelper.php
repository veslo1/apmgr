<?php
/**
 * Helper for the DashboardController
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 */
class Applicant_Library_DashboardHelper implements ZFInterfaces_Messageable
{
	/**
	 * The state of this object
	 * @var string $msg
	 */
	private $msg;
	
	/**
	 * Constructor
	 */
	public function __construct()
	{
	}


	/**
	 * Retrieve the completed applications for the current user in the system
	 * @param Zend_Auth $auth
	 * @param multiple:(sort:string,column:string,retrieveRejected:boolean)
	 * @return array
	 */
	public function retrieveCompletedApplications(Zend_Auth $auth,array $args=null)
	{
		$storage = $auth->getStorage();
		$userId = $auth->getIdentity()->id;
		$applications = array();
		$order = null;
		$exists = $this->userExists($userId);

		if( $exists ) {
			$applicant = new Applicant_Model_Applicant();
			$db = $applicant->getDbTable()->getAdapter();
			$select=$db->select()
					->from(array('A' => 'applicant'),array('applicantId'=>'A.id'))
					->join( array('AA'=>'applicantAuthorization'),'A.id = AA.applicantId',array(null) )
					->join( array('AP'=>'applicantAppliance'),'A.id = AP.applicantId',array('unitId'=>'AP.unitId','dateCreated'=>'AP.dateCreated') )
					->join( array('U'=>'unit'),'U.id = AP.unitId',array('modelId'=>'U.unitModelId') )
					->join( array('UM'=>'unitModel'),'UM.id = U.unitModelId',array('name'=>'UM.name') )
					->where('A.userId=?',$userId,'integer')
					->where('AA.acceptedContract=?',1,'integer');

			if( isset($args['sort']) and isset($args['column']) ) {
				$validSort = $applicant->filterOrder($args['sort']);
				$validColumn = $applicant->filterSort($args['column'],array('name','dateCreated'));
				if($validSort and $validColumn) {
					$order = $args['column'].' '.$args['sort'];
					$select->order($order);
				} else {
					$this->setMessageState('invalidColumnSpecified');
				}
			}
			$recordSet = $db->query($select);

			if(count($recordSet)>0) {
				foreach($recordSet as $id=>$row) {
					$applications[] = $row;
				}
			}
		}
		return $applications;
	}

	/**
	 * Return the wait list for the current user and the name of the model
	 * @param array $args
	 * @return array
	 */
	public function retrieveWaitListData(Zend_Auth $auth,array $args=NULL) {
		$waitList = array();
		$storage = $auth->getStorage();
		$userId = $auth->getIdentity()->id;
		$exists = $this->userExists($userId);
		$order = null;

		if( isset($args['sort']) and isset($args['column']) ) {
			$order = $args['column'].' '.$args['sort'];
		}

		if( true==$exists ) {
			$unitModel = new Unit_Model_UnitModel();
			$db = $unitModel->getDbTable()->getAdapter();
			$select = $db->select()
						 ->from(array('UM'=>'unitModel'),array('name'=>'UM.name','id'=>'UM.id'))
						 ->join( array('UW'=>'userWaitlist'),'UW.modelId = UM.id',array('dateCreated'=>'UW.dateCreated') )
						 ->where('UW.userId=?',$userId,'integer');

			if(null!==$order) {
				$select->order($order);
			}
			
			$recordSet = $db->query($select);

			if( count($recordSet)>0 ) {
				foreach($recordSet as $id=>$row) {
					$waitList[] = $row;
				}
			}
		}

		return $waitList;
	}

	/**
	 * Determine if a user exists
	 * @param int $id
	 * @return boolean
	 */
	private function userExists($id) {
		$user = new User_Model_User();
		$exists = $user->exists(array('table'=>'user','column'=>'id'), $id);
		return $exists;
	}
	
	/* (non-PHPdoc)
	 * @see library/ZFInterfaces/ZFInterfaces_Messageable::setMessageState()
	 */
	public function setMessageState($msg){
		$this->msg = $msg;
	}
	
	/* (non-PHPdoc)
	 * @see library/ZFInterfaces/ZFInterfaces_Messageable::getMessageState()
	 */
	public function getMessageState(){
		return $this->msg;
	}
}