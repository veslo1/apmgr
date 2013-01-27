<?php
/**
 * Concrete implementation for units
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @package application.library.unit.library.impl
 */
class Unit_Library_Impl_Service implements Unit_Library_Services
{
	/**
	 * Contains a description for a message
	 * @var array
	 */
	private $msg;

	/**
	 *
	 * Contains the dao used for files
	 * @var ZFInterfaces_Dao
	 */
	private $daoFile;

	/**
	 * Contains the dao used for unit files
	 * @var ZFInterfaces_Dao
	 */
	private $daoUnitFile;

	/**
	 * The regular dao for units
	 * @var ZFInterfaces_Dao
	 */
	private $dao;

	/**
	 *
	 * Contains a form object that will be injected
	 * @var ZFForm_ParentForm
	 */
	private $form;

	public function __construct(){}

	/**
	 *
	 * Sets a form that will be used in this object
	 * @param ZFForm_ParentForm $form
	 */
	public function setForm(ZFForm_ParentForm $form)
	{
		$this->form = $form;
	}

	/**
	 * Retrieves the form
	 * @return ZFForm_ParentForm
	 */
	public function getForm()
	{
		return $this->form;
	}

	/* (non-PHPdoc)
	 * @see application/modules/unit/library/Unit_Library_Services::findById()
	 */
	public function findById($id)
	{
		$result = null;
		$args = $this->dao->findById($id);
		if($args!==null)
		{
			$result = new Unit_Model_Unit($args->toArray());
		}
		return $result;
	}

	/* (non-PHPdoc)
	 * @see application/modules/unit/library/Unit_Library_Services::fetchAll()
	 */
	public function fetchAll($where = null, $order = null, $count = null, $offset = null)
	{
		$result = null;
		$list = $this->dao->fetchAll($where , $order , $count , $offset );
		if($list!==null)
		{
			foreach($list->toArray() as $id=>$args)
			{
				$result[] = new Unit_Model_Unit($args);
			}
		}

		return $result;
	}

	/* (non-PHPdoc)
	 * @see application/modules/unit/library/Unit_Library_Services::save()
	 */
	public function save(array $unit)
	{
		return $this->dao->save(new Unit_Model_Unit($unit));
	}

	/* (non-PHPdoc)
	 * @see application/modules/unit/library/Unit_Library_Services::update()
	 */
	public function update(array $unit)
	{
		return false;
	}

	/* (non-PHPdoc)
	 * @see application/modules/unit/library/Unit_Library_Services::delete()
	 */
	public function delete($id)
	{
		return false;
	}

	/**
	 * Sets the dao for the unit file
	 * @param ZFInterfaces_Dao $dao
	 */
	public function setUnitFileDao(ZFInterfaces_Dao $dao)
	{
		$this->daoUnitFile = $dao;
	}

	/**
	 * Sets the dao for the file
	 * @param ZFInterfaces_Dao $dao
	 */
	public function setFileDao(ZFInterfaces_Dao $dao)
	{
		$this->daoFile = $dao;
	}

	/**
	 * Sets the dao for the unit
	 * @param ZFInterfaces_Dao $dao
	 */
	public function setDao(ZFInterfaces_Dao $dao)
	{
		$this->dao = $dao;
	}

	/* (non-PHPdoc)
	 * @see application/modules/unit/library/Unit_Library_Services::viewUnitsGraphics()
	 */
	public function viewUnitsGraphics($id)
	{
		$files = array();
		if( $this->dao->exists(array('column'=>'id','table'=>'unit'), $id) === true )
		{
			if( $this->daoUnitFile->exists(array('column'=>'unitId','table'=>'unitFile'),$id) === true )
			{
				$db = $this->daoUnitFile->getGateway();
				$unitFiles = $this->daoUnitFile->fetchAll( $db->quoteInto('unitId=?',$id,'integer') );
				$files = array();
				foreach($unitFiles->toArray() as $index=>$unitFile)
				{
					$uf = new Unit_Model_UnitFile($unitFile);
					$buffer = new File_Model_File( $this->daoFile->findById($uf->getFileId()) );
					$files[] = $buffer->toArray();
				}
			}
			else
			{
				$this->setMessageState( array('msg'=>'unitDoesNotHasPictures','type'=>'warning') );
			}
		}
		else
		{
			$this->setMessageState( array('msg'=>'unitIdNotValid','type'=>'error') );
		}
		return $files;
	}

	/* (non-PHPdoc)
	 * @see library/ZFInterfaces/ZFInterfaces_Messageable::setMessageState()
	 */
	public function setMessageState($msg)
	{
		$this->msg = $msg;
	}

