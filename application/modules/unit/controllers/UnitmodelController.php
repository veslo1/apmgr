<?php
/**
 * Created on September 3, 2010 by rnelson
 * @name apmgr
 * @package application.modules.unit.controllers
 * <p>
 * The controller for the unit model actions
 * </p>
 */

class Unit_UnitmodelController extends ZFController_Controller {
	 
	/**
	 *  Creates a unitModel (A1, B2 etc) to tie to the unit
	 */
	public function createunitmodelAction() {
		$form = new Unit_Form_CreateUnitModel();
		$form->setLegend( 'createUnitModel' );
		$form->setForm();
		$this->view->form = $form;
		if ( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams()) ) {
			$model = new Unit_Model_UnitModel($form->getValues());
			$formValues = $form->getValues();
			 
			$amenityId = null;
			if( isset($formValues['amenityId']) )
			$amenityId = $formValues['amenityId'];
			 
			$result = $model->saveUnitModel($amenityId);
			if ($result) {
				$this->setFlashMessage('recordCreatedSuccessfully');
				$this->_helper->redirector('viewallunitmodels', 'unitmodel', 'unit');
			} else {				
				$this->view->msg = $this->getMessage($model->getMessageState());
			}
		}
	}

	/**
	 *  Index - redirects to view all
	 */
	public function indexAction(){
		$this->_helper->redirector('viewallunitmodels', 'unitmodel', 'unit');
	}

       /*
	 *  Delete Unit model
	 */
	public function removeAction() {
		$unitModelId = $this->getRequest()->getParam('unitModelId');

		$model = new Unit_Model_UnitModel();
		$result = $model->delete( $unitModelId );				

                $this->setFlashMessage('recordDeleted');  
                $this->_helper->redirector('viewallunitmodels', 'unitmodel', 'unit');		
	}  // end addtounit function

	/**
	 * Update unit model
	 */
	public function updateunitmodelAction() {
		$id = $this->getRequest()->getParam('modelId');
		if ( !empty ($id) ) {
			$model = new Unit_Model_UnitModel();
			$modelData = $model->findById($id);
			if ( $modelData!==null ) {
				$form = new Unit_Form_CreateUnitModel();

				//	Populate the data
				$form->setLegend( 'updateUnitModel' ); // set legend text since this form is shared with create
				$form->setForm();
				$form->setDefaults( $modelData->toArray() );

				$ua = new Unit_Model_UnitModelAmenity();
				$ua->setUnitModelId( $id );
				$uaData = $ua->getUnitModelAmenities();
				// Populate Amenity Checkboxes
				if( isset($uaData) && $form->getElement('amenityId') ){
				    $form->getElement('amenityId')->setValue( array_keys($uaData) );
				}      
				$this->view->form = $form;

				// Saving form
				if ( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams())  ) {
					$newData = $form->getValues();
					$modelData = new Unit_Model_UnitModel( $newData );
					$modelData->setId( $id );
					$modelData->setName( $form->getValue('name') );
					$saved = $modelData->saveUnitModel($form->getValue('amenityId') );

					if ($saved) {
						$this->setFlashMessage('recordUpdatedSuccessfully');
						$this->_helper->redirector('viewallunitmodels', 'unitmodel', 'unit');
					} else {
					        $this->view->msg = $this->getMessage($modelData->getMessageState());												
					}
				}
			} else {				
				$this->view->msg = $this->getMessage('noRecordFound');
			}
		} else {			
			$this->view->msg = $this->getMessage('noRecordFound');
		}
	}

	/**
	 *  View all unit models
	 */
	public function viewallunitmodelsAction() {

		$model = new Unit_Model_UnitModel();
		$this->view->records = $model->fetchAll( 'name','ASC' );
              
		if( $this->view->records ) {
                  $attached = $model->getAttachedModels();
                  $this->view->attached = $attached;
		    $this->view->paginator = $this->paginate( $this->view->records );
              }
	}

	/**
	 *  View unit model
	 */
	public function viewunitmodelAction() {
		$id = $this->getRequest()->getParam('unitModelId');

		if ( !empty ($id) ) {
			$unitModel = new Unit_Model_UnitModel();
			$unitModel->setId($id);
			$this->view->unitModel = $unitModel->fetchUnitModelDetails();

			$am = new Unit_Model_UnitModelAmenity();
			$am->setUnitModelId( $id );
			$this->view->amenities = $am->getUnitModelAmenities( $id );
		}
		else {
			//TODO create a error message because the id is missing
			$this->view->msg = $this->getMessage('noRecordFound');
		}
	}
}
?>