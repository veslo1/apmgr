<?php
/**
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @since 31-05-2010
 * <p>Model object to handle the login controller calls</p>
 */
class User_Library_Helper_Login extends Object_Instrospection {
	/**
	 * Default value to use when no other value is set
	 * @var array
	 */
	public static $defaultUrl = array(1 => array('default','index','index'),0 => array('user','login','index'));

	/**
	 * Data mapper
	 * @var array
	 */
	static $dataMapper = array('user');

	public function __construct(){
	}

	/**
	 * Determine the login destination
	 * @param $args boolean Key that the controller send us
	 * @return string
	 */
	public function getLoginDestination($args=false) {
		$destination = NULL;
		switch($args) {
			case 1:
				//	Our credentials are valid. Try in order this steps. (They <strong>can`t</strong> happen at the same time)
				$destination = $this->getUrlReminderDestination();

				if( $destination==NULL ) {
					$destination = $this->getWorkflowUrlDestination();
				}

				if($destination==NULL) {
					$destination = join('/',self::$defaultUrl[1]);
				}
				break;
			case 0:
				//	If we fail to authenticate, this means that our password is not valid. go to login page
				$destination = join('/',self::$defaultUrl[0]);
				break;
			default:
				$destination = self::$defaultUrl[1];
				break;
		}
		return $destination;
	}

	/**
	 * Get the destination of a url reminder object.
	 * This session is loaded when the user tries to reach a page
	 * but he did not provide the proper authentication tokens.
	 * We use cache on this method, and we won't need to clean it.
	 * Modules is a only altered when we run the scanner
	 * @return string
	 */
	protected function getUrlReminderDestination()
	{
		$destination = NULL;
		// Now we check if we had a destination URL first
		$urlReminder = new Zend_Session_Namespace('access');
		if( !empty($urlReminder->destination) )
		{
			$destination =  $urlReminder->destination;
			$urlReminder->unsetAll();// Kill the session
			$module = new Modules_Model_Modules();
			$modules = $module->fetchAll();
			$destinationPieces = preg_split('/\//',$destination,0,PREG_SPLIT_NO_EMPTY);
			$found = false;
			foreach($modules as $id=>$moduleObject)
			{
				if( $destinationPieces[0]==$moduleObject->getName()  )
				{
					$found = true;
				}
			}
			if($found!=true)
			{
				$destination = null;
			}
		}

		return $destination;
	}

	/**
	 * Retrieve the current url from session if we are in a workflow.
	 * We are in a workflow.
	 * @internal So far we have 1 that requires us to authenticate.
	 * When workflows grow, we will need to handle them here
	 * @return string
	 */
	protected function getWorkflowUrlDestination()
	{
		//	If we are on the workflow , check the end action
		$destination = NULL;
		$helper= new Applicant_Library_WaitListHelper();
		$orders = $helper->getSessionSteps();
		if( !empty($orders->end) )
		{
			$auth = $helper->fetchAuthenticationInformation();
			$helper->setSessionSteps('userid',$auth->getIdentity()->id);
			$destination = join('/',array($orders->end['module'],$orders->end['controller'],$orders->end['action']));
		}

		return $destination;
	}

	/**
	 * Authenticate a client
	 * @param string $username
	 * @param string $password
	 * @return boolean
	 */
	public function authenticateUser($username,$password)
	{
		$success = false;
		$args = array( 'returnClassObject'=>true, 'search'=>array( 'username'=>$username,'password'=>sha1($password ) ) );
		$user = new User_Model_User();
		$user =  $user->findByKey($args);
		if($user!=NULL)
		{
			$user = array_shift($user);
			$auth = Zend_Auth::getInstance();
			$auth->setStorage(new Zend_Auth_Storage_Session('vazneyStorage'));
			//			$userRoleSession = new Zend_Session_Namespace('wulfStorageUserRole');
			$authAdapter = new Zend_Auth_Adapter_DbTable(User_Model_User::getDefaultAdapter(), 'user', 'username', 'password');
			$authAdapter->setIdentity($username);
			$authAdapter->setCredential(sha1($password));
			$authenticated = $authAdapter->authenticate();
			$success = $authenticated->isValid();
			if ( true==$success )
			{
				$userid = $authAdapter->getResultRowObject('id');
				$storage = $auth->getStorage();
				$storage->write( $authAdapter->getResultRowObject( array ('id','username','password','roleId') ) );
			}
		}
		else
		{
			$this->setMessageState('invalidCredentials');
		}
		return $success;
	}

	/**
	 * Set the roles for the given credentials
	 * @param Zend_Auth_Adapter_DbTable $authAdapter
	 * @param Zend_Auth $auth
	 * @return boolean
	 * @deprecated
	 */
	private function setRoles($authAdapter,$auth)
	{
		$success = false;
		$userid = $authAdapter->getResultRowObject('id');
		$storage = $auth->getStorage();
		$storage->write( $authAdapter->getResultRowObject( array ('id','username','password','roleId') ) );
		$success = true;
		//		$args = array('returnClassObject'=>true,'search'=>array('id'=>$userid->id));
		//		$user = new User_Model_User();
		//		$data = $user->findByKey($args);
		//		if( count($data)>0 )
		//		{
		//			$user = array_shift($data);
		//			$role = new Role_Model_Role();
		//			$role = $role->findById($user->getRoleId());
		//			$roleData = array();
		//			$userRoleSession = new Zend_Session_Namespace('wulfStorageUserRole');
		//			$userRoleSession->roleObject = serialize($role);
		//			$success = true;
		//		}
	}
}