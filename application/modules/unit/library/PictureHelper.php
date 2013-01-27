<?php
/**
 * This objects helps the file to be moved to the proper directory
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @package application.modules.unit.library
 */
class Unit_Library_PictureHelper extends Object_Instrospection
{
	/**
	 * Enter description here ...
	 * @var Zend_Config
	 */
	protected $properties;

	/**
	 * 
	 * Dao used for hitting the database
	 * @var ZFInterfaces_Dao
	 */
	protected $dao;
	
	/**
	 * Prepares this object with injected elements
	 * @param array $options
	 */
	public function __construct(array $options=null)
	{
		$this->instrospect($options);
	}
	
	/**
	 * 
	 * Sets the dao
	 * @param $dao
	 */
	public function setDao(ZFInterfaces_Dao $dao)
	{
		$this->dao = $dao;
	}
	
	/**
	 * Retrieve the dao
	 * @return ZFInterfaces_Dao
	 */
	public function getDao()
	{
		return $this->dao;
	}
	
	/**
	 * Retrieve the file and take care of moving file contents
	 * if the quota is okay
	 * @param array $arg
	 */
	public function moveFile(array $args)
	{
		$moved = false;
		$unitId = $args['unitId'];
		$apartmentId = $args['apartmentId'];
		//  Prepare the elements
		$filesize = $args['file']['picture']['size'];
		$cursize = $this->getQuotaSize($unitId);
		$curfilepath = $args['file']['picture']['tmp_name'];
		$props = $args['props'];
		//  We are over the quota
		$limit = $this->calculateQuotaLimit( $cursize , $filesize , $props->pictures->quota->unit );
		$filepath = $props->pictures->files->destination.$apartmentId.DIRECTORY_SEPARATOR.$unitId.DIRECTORY_SEPARATOR.$args['file']['picture']['name'];
		if($limit==true)
		{
			$this->setMessageState( array('msg'=>'quotaLimit','type'=>'error'));
		}
		elseif( file_exists($filepath) === true )
		{
			$this->setMessageState( array('msg'=>'fileExists','type'=>'error'));
		}
		else
		{
			$moved = $this->initDirectory($unitId, $args['file']['picture']['tmp_name'] , 
											$props , $apartmentId);
		}
		return $moved;
	}

	/**
	 * Returns the consumed quota for a particular unit
	 * @param int $unitId
	 * @return double
	 * TODO Refactor this portion , it's depending directly from the Model object
	 */
	public function getQuotaSize($unitId)
	{
		$db = new Unit_Model_DbTable_UnitFile();
		$adapter = $db->getAdapter();
		$row = $adapter->select()
			->from(array('F'=>'file'),array('quota'=>'SUM(F.size)'))
			->join(array('UF'=>'unitFile'), 'UF.fileId=F.id', array(null))
			->where($adapter->quoteInto('unitId=?', $unitId,'integer') );
		$resultSet = $adapter->fetchRow($row);
		$cursize = $resultSet['quota'];
		return isset($cursize)?$cursize:0;
	}

	/**
	 * Calculate the valid size for file uploads
	 * @param double $cursize
	 * @param double $actualSize
	 * @param double $currentLimit
	 * @return boolean
	 */
	public function calculateQuotaLimit($cursize,$actualSize,$currentLimit)
	{
		return ($cursize+$actualSize)>$currentLimit;
	}

	/**
	 * Determine if we need to create a directory or just move the file
	 * @param int $unitId
	 * @param string $tmpFile
	 * @param array $props
	 * @param int $apartmentId
	 * @return boolean
	 */
	protected function initDirectory($unitId,$tmpFile,$props,$apartmentId)
	{
		$result = false;
		$destination = $props->pictures->files->destination.$apartmentId.DIRECTORY_SEPARATOR.$unitId;
		$shell = new Shell_Wrapper();

		if( file_exists($destination) == false )
		{
			$output = $shell->execute("mkdir -p $destination");
			if( $output!="" )
			{
				$this->setMessageState(array('msg'=>'directoryFail','type'=>'error'));
			}
		}
		
		$output = $shell->execute("mv $tmpFile $destination");
		$result = $output==""?true:false;
		return $result;
	}

	/**
	 * Performs an insert in the associated entities
	 * @param int $unitId
	 * @param string $description
	 * @return boolean
	 *
	public function insert($unitId,$description='')
	{
		$saved = false;
		$db = Zend_Registry::get('db');
		try
		{
			$db->beginTransaction();
			$file = new File_Model_File(array('db'=>$db));
			$args = $this->getFileArgs();
			$file->setDescription($description);
			$file->setPath($args->getPath());
			$file->setSize($args->getSize());
			$file->setMimeType($args->getType());
			$fileId = $file->save();
			$unit = new Unit_Model_UnitFile(array('db'=>$db));
			$unit->setUnitId($unitId);
			$unit->setFileId($fileId);
			$unit->save();
			$saved = $db->commit();
		}
		catch(Exception $e)
		{
			$db->rollback();
			$this->setMessageState('errortitle');
		}
		return $saved;
	}
	*/
}