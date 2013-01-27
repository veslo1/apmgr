<?php
/**
 * Created on July 7, 2010 by rnelson
 * @name apmgr
 * @package application.modules.maintenance.controllers
 * <p>
 * Controller class for the maintenance view pages
 * </p>
 */
class Maintenance_SettingController extends ZFController_Controller {
	/**
	 *  Entry point into the maintenance page
	 */
	public function configureAction(){
		$form = new Maintenance_Form_Settings();
		 
		$currSettingObj = new Maintenance_Model_MaintenanceSettings();
		$currSetting = $currSettingObj->getSetting();
		 
		if($currSetting) {
			$form->setRoleId( $currSetting->getRoleId() );
			$form->setForm();
			$form->populate( $currSetting->toArray() );
		}
		else{
			$form->setForm();
		}

		$this->view->form = $form;
		if ( $this->getRequest()->isPost()
		and $form->isValid($this->getRequest()->getPost()) ) {
		  
			$formValues = $form->getValues();
			$setting = new Maintenance_Model_MaintenanceSettings( $formValues );

			if( $currSetting )  // if setting exists, set its id.  otherwise create it new
			$setting->setId(1);

			if( $setting->save() )
			$this->_helper->redirector('index', 'index', 'maintenance');
			else
			$this->view->messages = $this->getMessage('errorSaving');;
		}
		else
		$this->view->messages = $this->getMessage('postError');
	}

        /**
	 *  Index - redirects to view all
	 */
	public function indexAction(){
		$this->_helper->redirector('viewsettings', 'setting', 'maintenance');
	}

        /**
	 *  Populates the default assigned to select boxes
	 */
	public function populatedefaultassignedtoAction() {
		//	This tells the application that we do not want to render the page
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		$userHelper = new User_Library_Helper_Utils();
		$roleId = $this->getRequest()->getParam('roleId');
		 
		$results=array();

		$users = $userHelper->getUsersByRoleId($roleId);
		if($users)
		{
			foreach ( $users as $id=>$user )
			{
				$results[]= array( 'value'=>$user['id'],'name'=>$user['fullName'] );
			}
		}
		echo Zend_Json::encode($results);
	}
	
	/**
	 *  View all maintenance settings
	 */
	public function viewsettingsAction() {
		$currSettingObj = new Maintenance_Model_MaintenanceSettings();
		$currSetting = $currSettingObj->fetchSetting();
		$this->view->setting = $currSetting;		
	}

} // end class
?>
