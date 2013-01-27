<?php
/**
 * Concrete implementation of the Dao object for Prospects Answers
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @package application.modules.prospects.library
 */
class Prospects_Library_ProspectAnswersDao extends ZFDao_Dao
{
	/**
	 *
	 * Auto initialize the prospects gateway
	 */
	public function __construct()
	{
		$this->setTemplate(new Prospects_Model_DbTable_ProspectsUnitIdAnswer());
	}
}
