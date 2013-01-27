<?php
/**
 * Created on Dec 5, 2009 by rnelson
 * @name apmgr
 * @package application.modules.unit.models.DTable
 * <p>
 * Contains the table
 * </p>
 */
class Unit_Model_DbTable_Unit extends Zend_Db_Table_Abstract {
	protected $_name = 'unit';
	protected $_primary = 'id';
	//protected $_dependentTables = array('Unit_Model_DbTable_UnitUser');
}
?>
