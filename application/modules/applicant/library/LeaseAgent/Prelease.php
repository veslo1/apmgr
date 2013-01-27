<?php
/**
 * Object that deals with searchs inside prelease 
 * @package applicant.library.leaseagent
 */

class Applicant_Library_LeaseAgent_Prelease extends ZFModel_ParentModel implements Applicant_Library_Interface_ISearchable {
	/**
	 * This is the key that is used to tag the elements in the cache
	 * @var const
	 */
	const CACHETAG='preleaseFormSearch';

	/**
	 * The name of the tag to persist form arguments
	 * @var const
	 */
	const PERSISTFORM='leaseAgentPreleaseFormFilters';

	/**
	 * Set the arguments
	 * @var array
	 */
	protected $arguments;

	/**
	 * Set the options for this Object
	 * @param array $options
	 */
	public function __construct(array $options=null){
		if($options!=null){
			$this->setOptions($options);
		}
		$this->setDbTable('Applicant_Model_DbTable_Prelease');
	}

	/* (non-PHPdoc)
	 * @see application/modules/applicant/library/Interface/Applicant_library_Interface_ISearchable::search()
	 */
	public function search() {
		$cache = Zend_Registry::get('cache');
		$recordExists = $cache->load(self::CACHETAG);
		$records = NULL;
		if( $recordExists==false ) {
			$select = $this->buildQuery();			
			$recordSet = $this->getDbTable()->getAdapter()->query($select);
			$recordCount = count($recordSet);
			if( $recordCount>0 ) {
				foreach($recordSet as $id=>$row) {
					$records[]=$row;
				}
				$cache->save($records,self::CACHETAG);
			}
		} else {
			$this->sort($recordExists);
			$records = $recordExists;
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
		->join(array('A'=>'applicant'),'US.id=A.userId',array('dateCreated'=>'A.dateCreated','applicantId'=>'A.id'))
		->join(array('PL'=>'applicantPreleaseFeeBill'),'A.id=PL.applicantId',array())
		//->join(array('AWS'=>'applicantWorkflowStatus'),'A.id=AWS.applicantId',array())
		//->join(array('AS'=>'applicantStatus'),'AWS.applicantStatusId=AS.id',array())
		->join(array('AA'=>'applicantAppliance'),'A.id=AA.applicantId',array())
		->join(array('U'=>'unit'),'AA.unitId=U.id',array('unitNumber'=>'number'))
		->join(array('UM'=>'unitModel'),'U.unitModelId=UM.id',array('unitModelName'=>'UM.name'));

		//	Determine the search filters that the user selected
		$args = $this->getArguments();
		//$useApplicantStatus = isset($args['filterByStatus'])?array_shift($args['filterByStatus']):null;
		$userFilterByDate = isset($args['filterByDates'])?array_shift($args['filterByDates']):null;
		$useUnitNumber = isset($args['unitNumber'])?$args['unitNumber']:null;

		//$select->where('AWS.currentStatus=1');
		//	Apply the status filter into the query
		//if( 1==$useApplicantStatus ) {
		//	$this->applyStatusFilter($select);
		//}
		//	Apply the date filter into the query
		if( 1==$userFilterByDate ) {
			$select->where('A.dateCreated>=?',$this->getDbTable()->getAdapter()->quoteInto($args['dateFrom'],'string'));
			$select->where('A.dateCreated<=?',$this->getDbTable()->getAdapter()->quoteInto($args['dateTo'],'string'));
		}

		if( !empty($useUnitNumber) ){
			$select->where("U.number LIKE '%".$this->getDbTable()->getAdapter()->quoteInto($useUnitNumber,'string')."%'");
		}
		$column = isset($args['column'])?$args['column']:null;
		$sort = isset($args['sort'])?$args['sort']:null;
		if( !empty($column) and !empty($sort) ){
			$validOrder = $this->filterSort($column,array('lastName','firstName','dateCreated','unitModelName'));
			$validSort = $this->filterOrder($sort);
			if($validOrder and $validSort){
				$select->order($column.' '.$sort);
			}
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
}