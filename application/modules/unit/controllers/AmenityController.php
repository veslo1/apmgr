<?php
/**
 * Created on September 3, 2010 by rnelson
 * @name apmgr
 * @package application.modules.unit.controllers
 * <p>
 * The controller for the amenity actions
 * </p>
 */

class Unit_AmenityController extends ZFController_Controller {

	/**
	 * Creates an amenity
	 */
	public function createamenityAction() {
		$form = new Unit_Form_CreateAmenity();
		$form->setLegend( 'createamenity' );  // set legend text since this form is shared with update
		$form->setForm();
		$this->view->form = $form;
		if ( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams()) ) {
			$amenity = new Unit_Model_Amenity($form->getValues());
			$result = $amenity->saveAmenity();
			if ($result) {
				$this->setFlashMessage('recordCreatedSuccessfully');
				$this->_helper->redirector('viewallamenities', 'amenity', 'unit');
			} else {
				//	TODO Generate a message showing why the insert failed
				$this->view->msg = $this->getMessage($amenity->getMessageState());
			}
		}
	}

	/**
	 *  Index - redirects to view all
	 */
	public function indexAction(){
		$this->_helper->redirector('viewallamenities', 'amenity', 'unit');
	}

	/**
	 *  Update amenity
	 */
	public function updateamenityAction() {
		$id = $this->getRequest()->getParam('amenityId');
		if ( !empty ($id) ) {
			$amenity = new Unit_Model_Amenity();
			$amenityData = $amenity->findById($id);
			if ( $amenityData!==null ) {
				$form = new Unit_Form_CreateAmenity();
				$form->setLegend( 'updateAmenity' );  // set legend text since this form is shared with update
				$form->setForm();

				//	Populate the data
				$form->setDefaults( $amenityData->toArray() );
				$this->view->form = $form;

				// Saving form
				if ( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams())  ) {
					$amenityData->setName( $form->getValue('name') );
					$saved = $amenityData->saveAmenity();

					if ($saved) {
						$this->setFlashMessage('recordUpdatedSuccessfully');
						$this->_helper->redirector('viewallamenities', 'amenity', 'unit');
					} else {
						$this->view->msg = $this->getMessage($amenityData->getMessageState());
					}
				}
			} else {
				//TODO create a error message because the id is missing
				$this->view->msg = $this->getMessage('noRecordFound');
			}
		}
	}

	/**
	 *  View all amenities
	 */
	public function viewallamenitiesAction() {
		//$this->view->moduleName = 'Apartment';

		$model = new Unit_Model_Amenity();
		
		//  Will need to modify to only show apartments the user has access to view
		$this->view->records = $model->fetchAll('name','ASC');
                $this->view->attached = $model->getAttachedAmenities();		

		if( $this->view->records ){
		    $this->view->paginator = $this->paginate( $this->view->records );
		}		
	}
	
	/*
	 *  Remove Amenity
	 */
	public function removeAction() {
		$amenityId = $this->getRequest()->getParam('amenityId');

		$model = new Unit_Model_Amenity();
		$result = $model->delete( $amenityId );				

                $this->setFlashMessage('recordDeleted');  
                $this->_helper->redirector('viewallamenities', 'amenity', 'unit');		
	}  // end addtounit function
}
?>
