<?php
/**
 * Created on Sun Sep  6 19:41:13 ART 2009 by jvazquez
 * @appname datesite
 * @package users.model.DbTable
 * <p>
 * This class represents the connection between the model and the zend db table abstract class.
 * </p>
 */
class User_Model_DbTable_User extends Zend_Db_Table_Abstract
{
	protected $_name = 'user';
}
?>
