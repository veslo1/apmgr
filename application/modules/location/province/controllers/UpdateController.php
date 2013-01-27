<?php

/**
 * Created on Sep 20, 2009 by jvazquez
 * @name datesite
 * @package application.modules.permission.controller
 * <p>
 * Controller class for the update page
 * </p>
 */
class Province_UpdateController extends Zend_Controller_Action {
	/**
	 * Index action to update a permission
	 */
	public function indexAction() {
		$id = $this->getRequest()->getParam('id');
		if ( !empty ($id) ) {
			$region = new Province_Model_Province();
			$regionData = $region->findById($id);
			if ( $regionData!==null ) {
				$form = new Province_Form_Create();
				$data = array('id'=>$regionData->getId(),'name'=>$regionData->getName(),'countryId'=>$regionData->getCountry()->getId());
				//	Populate the data
				$form->setDefaults($data);
				$this->view->form = $form;

				// Saving form
				if ( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams())  ) {
					$newData = array('id'=>$regionData->getId(),'name'=>$form->getValue('name'),'countryId'=>$form->getValue('countryId'));
					$region = new Province_Model_Province( $newData );
					$saved = $region->save();

					if ($saved) {
						$this->_helper->redirector('index', 'view', 'province');
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
}
?>
