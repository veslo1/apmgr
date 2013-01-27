<?php
/**
 * Misc methods that can't be contained in any other place
 *
 * @author jvazquez
 */
class ZFUtil_Utils
{
	/**
	 * Return the current userid , and determine if he is an admin
	 * @return array
	 */
	public static function isAdmin()
	{
		$auth = Zend_Auth::getInstance();
		$auth->setStorage(new Zend_Auth_Storage_Session('vazneyStorage'));
		$userid = false;
		$isAdmin = false;

		if( $auth->getIdentity() )
		{
			$userid = $auth->getIdentity()->id;
			$roleId = $auth->getIdentity()->roleId;
			$role = new Role_Model_Role();
			$roleData = $role->findById($roleId);
			if($roleData!==null)
			{
				$isAdmin = $roleData->getName()=='admin'?true:false;
			}
		}
		return array('admin'=>$isAdmin,'userid'=>$userid);
	}

	/**
	 * Retrieve the current user id
	 * @return NULL|int
	 */
	public static function currentUserId()
	{
		$auth = Zend_Auth::getInstance();
		$auth->setStorage(new Zend_Auth_Storage_Session('vazneyStorage'));
		$userid = null;
		if( $auth->getIdentity() ) {
			$userid = $auth->getIdentity()->id;
		}
		return $userid;
	}
}
?>