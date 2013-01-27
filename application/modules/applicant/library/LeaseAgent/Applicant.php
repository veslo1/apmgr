<?php
/**
 * Object that deals with searchs inside applicants
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @package applicant.library.leaseagent
 */

class Applicant_Library_LeaseAgent_Applicant extends ZFModel_ParentModel implements Applicant_Library_Interface_ISearchable {
	/**
	 * This is the key that is used to tag the elements in the cache
	 * @var const
	 */
	const CACHETAG='formSearch';

	/**
	 * The name of the tag to persist form arguments
	 * @var const
	 */
	const PERSISTFORM='leasegeAgentFormFilters';

	/**
	 * Set the arguments
	 * @var array
	 */
	protected $arguments;

	/**
	 * The valid columns we have for this report
	 * @var array $columns
	 */
	protected static $columns = array('firstName','lastName','email','dateCreated','statusName','unitModelName','status','unitNumber');
	
	/**
	 * Set the options for this Object
	 * @param array $options
	 */
	public function __construct(array $options=null){
		if($options!=null){
			$this->setOptions($options);
		}
		$this->setDbTable('Applicant_Model_DbTable_Applicant');
	}

	/* (non-PHPdoc)
	 * @see application/modules/applicant/library/Interface/Applicant_library_Interface_ISearchable::search()
	 */
	public function search() {
		$records = null;
		//	Determine if we are using sort
		$isSort = $this->isSort();
		if( true==$isSort ) {
			$args = $this->getArguments();
			$records = $this->retrieveData();
		} else {
			$records = $this->retrieveData(self::CACHETAG);
		}
		return $records;
	}

	/**
	 * The code that takes care of retrieving the records and storing it in cache
	 * @param string $cacheIdentifier
	 * @return array
	 */
	private function retrieveData($cacheIdentifier=self::CACHETAG) {
		$cache = Zend_Registry::get('cache');
		$records = array();
		$select = $this->buildQuery();
		$recordSet = $this->getDbTable()->getAdapter()->query($select);
		$recordCount = count($recordSet);
		if( $recordCount>0 ) {
			foreach($recordSet as $id=>$row) {
				$records[] = $row;
			}
//			$cache->save($records,$cacheIdentifier);TODO Why is this commented?
		}
		return $records;
	}

	/* (non-PHPdoc)
	 * @see application/modules/applicant/library/Interface/Applicant_library_Interface_ISearchable::buildQuery()
	 */
	public function buildQuery() {
		//	Prepare the big query
		$select = $this->getDbTable()->getAdapter()->select();
		$select->from(array('US' => 'user'),array('firstName'=>'US.firstName','lastName'=>'US.lastName','email'=>'US.emailAddress','userId'=>'US.id'))
		->join(array('A'=>'applicant'),'US.id=A.userId',array('dateCreated'=>"DATE_FORMAT(A.dateCreated,'%m/%d/%Y %H:%i:%s')",'applicantId'=>'A.id'))
		->join(array('BG'=>'applicantBackgroundCheck'),'A.id=BG.applicantId',array('status'=>'BG.status'))
		->joinLeft(array('AFB'=>'applicantFeeBill'),'A.id=AFB.applicantId',array('bill'=>'AFB.billId'))
		->join(array('AWS'=>'applicantWorkflowStatus'),'A.id=AWS.applicantId',array(null))
		->join(array('AS'=>'applicantStatus'),'AWS.applicantStatusId=AS.id',array('statusName'=>'AS.name'))
		->join(array('AA'=>'applicantAppliance'),'A.id=AA.applicantId',array(null))
		->join(array('U'=>'unit'),'AA.unitId=U.id',array('unitNumber'=>'U.number'))
		->join(array('UM'=>'unitModel'),'U.unitModelId=UM.id',array('unitModelName'=>'UM.name'));

		//	Determine the search filters that the user selected
		$args = $this->getArguments();
		$useApplicantStatus = isset($args['filterByStatus'])?array_shift($args['filterByStatus']):null;
		$userFilterByDate = isset($args['filterByDates'])?array_shift($args['filterByDates']):null;
		$useUnitNumber = isset($args['unitNumber'])?$args['unitNumber']:null;

		$select->where('AWS.currentStatus=1');
		//	Apply the status filter into the query
		if( 1==$useApplicantStatus ) {
			$this->applyStatusFilter($select);
		}
		//	Apply the date filter into the query
		if( 1==$userFilterByDate ) {
			$select->where('DATE(A.dateCreated)>=?',$this->getDbTable()->getAdapter()->quoteInto($args['dateFrom'],'string'));
			$select->where('DATE(A.dateCreated)<=?',$this->getDbTable()->getAdapter()->quoteInto($args['dateTo'],'string'));
		}

		if( !empty($useUnitNumber) ){
			$select->where("UM.name LIKE '%".$this->getDbTable()->getAdapter()->quoteInto($useUnitNumber,'string')."%'");
		}

		if( $this->isSort() ){
			$select->order($args['column'].' '.$args['sort']);
		}		
		return $select;
	}

	/* (non-PHPdoc)
	 * @see application/modules/applicant/library/Interface/Applicant_library_Interface_ISearchable::setArguments()
	 */
	public function setArguments(array $args=null){
		$this->arguments = $args;
		return $this;
	}

	/* (non-PHPdoc)
	 * @see application/modules/applicant/library/Interface/Applicant_library_Interface_ISearchable::getArguments()
	 */
	public function getArguments(){
		return $this->arguments;
	}

	/**
	 * Check before applying the where condition. This determines if we use a IN or a =
	 * @param Zend_Db_Select $select
	 * @return Zend_Db_Select
	 * TODO Review that reference
	 */
	private function applyStatusFilter(Zend_Db_Select &$select){
		$args = $this->getArguments();
		$desiredStatuses = $args['filterValue'];
		$statusCount = count($desiredStatuses);
		if( $statusCount==1 ) {
			$select->where('AWS.applicantStatusId=? AND AWS.currentStatus=1',$this->getDbTable()->getAdapter()->quoteInto($desiredStatuses,'integer'));
		} else {
			$statusBuffer='';
			//	Decrease the count
			$statusCount--;
			foreach($desiredStatuses as $id=>$statusId){
				//	Can't recal Spl object to check for last , replace when I recall it
				$statusBuffer.=$this->getDbTable()->getAdapter()->quoteInto($statusId,'integer');
				if( $statusCount!=$id) {
					$statusBuffer.=",";
				}
			}
			$select->where("AWS.applicantStatusId IN ($statusBuffer)");
		}
	}

	/**
	 * Determine if we have a sort
	 * @return boolean
	 */
	public function isSort() {
		$isSort = false;
		$args = $this->getArguments();
		if ( isset($args['sort']) and isset($args['column']) ) {
			$validOrder = $this->filterOrder($args['sort']);
			$validColumn = $this->filterSort($args['column'],self::$columns);
			if( true==$validColumn and true==$validColumn ) {
				$isSort = true;
			}
		}
		return $isSort;
	}
}
