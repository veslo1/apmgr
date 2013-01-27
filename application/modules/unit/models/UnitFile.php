<?php
/**
 *  Holds the unit to file relation
 * 	@author Rachael Laney <wtcfg1@gmail.com> 
 *  Created December 31,2010
 *  @package application.modules.unit.models
 */
class Unit_Model_UnitFile extends ZFModel_ParentModel
{
	
	/**
	 * @var int $unitId
	 */
	protected $unitId;
	
	/**
	 * @var NO $fileId
	 */
	protected $fileId;
	
	public function __construct(array $options=null)
	{
		parent::__construct($options);
		$this->setDbTable('Unit_Model_DbTable_UnitFile');
	}

	/**
	 * Sets the unit id
	 * @param int $unitId
	 * @return Unit_Model_UnitFile
	 */
	public function setUnitId($unitId)
	{
		$this->unitId = $unitId;
		return $this;
	}
	
	/**
	 * Retrieves the unitId
	 * @return number
	 */
	public function getUnitId()
	{
		return $this->unitId;
	}
	
	/**
	 * Set fileId
	 */
	public function setFileId($fileId)
	{
		$this->fileId=$fileId;
		return $this;
	}
	
	/**
	 * Get fileId
	 */
	public function getFileId()
	{
		return $this->fileId;
	}
}
