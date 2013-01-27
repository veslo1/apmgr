<?php
/**
 * Helper for the unit class.<br/>This object must use cache
 * @author Jorge Vazquez<jorgeomarvazquez@debserverp4.com.ar>
 */
class Unit_Library_SearchHelper extends Object_Instrospection
{
	/**
	 * Basic set of keys that we are going to have
	 * @var array
	 */
	private $keys;

	/**
	 * Implementation of the cache object
	 * @var Zend_Cache
	 */
	private $cache;

	/**
	 * This is the constant that we use for caching the records
	 * @var const
	 */
	const SEARCHUNIT='searchUnit';

	/**
	 * The constant that identifies the cached records
	 * @var const
	 */
	const SEARCHFILTER='searchUnitFrontEnd';

	/**
	 * An instance of a ZFDb_Sortable object to aid in the queries
	 * @var ZFDb_Sortable
	 */
	protected $sortable;

	/**
	 * Constructor of this boject
	 * @param array $options
	 */
	public function __construct(array $options=null)
	{
		$this->instrospect($options);
		$this->sortable = new ZFDb_SortHelper($options);
		$this->setCache(Zend_Registry::get('cache'));
	}

	/**
	 * Set the cache engine that will be used
	 * @param Zend_Cache $cache
	 */
	public function setCache($cache)
	{
		$this->cache = $cache;
	}

	/**
	 * Retrieve the cache object
	 * @return Zend_Cache
	 */
	public function getCache()
	{
		return $this->cache;
	}

	/**
	 * Perform a search against the multiple optiosn in unit
	 * @return array
	 * @throws Exception
	 */
	public function searchUnit(array $args=null)
	{
		$this->sortable->setValidColumn(array('name','numBeds','numBaths','numFloors','size'));
		$records = array();
		$result = array();
		$sort = '';

		$db = Zend_Registry::get('db');
		$select = $db->select()->from( array('UM'=>'unitModel'));
		//   ->join( array('deposit'=>'deposit'),'UM.depositId=deposit.id',array('depositName'=>'name','amount'=>'amount')); // add join to deposit to fetch teh required deposit

		if( isset($args['amenities']) )
		{
			$select->join(array('UMA'=>'unitModelAmenity'),'UMA.unitModelId=UM.id',array())
			->join(array('A'=>'amenity'),'UMA.amenityId=A.id',array())
			->where('UMA.amenityId IN(?)',array_values($args['amenities']),'integer');
		}

		//  Push the select so we can map it properly
		$args['statement'] = $select;

		//  Call the helper to translate the reserver keys
		$this->getReservedKeys($args);
		$sorting = $this->sortable->isSorting();
		if( true === $sorting )
		{
			$sort = $this->sortable->prepareOrderQuery();
			$select->order($sort);
		}

		//  Filter repeated records
		$select->group('UM.id');

		$result = $db->fetchAssoc($args['statement']);
		if( count($result) )
		{
			$uma = new Unit_Model_UnitModelAmenity();
			foreach($result as $id=>$value)
			{
				$uma->setUnitModelId($value['id']);
				$results = $uma->getUnitModelAmenities();
				$value['amenities'] = $results;
				$records[] = $value;
			}
		}
		return $records;
	}

	/**
	 * Map the configurable options and translate them into sql statement
	 * @throws UnitHelperException
	 * TODO Refedine , it's not possible to test
	 */
	private function getReservedKeys(&$args)
	{
		// Fetch the options that we know that are configurable
		$this->keys = array('size','beds','baths','floors');

		foreach($args as $key=>$value)
		{
			if( in_array($key,$this->keys) )
			{
				//  If the value that the user sent matches the regular expression, convert the sql statement
				if( preg_match('/\d?\-(l|e|g)/',$value) )
				{
					$constraint = explode('-',$value);
					switch($key)
					{
						case 'size':
							$this->mapTo('UM.size', $constraint,$args['statement']);
							break;
						case 'beds':
							$this->mapTo('numBeds', $constraint,$args['statement']);
							break;
						case 'baths':
							$this->mapTo('numBaths', $constraint,$args['statement']);
							break;
						case 'floors':
							$this->mapTo('numFloors', $constraint,$args['statement']);
							break;
					}
				}
			}
		}
	}

	/**
	 * Perform a trasnformation to Sql terms
	 * @param string $key Table that you should perform the search
	 * @param string $value Encoded value that is decoded
	 * @param Zend_Db_Select $select Statement that is retrieved. This is a reference
	 */
	private function mapTo($key,$value,&$select)
	{
		if( $value[1]=='e')
		{
			$select->where("$key=?", $value[0], 'integer');
		}
		elseif( $value[1]=='l')
		{
			$select->where("$key<=?", $value[0], 'integer');
		}
		elseif($value[1]=='g' )
		{
			$select->where("$key>=?", $value[0], 'integer');
		}
	}

	/**
	 * Prepare all the units that are ready to be shown
	 * @param array $args Array with unitId and sorting criteria
	 */
	public function fetchUnitsToRent($args)
	{
		$unitsWithPictures = array();
		$this->sortable->setValidColumn(array('number','name','addressOne','dateAvailable'));
		$db = Zend_Registry::get('db');
		$select = $db->select()
					->from(array('A' => 'apartment'),array('apartmentId'=>'A.id','address'=>'A.addressOne','name'=>'A.name'))
					->join( array('U'=>'unit'),'A.id = U.apartmentId',array('unitId'=>'U.id','number'=>'U.number','dateAvailable'=>'U.dateAvailable'))					
					->where('U.unitModelId=?',$args['id'],'integer')
					->where('U.isAvailable=?',1,'integer');
		$isSort = $this->sortable->isSorting();
		if( true==$isSort )
		{
			$select->order($this->sortable->prepareOrderQuery());
		}
		$resultSet = $db->query($select);
		
		if( count($resultSet) )
		{
			foreach($resultSet as $id=>$row)
			{
				$unitsWithPictures[$id] = $row;
				$result = $db->fetchRow($db->select()->from(array('UF'=>'unitFile'),array('hasPicture'=>'COUNT(*)'))->where('unitId=?',$row['unitId'],'integer'));
				$unitsWithPictures[$id]['hasPictures'] = $result['hasPicture']>0?true:false;
			}
		}
		

		return $unitsWithPictures;
	}

	/**
	 * Retrieve the sold helper for aditional mangling
	 * @return ZFDb_SortHelper
	 */
	public function getSortHelper()
	{
		return $this->sortable;
	}
}
?>