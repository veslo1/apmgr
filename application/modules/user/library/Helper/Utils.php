<?php
/**
 * Used in the implementation of the task 284.
 * This acts as a bridge until the further implementation of Dao's and Bo's is set
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @package application.modules.user.library.helper
 */
class User_Library_Helper_Utils
{
	/**
	 * Return the current userid , and determine if he is an admin
	 * @return boolean
	 */
	public function isRole($roleUser=null)
	{
		$isRole = false;
		$userid = User_Library_Helper_Utils::currentUserId();
		$user = new User_Model_User();
		$user = $user->findById($userid);
		if($user!==null)
		{
			$roleId = $user->getRoleId();
			$role = new Role_Model_Role();
			$roleDetails = $role->findById($roleId);
			if( null!== $roleDetails )
			{
				$isRole = $roleUser==$roleDetails->getName();
			}
		}
		return $isRole;
	}

	/**
	 *  Returns users by roleId - currently used in the maintenance settings page for
	 *  populating the default assignedTo person for new maintenance tickets
	 */
	public function getUsersByRoleId($roleId)
	{
		$container = false;
		$role = new Role_Model_Role();
		$db = $role->getDbTable()->getAdapter();
		$query = $db->select()
		->from( array('u'=>'user'), array('id'=>'id','fullName'=>"CONCAT(lastName, ', ', firstName)")  )
		->where('u.roleId=?',$roleId);

		$resultSet = $db->query( $query );
		if($resultSet)
		{
			$container = null;
			foreach ($resultSet as $row)
			{
				$container[] = $row;
			}
		}
		return $container;
	}

	/**
	 * Create an applicant account
	 * @param array $args
	 * @return boolean
	 * TODO Refactor this , is going to break the application since the scope is not clear at all
	 * @deprecated
	 */
	public function createApplicantAccount(array $args=null)
	{
		$created = false;
		$role = new Role_Model_Role();
		$this->setUserid($args['userid']);
		$memberRole = array_shift ( $role->findByKey(array('returnClassObject'=>true,'search'=>array('name'=>'applicant'))));
		if( empty($memberRole) )
		{
			$this->setMessageState('userNameFailRole');
			//TODO Notify the administrators of this issue.
		}
		else
		{
			$this->setRoleid($memberRole->getId());
			$created = $this->save();
		}
		return $created;
	}

	/**
	 * Retrieves the id of the current user
	 * @return null
	 */
	public static function currentUserId()
	{
		$userid = null;
		$auth = Zend_Auth::getInstance();
		$auth->setStorage(new Zend_Auth_Storage_Session('vazneyStorage'));
		if ( $auth->getIdentity() != false )
		{
			$userid = $auth->getIdentity()->id;
		}
		return $userid;
	}
}