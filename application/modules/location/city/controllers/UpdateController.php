<?php
/**
 * Created on Sep 13, 2009
 * RoleController.php
 * jvazquez
 * @package modules.role.controllers
 * <p>
 * This controller handles the Roles in the System
 * So far this is the best thing I can achieve to load the module. All the other options are just <strong>lunatic</strong> solutions
 * More than 5 classes loaded to load a file. It may allow you <strong>dynamic</strong> model loading, but the load on the server
 * is just <strong>stupid</strong>.
 * </p>
 */

class City_UpdateController extends Zend_Controller_Action {

	public function indexAction() {
		$id = $this->getRequest()->getParam('id');
		if ( !empty ($id) ) {
			$city = new City_Model_City();
			$cityData = $city->findById($id);
			if ( $cityData!==null ) {
				$form = new City_Form_Update();
				$data = array('id'=>$cityData->getId(),'name'=>$cityData->getName(),'provinceId'=>$cityData->getProvince()->getId(), 'countryId'=>$cityData->getProvince()->getCountry()->getId());

				//	Populate the data on the form
				$form->setDefaults($data);

				// set province options
				$province = new Province_Model_Province();
				$prov = $province->findByKey('countryId', $form->getElement('countryId')->getValue() );

				foreach ( $prov as $p)
				$form->getElement('provinceId')->addMultiOption($p->getId(), $p->getName());

				$this->view->form = $form;

				// Saving form
				if ( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams())  ) {
					$newData = array('id'=>$cityData->getId(),'name'=>$form->getValue('name'),'provinceId'=>$form->getValue('provinceId'));
					$city = new City_Model_City( $newData );
					$saved = $city->save();

					if ($saved) {
						$this->_helper->redirector('index', 'view', 'city');
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
}
?>
