<?php
/**
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * <p>Abstract class that handles the instantiation of the Zend_Controller Action. We won't override anything in here</p>
 */

abstract class ZFController_Controller extends Zend_Controller_Action implements ZFInterfaces_Messageable
{
	/**
	 * hold a state name
	 * @var string
	 */
	protected $state;

	/**
	 * The default action we are redirected
	 * @var string
	 */
	static $ACTION = 'index';

	/**
	 * The default error message
	 * @var const
	 */
	static $DFTMSG = 'unhandledMsg';

	/**
	 * 
	 * Logger
	 * @var ZFObserver_Forensic
	 */
	protected  $log;
	
	/* (non-PHPdoc)
	 * @see library/Zend/Controller/Zend_Controller_Action::init()
	 */
	public function init()
	{
		$this->getFlashMessages();
		$this->log = new ZFObserver_Forensic();
		$this->log->setStatus(ZFObserver_Forensic::INFO);
	}

	/**
	 * This action handles the minimize action for every controller. It will generate an entry in the session, and will send you back to the index page
	 * of the current module that you are watching.
	 * @return void
	 */
	protected function minimizeAction() {
		$docklet = new Zend_Session_Namespace('Docklet');
		//	Forge the URL that the user sent us
		$baseurl = Zend_Controller_Front::getInstance()->getBaseUrl() ? Zend_Controller_Front::getInstance()->getBaseUrl() : "/";
		$module = $this->getRequest()->getModuleName();
		$controller = $this->getRequest()->getControllerName();
		$action = $this->getRequest()->getActionName();
		$referrer = $this->getRequest()->getParam('referrer');
		$url = $baseurl.$module."/".$controller."/".$referrer;

		$action = new Modules_Model_Actions();
		$icon = array_shift($action->fetchModuleController($module,$controller));
		/**
		 * If the session was created, seek over it, and check that we don't have that value if so, append it.
		 * If we did not had a session, just append the url and you are done
		 */
		if( is_array($docklet->icons) ) {
			$it = new RecursiveIteratorIterator( new RecursiveArrayIterator($docklet->icons));
			$found = array();
			while($it->valid()) {
				if( $it->key()=='url' and strcmp($it->current(),$url)==0 ) {
					$found[] = true;
				}
				$it->next();
			}
			if(!in_array(true,$found)) {
				$docklet->icons[] = array('image'=>$icon['icon'],'url'=>$url);
			}
		} else {
			$docklet->icons = array();
			$docklet->icons[] = array('image'=>$icon['icon'],'url'=>$url);
		}
		$this->_helper->redirector(self::$ACTION, self::$ACTION, $module);
	}



	/**
	 * paginates the records
	 * @param array $records
	 * @return Zend_Paginator
	 * TODO:  place the template in a globally accessible location
	 */
	public function paginate( $records  ) {
		$page = $this->getRequest()->getParam('page');

		//  	When you send null, it dies because the paginator can't paginate a null
		if( !isset($records) or count($records)==0 ) {
			$records = array();
			$this->view->msg ='noRecordsToShow';
			$this->view->recordsPopulated = 0;
			//			$this->view->msg = $this->getMessage('noRecordsToPaginate');
		}
		else
		{
			$this->view->recordsPopulated = count($records);
		}

		$paginator = Zend_Paginator::factory($records);
		$config = new Zend_Config_Ini(APPLICATION_PATH.'/configs/application.ini',APPLICATION_ENV);
		$paginator->setItemCountPerPage($config->appsettings->pagination->records);
		$paginator->setCurrentPageNumber($page);
		Zend_Paginator::setDefaultScrollingStyle($config->appsettings->pagination->style);
		Zend_View_Helper_PaginationControl::setDefaultViewPartial( $config->appsettings->pagination->control );
		return $paginator;
	}

	/**
	 * Return a message object
	 * @param string $identifier
	 * @return Messages_Model_Messages
	 */
	public function getMessage($identifier='unhandledMsg') {
		$message = new Messages_Model_Messages();
		$result  = $message->findByKey(array('returnClassObject'=>true,'search'=>array('identifier'=>$identifier)));
		//  If we have a empty result , just use the default one
		if( empty($result) ) {
			$result  = array_shift($message->findByKey(array('returnClassObject'=>true,'search'=>array('identifier'=>self::$DFTMSG))));
		} else {
			$result = array_shift($result);
		}
		return $result;
	}

	/**
	 * Determine if the current user is an admin
	 */
	public function isAdmin() {
		$isAdmin = false;
		$auth = Zend_Auth::getInstance();
		$auth->setStorage(new Zend_Auth_Storage_Session('vazneyStorage'));
		if( $auth->getIdentity() )
		{
			$userid = $auth->getIdentity()->id;
			$roleId = $auth->getIdentity()->roleId;
			$role = new Role_Model_Role();
			$roleData = $role->findById( $roleId );
			$isAdmin = $roleData->getName()=='admin'?true:false;
		}
		return $isAdmin;
	}

	/**
	 * Determine if the user is logged in
	 * @return boolean
	 */
	public function isLoggedin() {
		$auth = Zend_Auth::getInstance();
		$auth->setStorage(new Zend_Auth_Storage_Session('vazneyStorage'));
		return $auth->getIdentity()!=null;
	}

	/**
	 *  Handle the display of flash messages for the action.  The view file will need the appropriate code for displaying the messages.
	 */
	public function getFlashMessages()
	{
		$this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
		$strMessage = $this->_flashMessenger->getMessages();		
		if( !empty($strMessage) )
		{			
			$strMessage = array_shift($strMessage);			
			if( is_array($strMessage) && $strMessage['msg'] )
			{				
				$this->view->msg = $strMessage['msg'];
				$this->view->type = $strMessage['type'];				
			}
			else
			{				
				$msg = $this->getMessage($strMessage);				
				$this->view->msg = $msg->getMessage();
				$this->view->type = $msg->getCategory();				
			}			
		}
		$this->_flashMessenger->clearMessages();
	}

	/**
	 *  Set flash message
	 */
	public function setFlashMessage($message){
		$this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
		$this->_flashMessenger->addMessage($message);
	}

	/* (non-PHPdoc)
	 * @see library/ZFInterfaces/ZFInterfaces_Messageable::setMessageState()
	 */
	public function setMessageState($msg){
		$this->state = $msg;
	}

	/* (non-PHPdoc)
	 * @see library/ZFInterfaces/ZFInterfaces_Messageable::getMessageState()
	 */
	public function getMessageState(){
		return $this->state;
	}
	
	/**
	 * Set's the view elements with the new format for retrieving messages
	 * The args element is composed by a 'msg' and a 'type' keys , that contains
	 * respectively a token and a type of error , that could be error,success,warning
	 * @param array $args
	 */
	public function setMessage(array $args=null)
	{
		if($args!=null)
		{
			$this->view->msg = $args['msg'];
			$this->view->type = $args['type'];
		}
	}
	
	/**
	 * 
	 * Method used when you are not redirecting controllers
	 * @param array $msg
	 */
	public function assignMessage(array $msg=null)
	{
		if( isset($msg['msg']) and isset($msg['type']) )
		{
			$this->view->msg = $msg['msg'];
			$this->view->type = $msg['type'];
		}
	}
}
?>