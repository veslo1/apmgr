<?php

/**
 * Created on Dec 5, 2009 by rnelson
 * @name apmgr
 * @package application.modules.unit.controllers
 * <p>
 * Controller class for unit, update page
 * </p>
 */
class Unit_UpdateController extends ZFController_Controller {
	/**
	 * Index action to update a permission
	 */
	/*
	 public function indexAction() {
	 $id = $this->getRequest()->getParam('unitId');
		if ( !empty ($id) ) {
		$unit = new Unit_Model_Unit();
		$unitData = $unit->findById($id);
		if ( $unitData!==null ) {
		$form = new Unit_Form_Create();
		$data = array('id'=>$unitData->getId(),'apartmentId'=>$unitData->getApartment()->getId(),'number'=>$unitData->getNumber());
		//	Populate the data
		$form->setDefaults($data);
		$this->view->form = $form;

		// Saving form
		if ( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams())  ) {
		$newData = array('id'=>$unitData->getId(),'name'=>$form->getValue('name'),'apartmentId'=>$form->getValue('apartmentId'),'number'=>$form->getValue('number'));
		$unit = new Unit_Model_Unit( $newData );
		$saved = $unit->save();

		if ($saved) {
		$this->_helper->redirector('index', 'index', 'unit');
		} else {
		$this->view->message = "";
		//TODO provide a message that explains that the save couldn't be made
		}
		} else {
		// TODO the update failed, or it wasn't a valid post
		}
		} else {
		//TODO create a error message because the record does not exists
		}
		} else {
		//TODO create a error message because the id is missing
		}
		}
		*/
	 
        /*
	public function getregionsAction() {
		//	This tells the application that we do not want to render the page
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		$region = new Province_Model_Province();
		$cid = $this->getRequest()->getParam('countryId');

		$results=array();

		$selRegion = $region->findByKey( 'countryId', $cid );

		foreach ( $selRegion as $id=>$object ) {
			$results[]= array( 'value'=>$object->getId(),'name'=>$object->getName() );
		}

		echo Zend_Json::encode( $results );
	}
	*/

	/**
	 *  Update rent proration settings
	 */
	public function updaterentprorationsettingsAction(){
		$form = new Unit_Form_UpdateRentProrationSettings();
		$form->setForm();

		$currSettingObj = new Unit_Model_RentSettings();
		$currSetting = $currSettingObj->getSetting();
		 
		if($currSetting) {
			$form->populate( $currSetting->toArray() );
		}

		$this->view->form = $form;

		if ( $this->getRequest()->isPost()
		and $form->isValid($this->getRequest()->getPost()) ) {
		  
			$formValues = $form->getValues();
			$setting = new Unit_Model_RentSettings( $formValues );

			if( $currSetting )  // if setting exists, set its id.  otherwise create it new
			$setting->setId(1);

			if( $setting->save() )
			$this->_helper->redirector('index', 'index', 'unit');
			else
			$this->view->messages = $this->getMessage('errorSaving');
		}
	}
}
?>
