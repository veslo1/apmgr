<?php
/**
 * Concrete implementation of the Dao object for Unit Models
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @package application.modules.unit.library
 */
class Unit_Library_UnitModelDao extends ZFDao_Dao
{
	/**
	 *
	 * Auto initialize the prospects gateway
	 */
	public function __construct()
	{
		$this->setTemplate(new Unit_Model_DbTable_UnitModel());
	}
}
