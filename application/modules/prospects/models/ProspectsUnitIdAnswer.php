<?php
/**
 * Implementation of the Prospects Unit Model Answers model
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @package application.modules.prospects.models
 */

class Prospects_Model_ProspectsUnitIdAnswer extends ZFModel_ParentModel
{
	/**
	 * 
	 * Reference of the prospect
	 * @var int $prospectId
	 */
	protected $prospectId;
	
	/**
	 * The unitModel id
	 * @var int $unitModelId
	 */
	protected $unitModelId;
	
	public function __construct(array $options=null)
	{
		parent::__construct($options);
		$this->setDbTable('Prospects_Model_DbTable_ProspectsUnitIdAnswer');
	}
	
	/**
	 * 
	 * Set the prospectId
	 * @param int $prospectId
	 */
	public function setProspectId($prospectId)
	{
		$this->prospectId = $prospectId;
	}
	
	/**
	 * 
	 * Retrieve the prospectId
	 * @return int
	 */
	public function getProspectId()
	{
		return $this->prospectId;	
	}
	
	/**
	 * 
	 * Set the unit model id
	 * @param int $unitModelId
	 */
	public function setUnitModelId($unitModelId)
	{
		$this->unitModelId = $unitModelId;
	}
	
	/**
	 * 
	 * Retrieve the unitModelId
	 * @return int
	 */
	public function getUnitModelId()
	{
		return $this->unitModelId;
	}
}