<?php
/**
 * Concrete implementation for the service layer
 * @author Jorge Omar Vazquez<jvazquez@debserverp4.com.ar>
 * @package application.modules.file.library.impl
 */

class File_Library_Impl_Service implements File_Library_Service
{
	/**
	 *
	 * Dao for File
	 * @var ZFInterfaces_Dao
	 */
	private $dao;

	/**
	 *
	 * Contains the state of this element
	 * @var array
	 */
	private $msg;

	public function __construct()
	{}

	/**
	 *
	 * set the dao
	 * @param ZFInterfaces_Dao $dao
	 */
	public function setDao(ZFInterfaces_Dao $dao)
	{
		$this->dao = $dao;
	}

	/**
	 *
	 * Retrieve the dao
	 * @return ZFInterfaces_Dao
	 */
	public function getDao()
	{
		return $this->dao;
	}

	/**
	 * (non-PHPdoc)
	 * @see library/ZFInterfaces/ZFInterfaces_Messageable::setMessageState()
	 */
	public function setMessageState($msg)
	{
		$this->msg = $msg;
	}

	/**
	 * (non-PHPdoc)
	 * @see library/ZFInterfaces/ZFInterfaces_Messageable::getMessageState()
	 */
	public function getMessageState()
	{
		return $this->msg;
	}

	/**
	 * (non-PHPdoc)
	 * @see application/modules/file/library/File_Library_Service::findById()
	 */
	public function findById($id)
	{
		$buffer = $this->dao->findById($id);
		$file = null;
		if($buffer!==null)
		{
			$file = new File_Model_File( $buffer );
		}
		else
		{
			$this->setMessageState(array('msg'=>'noRecordFound','type'=>'warning'));
		}
		return $file;
	}

	/**
	 * (non-PHPdoc)
	 * @see application/modules/file/library/File_Library_Service::fetchAll()
	 */
	public function fetchAll($where = null, $order = null, $count = null, $offset = null)
	{
		$result = null;
		$list = $this->dao->fetchAll($where , $order , $count , $offset );
		if($list!==null)
		{
			foreach($list->toArray() as $id=>$args)
			{
				$result[] = new File_Model_File($args);
			}
		}
		else
		{
			$this->setMessageState(array('msg'=>'noRecordFound','type'=>'warning'));
		}
		return $result;
	}

	/**
	 * (non-PHPdoc)
	 * @see application/modules/file/library/File_Library_Service::save()
	 */
	public function save(array $args)
	{
		return $this->dao->save(new File_Model_File($args));
	}

	/**
	 * (non-PHPdoc)
	 * @see application/modules/file/library/File_Library_Service::update()
	 */
	public function update(array $args)
	{
		return false;
	}

	/**
	 * (non-PHPdoc)
	 * @see application/modules/file/library/File_Library_Service::delete()
	 */
	public function delete($id)
	{
		$file = new File_Model_File(array_shift($this->dao->findById($id)));
		return $this->dao->delete($file)!=false;
	}
}