	/* (non-PHPdoc)
	 * @see library/ZFInterfaces/ZFInterfaces_Messageable::getMessageState()
	 */
	public function getMessageState()
	{
		return $this->msg;
	}

	/* (non-PHPdoc)
	 * @see application/modules/unit/library/Unit_Library_Services::addPicture()
	 */
	public function addPicture(array $args,Unit_Library_PictureHelper $helper)
	{
		$added = false;
		$description = isset( $args['description'] ) ? $args['description'] : null;
		$id = $args['unitId'];
		try
		{
			$transfer = $this->form->receive();
			if(  $transfer == true )
			{
				$buffer = array_shift($this->dao->findById($id));
				$args = array('file'=>$this->form->getFileInfo(),'unitId'=>$id,'apartmentId'=>$buffer['apartmentId'],'props'=>$this->form->getProperties());
				$added = $helper->moveFile($args);
				if($added==false)
				{
					$this->setMessageState($helper->getMessageState());
				}
			}
			else
			{
				$this->setMessageState(array('msg'=>'unableToTransferFile','type'=>'error'));
			}
		}
		catch (Zend_File_Transfer_Exception $e)
		{
			$log = new ZFObserver_Forensic();
			$log->setStatus(ZFObserver_Forensic::DEBUG);
			$log->attach(new ZFObserver_Observers_Text());
			$this->setMessageState(array('msg'=>'unableToTransferFile','type'=>'error'));
			$log->notify("BusinessObjectPictureUnit", "Unable to transfer file to destination.Caught ".$e->getMessage() );
		}
		
		return $added;
	}

	/**
	 *
	 * Saves a file for the given unit
	 * @param array $args
	 * @return boolean
	 */
	public function insertPicture(array $args)
	{
		$saved = false;
		$props = $this->form->getProperties();
		$fileargs = array();
		$buffer = $this->form->getFileInfo();
		$fileargs['mimeType'] = $buffer['picture']['type'];
		$fileargs['fileName'] = $buffer['picture']['name'];
		$apt = array_shift($this->dao->findById($args['unitId']));
		$fileargs['path'] = $props->pictures->files->webpath.$apt['apartmentId'].DIRECTORY_SEPARATOR.$args['unitId'];
		$fileargs['size'] = $buffer['picture']['size'];
		$fileargs['description'] = $this->form->getElement('description')->getValue();
		$fileargs['deleted'] = 0;
		$file = new File_Model_File($fileargs);
		$saved = $this->daoFile->transactionSave(
		array(
				'file'=>$file,
				'unitFile'=>new Unit_Model_UnitFile( array('unitId'=>$args['unitId']) ) 
		)
		);
		if($saved==false)
		{
			$this->setMessageState(array('msg'=>'','type'=>'error'));
		}
		return $saved;
	}

	/**
	 * (non-PHPdoc)
	 * @see application/modules/unit/library/Unit_Library_Services::prepareAddPicture()
	 */
	public function prepareAddPicture($id)
	{
		$valid = false;
		if( $this->dao->exists(array('column'=>'id' ,'table'=>'unit'), $id) === true )
		{
			try {
				$form = new Unit_Form_AddFiles();
				$properties = new Zend_Config_Ini(APPLICATION_PATH.'/modules/unit/config/config.ini',APPLICATION_ENV);
				$form->setProperties($properties);
				$form->setForm();
				$this->form = $form;
				$valid = true;
			} catch (Exception $e) {
				$log = new ZFObserver_Forensic();
				$log->setStatus(ZFObserver_Forensic::ERR);
				$log->attach(new ZFObserver_Observers_Text());
				$log->notify("BusinessObjectPictureUnit","The destination is not writable.".$e->getMessage());
			}
		}
		else
		{
			$this->setMessageState( array('msg'=>'unitIdNotValid','type'=>'error') );
		}
		return $valid;
	}

	/**
	 *
	 * Wiring the dao's for special search scenarios
	 */
	public function prepareUnitFileGraphic()
	{
		$this->dao = new Unit_Library_Impl_Dao();
		$this->dao->setTemplate(new Unit_Model_DbTable_Unit());
		$this->daoUnitFile = new Unit_Library_Impl_Dao();
		$this->daoUnitFile->setTemplate(new Unit_Model_DbTable_UnitFile());
		$this->daoFile = new File_Library_Impl_Dao();
		$this->daoFile->setTemplate(new File_Model_DbTable_File());
	}
}