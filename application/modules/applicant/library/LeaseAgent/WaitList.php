<?php
/**
 * Perform a search against a waitlist
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @package applicant.library.leaseagent
 */

class Applicant_Library_LeaseAgent_WaitList extends ZFModel_ParentModel implements Applicant_Library_Interface_ISearchable {
	/**
	 * cache identifier for the wait list form
	 * @var const
	 */
	const CACHEWAITLIST='waitlistFormSearch';

	/**
	 * Persist the waitlist form helper
	 * @var const
	 */
	const PERSISTWAITLISTFORM='waitlistFormFilters';

	/**
	 * Arguments that will be used during the query
	 * @var unknown_type
	 */
	protected $arguments;

	/**
	 * constructor
	 * @param array $options
	 */
	public function __construct(array $options=null){
		if($options!=null){
			$this->setOptions($options);
		}
		$this->setDbTable('User_Model_DbTable_User');
	}

	/* (non-PHPdoc)
	 * @see application/modules/applicant/library/Interface/Applicant_library_Interface_ISearchable::search()
	 */
	public function search(){
		$records = null;
		//	Determine if we are using sort
		$isSort = $this->isSort();
		if( true==$isSort ) {
			$args = $this->getArguments();
			$cacheName = 'Waitlist'.__FUNCTION__.$args['column'].$args['sort'];
			if( true==$this->resourceIsCached($cacheName) ){
				$cache = Zend_Registry::get('cache');
				$records=$cache->load($cacheName);
			} else {
				$records = $this->retrieveData($cacheName);
			}
		} elseif(true==$this->resourceIsCached(self::CACHEWAITLIST) ) {
			//	Call the cache and retrieve cached data
			$cache = Zend_Registry::get('cache');
			$records=$cache->load(self::PERSISTWAITLISTFORM);
		} else {
			//	Just hit the database
			$records = $this->retrieveData(self::PERSISTWAITLISTFORM);
		}
		return $records;
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

	/* (non-PHPdoc)
	 * @see application/modules/applicant/library/Interface/Applicant_library_Interface_ISearchable::buildQuery()
	 */
	public function buildQuery(){
		//	Prepare the big query
		$select = $this->getDbTable()->getAdapter()->select();
		$select->from(array('US' => 'user'),array('firstName'=>'US.firstName','lastName'=>'US.lastName','email'=>'US.emailAddress','userId'=>'US.id'))
				->join(array('UW'=>'userWaitlist'),'US.id=UW.userId',array('dateCreated'=>'UW.dateCreated','modelId'=>'UW.modelId'))
				->join(array('UM'=>'unitModel'),'UW.modelId=UM.id',array('unitModelName'=>'UM.name'));

		//	Determine the search filters that the user selected
		$args = $this->getArguments();
		$userFilterByDate = isset($args['filterByDates'])?array_shift($args['filterByDates']):null;
		$useUnitNumber = isset($args['unitNumber'])?$args['unitNumber']:null;

		//	Apply the date filter into the query
		if( 1==$userFilterByDate ) {
			$select->where('UW.dateCreated>=?',$this->getDbTable()->getAdapter()->quoteInto($args['dateFrom'],'string'));
			$select->orWhere('UW.dateCreated<=?',$this->getDbTable()->getAdapter()->quoteInto($args['dateTo'],'string'));
		}

		if( !empty($useUnitNumber) ){
			$select->where("UM.name LIKE '%".$this->getDbTable()->getAdapter()->quoteInto($useUnitNumber,'string')."%'");
		}

		if( $this->isSort() ){
			$select->order($args['column'].' '.$args['sort']);
		}
		return $select;
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
			$validColumn = $this->filterSort($args['column'],array('firstName','lastName','email','dateCreated','unitModelName'));
			if( true==$validColumn and true==$validColumn ) {
				$isSort = true;
			}
		}
		return $isSort;
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
			$cache->save($records,$cacheIdentifier);
		}
		return $records;
	}
}