<?php
/**
 * Created on Sep 26, 2009 by jvazquez
 * @package library.ZFAcl.Plugin
 * This class is loaded on each request, and it handles the proper access to sections.
 * If the user is not in the Acl, he may not see the section that he's trying to access
 * @example /usr/local/www/apmgr/library/ZFAcl_Acl/Plugins/Acl.php In the comments on that file, you can see the description on how the ACL works
 * public function isAllowed($role = null, $resource = null, $privilege = null)
 * print "rolename::$roleName requests acccess to $resource to perform $action<br/>";
 */

class ZFAcl_Plugin_Acl extends Zend_Controller_Plugin_Abstract
{
	/* (non-PHPdoc)
	 * @see library/Zend/Controller/Plugin/Zend_Controller_Plugin_Abstract::preDispatch()
	 */
	public function preDispatch(Zend_Controller_Request_Abstract $request)
	{
		$misses = false;
		$loggedin = false;
		$auth = Zend_Auth::getInstance();
		$auth->setStorage(new Zend_Auth_Storage_Session('vazneyStorage'));
		$rolePermission = new Role_Model_RolePermissions();
		$storage = $auth->getStorage();
		$perms = Zend_Registry::get('properties');
		$roleId = $perms->appsettings->role->request;

		$logger = new ZFObserver_Forensic();
		$logger->attach(new ZFObserver_Observers_Db());
		$logger->attach(new ZFObserver_Observers_Text());
		$logger->setStatus(ZFObserver_Forensic::ERR);

		if ( $auth->getIdentity() )
		{
			$loggedin = true;
			$roleId =	$auth->getIdentity()->roleId;
		}
		// In a modular application, the controller becames the action, keep this in mind
		$resource = $request->getModuleName();
		$action = $request->getControllerName();
		$permissions = $rolePermission->fetchRoleAccessToAction($resource,$action,$request->getActionName(),$roleId);
		$permissionCount = count($permissions);
		if( 0==$permissionCount and $roleId!=1)
		{
			$logger->notify("Acl", "{$roleId} does not has access to {$resource}/{$action}/{$request->getActionName()}");
			$misses = true;
		}
		if( true==$misses )
		{
			if( false==$loggedin )
			{
				$gotourl = join('/', $request->getParams() );
				$gotourl ="/".$gotourl;
				if( stristr($gotourl, 'favicon.ico')!=true )
				{
					$logger->notify("Acl","We set the desturl to $gotourl");
					//	Begin tracking the session for the user that attempted an action
					$urlReminder = new Zend_Session_Namespace('access');
					if ( !isset($urlReminder->initialized) )
					{
						Zend_Session::regenerateId();
						$urlReminder->initialized = true;
					}
					// Store the url that the user was going to before login in /applicant/apply/index/1/3/1 This is stored in the the session for the current user
				}
				$urlReminder->destination = $gotourl;
				//  This performs a clean redirect, *but* the login page has to be accesible to the public role,`guest`, else you end up in a loop
				$this->_response->setRedirect('/user/login/index');
			}
			else
			{
				$logger->notify("Acl","We set the desturl to default/error/noaccess");
				$request->setModuleName('default');
				$request->setControllerName('error');
				$request->setActionName('noaccess');
			}
		}
	}
}
?>