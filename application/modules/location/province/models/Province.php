<?php
/**
 * Created on Mon Sep 14 20:40:34 ART 2009 by jvazquez
 * @appname datesite
 * @package models.province
 * <p>
 * Provide a clear definition of what this class does
 * </p>
 */

include_once 'ZFModel/ParentModel.php';
class Province_Model_Province extends ZFModel_ParentModel {

	/**
	 *@var name
	 */
	protected $name;

	/**
	 *@var country
	 */
	protected $country;
	 
	/**
	 * Constructor of this object
	 */
	public function __construct(array $options = null) {
		$countryModel = new Country_Model_Country();

		if( $options['countryId'] ) {
			$country = $countryModel->findById( $options['countryId'] );
			$options['country'] = ($country)? $country : null;
		}
		parent::__construct( $options );
		$this->setDbTable('Province_Model_DbTable_Province');
	}

	/**
	 * Returns name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Sets name
	 */
	public function setName($name) {
		$this->name=$name;
	}

	public function setCountry( $country ) {
		$this->country = $country;
	}

	public function getCountry() {
		return $this->country;
	}

	/**
	 *This method returns all the records for this model
	 */
	public function fetchAll( $column=NULL, $sort='ASC' ) {
		$order = NULL;
		if( $sort && $column )
		{
			$order = $column . ' '. $sort;
		}

		$container = array();

		$db = $this->getDbTable()->getAdapter();
		$select = $db->select()
		->from( array('p'=>'province'),
		array( 'p.id', 'p.name', 'p.dateCreated', 'p.dateUpdated', 'p.countryId' )
		)
		->join( array('c'=>'country'),'p.countryId=c.id',array('countryName'=>'c.name')  )
		->order( $order );

		// var_dump( $select  );
		// print "<pre>";var_dump($select->__toString());print"</pre>";

		$resultSet = $db->query($select);
		 
		$container = array();

		foreach ($resultSet as $row) {
			$data = array('id'=>$row['id'],'name'=>$row['name'], 'countryId'=>$row['countryId'], 'dateCreated'=>$row['dateCreated'],'dateUpdated'=>$row['dateUpdated']);

			$entry = new Province_Model_Province($data);
			$container[] = $entry;
		}
		return $container;
	}

	/**
	 *Saves a record in this model
	 */
	public function save() {
		$result = false;
			
		$data = array ('name' => $this->getName(), 'countryId'=>$this->getCountry()->getId() );

		//  create new province
		if (null === ($id = $this->getId())) {
			unset ($data['id']);
			$data['dateCreated'] = date('Y-m-d H:i:s');
			$result =(int) $this->getDbTable()->insert($data);
		}
		//  Editing existing province
		else {
			$data['dateUpdated'] = date('Y-m-d H:i:s');
			$result = $this->getDbTable()->update($data, array ('id = ?' => $this->getId() ),integer);
		}
		return $result;
	}

	/**
	 *Finds a record in this model
	 *@param id integer
	 */
	public function findById($id=null) {
		$province = null;
		if ( $id ) {
			$resultSet = $this->getDbTable()->find($id);
			if ( count($resultSet) !=0 ) {
				$row = $resultSet->current();
				$data = array('id'=>$row->id,'name'=>$row->name, 'countryId'=>$row->countryId,'dateCreated'=>$row->dateCreated,'dateUpdated'=>$row->dateUpdated);
				 
				$province = new Province_Model_Province($data);
			}
		}
		return $province;
	}

	/**
	 *Finds a record by key in this model
	 *@param key string
	 *@param value string
	 */
	public function findByKey($key=null,$value) {
		$container = array();
		 
		if ( !empty($key) and !empty($value) ) {
			$resultSet = $this->getDbTable()->fetchAll($this->getDbTable()->select()->where("$key=?",$value));
			 
			foreach ($resultSet as $row) {
				$data = array('id'=>$row->id,'name'=>$row->name, 'countryId'=>$row->countryId,'dateCreated'=>$row->dateCreated,'dateUpdated'=>$row->dateUpdated);
				$entry = new Province_Model_Province($data);
				$container[] = $entry;
			}
		}
		return $container;
	}

}
?>
