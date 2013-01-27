<?php
/**
 * Created on Dec 5, 2009 by rnelson
 * @name apmgr
 * @package application.modules.unit.models.DTable
 * <p>
 * Contains the table
 * </p>
 */
class Unit_Model_DbTable_Tenant extends Zend_Db_Table_Abstract {
	protected $_name = 'tenant';

	/*
	 protected $_referenceMap    = array(
	 'Unit' => array(
	 'columns'           => array('unitId'),
	 'refTableClass'     => 'Unit_Model_DbTable_Unit',
	 'refColumns'        => array('id')
	 ),
	 'User' => array(
	 'columns'           => array('userId'),
	 'refTableClass'     => 'User_Model_DbTable_User',
	 'refColumns'        => array('id')
	 )
	 );
	 */
}
?>
