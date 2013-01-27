<?php
/**
 * Created on Sun Sep 13 19:03:12 ART 2009 by jvazquez
 * @appname datesite
 * @package models.city
 * <p>
 * Handle the city entity.
 * </p>
 */

include_once 'ZFModel/ParentModel.php';
class City_Model_City extends ZFModel_ParentModel {

	/**
	 *@var name
	 */
	protected $name;

	protected $province;

	/**
	 * Constructor of this object
	 */
	public function __construct(array $options = null) {
		$provinceModel = new Province_Model_Province();

		if( $options['provinceId'] ) {
			$province = $provinceModel->findById( $options['provinceId'] );
			$options['province'] = ($province)? $province : null;
		}
		parent::__construct( $options );
		$this->setDbTable('City_Model_DbTable_City');
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

	public function setProvince( $province ) {
		$this->province = $province;
	}

	public function getProvince() {
		return $this->province;
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
		->from( array('c'=>'city'),
		array( 'c.id', 'c.name', 'c.dateCreated', 'c.dateUpdated', 'c.provinceId' )
		)
		->join( array('p'=>'province'),'c.provinceId=p.id',array('provinceName'=>'p.name')  )
		->order( $order );

		// var_dump( $select  );
		//   	   print "<pre>";var_dump($select->__toString());print"</pre>";

		$resultSet = $db->query($select);
		 
		$container = array();

		foreach ($resultSet as $row) {
			$data = array('id'=>$row['id'],'name'=>$row['name'], 'provinceId'=>$row['provinceId'], 'dateCreated'=>$row['dateCreated'],'dateUpdated'=>$row['dateUpdated']);

			$entry = new City_Model_City($data);
			$container[] = $entry;
		}
		return $container;
	}

	/**
	 *Saves a record in this model----
	 */
	public function save() {
		$result = false;
			
		$data = array ('name' => $this->getName(), 'provinceId'=>$this->getProvince()->getId() );

		if (null === ($id = $this->getId())) {
			unset ($data['id']);
			$data['dateCreated'] = date('Y-m-d H:i:s');
			$result =(int) $this->getDbTable()->insert($data);
		} else {
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
		$city = null;
		if ( $id ) {
			$resultSet = $this->getDbTable()->find($id);
			if ( count($resultSet) == 0 ) {
				return $city;
			}
			$row = $resultSet->current();
			$data = array('id'=>$row->id,'name'=>$row->name, 'provinceId'=>$row->provinceId,'dateCreated'=>$row->dateCreated,'dateUpdated'=>$row->dateUpdated);
			$city = new City_Model_City($data);
		}
		return $city;
	}

	public function findByKey($key=null,$value) {
		$container = false;
		if ( !empty($key) and !empty($value) ) {
			$resultSet = $this->getDbTable()->fetchAll($this->getDbTable()->select()->where("$key=?",$value));
			foreach ($resultSet as $row) {
				$data = array('id'=>$row->id,'name'=>$row->name,'provinceId'=>$row->provinceId,'dateCreated'=>$row->dateCreated,'dateUpdated'=>$row->dateUpdated);
				$entry = new City_Model_City($data);
				$container[] = $entry;
			}
		}
		return $container;
	}
}
?>
