<?php
/**
 * Description of Applicant
 *
 * @author Jorge Vazquez <jvazquez@debserverp4.com.ar>
 */
class Applicant_Model_Applicant extends ZFModel_ParentModel {
	/**
	 *
	 * @var int $userId
	 */
	protected $userId;

	public function __construct(array $options = null) {
		parent::__construct( $options );
		$this->setDbTable('Applicant_Model_DbTable_Applicant');
	}

	/**
	 *
	 * @return integer
	 */
	public function getUserId() {
		return $this->userId;
	}

	/**
	 * @param int $userId
	 */
	public function setUserId($userId) {
		$this->userId = $userId;
		return $this;
	}

	/**
	 * Retrieve all the applicants
	 * @param string $column
	 * @param string $sort
	 */
	public function fetchAllApplicants(array $args=null) {
		$applicants = array();
		$findDeleted = isset($args['deleted'])?1:0;
		$db = $this->getDbTable()->getAdapter();
		$select = $db->select()
		->from(
		array('A' => 'applicant'),
		array('applicantId'=>'A.id','DateJoined'=>'A.dateCreated')
		)
		->join(
		array('U'=>'user'),
                        	'A.userId = U.id'
                        	)
                        	->where($db->quoteInto('U.deleted=?',$findDeleted,'integer'));

                        	//		TODO Sorts and columns need check mapping, I can alter the query string and it fails
                        	//		@internal created http://redmine.debserverp4.com.ar/issues/119

                        	if( isset($args['sort']) and isset($args['column']) ) {
                        		$validOrder= $this->filterOrder($args['order']);
                        		$validSort = $this->filterSort($args['column'],array('firstName','lastName'));
                        		if($validOrder and $validSort) {
                        			$select->order($column.' '.$column);
                        		}
                        	}

                        	$resultSet = $db->query($select);

                        	if( count($resultSet) == 0 ) {
                        		return $applicants;
                        	}

                        	foreach($resultSet as $id=>$row) {
                        		$applicants[]= $row;
                        	}
                        	return $applicants;
	}

	/**
	 *  Fetch user by applicant id
	 */
	public function fetchApplicantUser(){
		$db = $this->getDbTable()->getAdapter();
		$query = $db->select()
		->from( array('u'=>'user'))
		->join( array('a'=>'applicant'),'a.userId=u.id',array())
		->where( 'a.id=?', array( $this->getId() ) );

		$resultSet = $db->query( $query );
			
		$container = null;
		foreach ($resultSet as $row){
			$container[] = $row;
		}
		return $container[0];
	}
}
?>
