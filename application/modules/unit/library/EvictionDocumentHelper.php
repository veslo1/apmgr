<?php
/**
 * This objects helps the file to be moved to the proper directory
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 *         Rachael Nelson - modified from picture helper  
 * @package application.modules.unit.library
 */
class Unit_Library_EvictionDocumentHelper extends Object_Instrospection implements ZFObserver_ILogeable
{
	/**
	 * Contains a ZFFile_File object
	 * @var ZFFile_File
	 */
	protected $zfFile;

	/**
	 * Contains a reference to a unitId
	 * @var int
	 */
	protected $evictionIdId;

	/**
	 * Enter description here ...
	 * @var Zend_Config
	 */
	protected $properties;

	/**
	 * Setter for evictionId
	 * @param int $evictionId
	 */
	public function setEvictionId($var)
	{
		$this->evictionId = $evictionId;
	}

	/**
	 * Getter for evictionId
	 * @return number
	 */
	public function getEvictionId()
	{
		return $this->evictionId;
	}

	/**
	 * Prepares this object with injected elements
	 * @param array $options
	 */
	public function __construct(array $options=null)
	{
		$this->instrospect($options);
		$this->log = new ZFObserver_Forensic();
		$this->log->attach(new ZFObserver_Observers_Text);
		$this->log->setStatus(ZFObserver_ILogeable::INFO);
	}
	
	/**
	 * Auto initialize the properties
	 */
	public function initProps()
	{
		$this->setProperties(APPLICATION_PATH.'/modules/unit/config/evictionConfig.ini',APPLICATION_ENV);
	}
	
	/**
	 * Retrieve the file and take care of moving file contents
	 * if the quota is okay
	 * @param array $arg
	 */	
	private function moveFile(array $args=null)
	{
		$moved = false;
		$evictionId = $args['evictionId'];		
		$evictionObj = new Unit_Model_Eviction();
		$eviction = $evictionObj->findById($evictionId);
		
		$props = $this->getProperties();		
		//	Homie am looking forward to improve this , it is a bit ugly
		$this->setFileArgs($args['file']['picture']);
		//  Prepare the elements
		$zfFile = $this->getFileArgs();
		$filesize = $zfFile->getSize();
		$cursize = $this->getQuotaSize($evictionId);
		$totalSize = $cursize+$filesize;
		$curfilepath = $zfFile->getPath();
		
		//  We are over the quota
		$limit = $this->calculateQuotaLimit($cursize, $filesize, $props->pictures->quota->eviction);
			
		if($limit==true)
		{
			$this->setMessageState('quotaLimit');
		}
		elseif(file_exists($props->pictures->files->destination.$eviction->getTenantId().DIRECTORY_SEPARATOR.$eviction->getId().DIRECTORY_SEPARATOR.$zfFile->getName()) )
		{
			$this->setMessageState('fileExists');
		}
		else
		{			
			$moved = $this->initDirectory($eviction, $zfFile->getPath(),$props);
			if($moved){
				
			}	
		}
		return $moved;
	}	
	
	/**
	 * Retrieves a file , and pushes it into the filesystem.
	 * If the operation succeds  , we save into the database
	 * @param array $args
	 */
	public function transferFile(array $args)
	{
		$succed = false;
		$form = $args['form'];
		try
		{
			if( $form->picture->receive() == true )
			{
				$evictionId = $args['evictionId'];
				$options = array('file'=>$form->picture->getFileInfo(),'evictionId'=>$evictionId);
				if( $this->moveFile($options) == true )
				{
					if( $this->insert($evictionId,$args['description']) == true )
					{
						$succed = true;
					}
				}
			}
		}
		catch (Zend_File_Transfer_Exception $e)
		{
			$this->log->setStatus(ZFObserver_ILogeable::EMERG);
			$this->log->setStatus("Exception caught while trying to receive a file".$e->getMessage()." at ".$e->getFile().", line ".$e->getLine());
			$this->setMessageState('transferFail');
		}
		return $succed;
	}
	

	/**
	 * Validates that the given evictionId is valid
	 * @param int $evictionId
	 * @return boolean
	 */
	public function validateEvictionId($evictionId=0)
	{
		$valid = false;
		$eviction = new Unit_Model_Eviction();
		$valid = $eviction->exists(array('table'=>'eviction','column'=>'id'), $evictionId);
		if( $valid===false )
		{
			$this->setMessageState('evictionIdNotValid');
		}
		return $valid;
	}

	/**
	 * Retrieves the add picture form
	 * @throws Exception,Zend_Form_Transfer_Exception
	 * @return Unit_Form_AddFiles
	 */
	public function getAddPictureForm()
	{
		$form = new Unit_Form_AddFiles();
		//		$properties = new Zend_Config_Ini(APPLICATION_PATH.'/modules/unit/config/config.ini',APPLICATION_ENV);
		$properties = $this->getProperties();		
		$form->setProperties($properties);		
		$form->setForm();		
		return $form;
	}

	/**
	 * Set the zfFile object
	 * @param array $args
	 */
	public function setFileArgs(array $args=null)
	{
		$this->zfFile = new ZFFile_File();
		$this->zfFile->setType($args['type']);
		$this->zfFile->setPath($args['tmp_name']);
		$this->zfFile->setName($args['name']);
		$this->zfFile->setSize($args['size']);
	}

	/**
	 * @return ZFFile_File
	 */
	public function getFileArgs()
	{
		return $this->zfFile;
	}

	/**
	 * Returns the consumed quota for a particular unit
	 * @param int $unitId
	 * @return double
	 */
	public function getQuotaSize($evictionId)
	{
		$db = new Unit_Model_DbTable_UnitFile();
		$adapter = $db->getAdapter();
		$resultSet = $adapter->fetchRow(
		$adapter->select()
		->from(array('F'=>'file'),array('quota'=>'SUM(F.size)'))
		->join(array('EF'=>'evictionFile'), 'EF.fileId=F.id', array(null))
		->where($adapter->quoteInto('evictionId=?', $evictionId,'integer') )
		);
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
	 * @param object $eviction
	 * @param string $tmpFile
	 * @param array $props
	 * @return boolean
	 */
	protected function initDirectory($eviction,$tmpFile,$props)
	{
		$result = false;				
		$destination = $props->pictures->files->destination.$eviction->getTenantId().DIRECTORY_SEPARATOR.$eviction->getId();
		$zfFile = $this->getFileArgs();
		$shell = new Shell_Wrapper();		
		                
		if( file_exists($destination) == false )
		{
			$output = $shell->execute("mkdir -p $destination");
			if($output!="")
			{
				$this->setMessageState('directoryFail');
			}
		}
		$output = $shell->execute("mv $tmpFile $destination");
		$result = $output==""?true:false;
		return $result;
	}
	
	/**
	 * Performs an insert in the associated entities
	 * @param int $evictionId
	 * @param string $description
	 * @return boolean
	 */
	private function insert($evictionId,$description='')
	{
		$db = Zend_Registry::get('db'); // used for all in transaction		
		
		$saved = false;
		try
		{
			$db->beginTransaction();
			
			$evictionObj = new Unit_Model_Eviction();
			$eviction = $evictionObj->findById( $evictionId );
			
			$args = $this->getFileArgs();
			
			// set the destination
			$props = $this->getProperties();			
			$destination = $props->pictures->files->destination.$eviction->getTenantId().DIRECTORY_SEPARATOR.$eviction->getId();
			
			// save the file						
			$file = new File_Model_File(array( 'db'=>$db));
			$file->setDescription($description);			
			$file->setPath($destination);
			$file->setFileName( $args->getName() );
			$file->setSize($args->getSize());
			$file->setMimeType($args->getType());			
			$fileId = $file->save();
			
			// save the eviction file
			$evictionFile = new Unit_Model_EvictionFile(array( 'db'=>$db));
			$evictionFile->setEvictionId($evictionId);
			$evictionFile->setFileId($fileId);
			$evictionFile->save();
			$db->commit();
			$saved = true;
		}
		catch(Exception $e)
		{
			$db->rollBack();
			$this->setMessageState('errortitle');
		}
		return $saved;
	}
}