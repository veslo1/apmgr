<?php
/**
 * Created on September 3, 2010 by rnelson
 * @name apmgr
 * @package application.modules.unit.controllers
 * <p>
 * The controller for the apartment actions
 * </p>
 */

class Unit_ApartmentController extends ZFController_Controller {

	/**
	 * Creates an apartment
	 */
	public function createapartmentAction() {
		$form = new Unit_Form_CreateApartment();
		$form->setLegend( 'createNewApartment' );  // set legend text since this form is shared with update
		$form->setForm();
		$form->setDefaults( array('country'=>'USA') );
		$this->view->form = $form;

		if ( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams()) ) {
			$apt = new Unit_Model_Apartment($form->getValues());
			$result = $apt->saveApartment();
			 
			if ($result) {
				$this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
				$this->_flashMessenger->addMessage('recordCreatedSuccessfully');
				$this->_helper->redirector('viewallapartments', 'apartment', 'unit');
			} else {
				// message showing why the insert failed
				$this->view->msg = $this->getMessage('errorSaving');
			}
		}
	}

	public function deleteapartmentAction() {
		$result = false;
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		$id = $this->getRequest()->getParam('id');
		$apt = new Unit_Model_Apartment();

		$aptExists = $apt->findById($id);

		if( $aptExists ) {
			$result = $apt->delete($id);
		}

		$msg = ($result)? $msg='Deleted' : $msg='Error';
		//TODO Centralize the code ?. Discuss with rach
		$cache = Zend_Registry::get('cache');
		$tag = "allUnits".$id;
		$cache->remove($tag);

		$this->_helper->redirector('index', 'index', 'apartment',array('msg'=> $msg) );
	}

	/**
	 *  Index - redirects to view all
	 */
	public function indexAction(){
		$this->_helper->redirector('viewallapartments', 'apartment', 'unit');
	}

	/**
	 * Update apartment
	 */
	public function updateapartmentAction() {
		$id = $this->getRequest()->getParam('aptId');
		if ( !empty ($id) ) {
			$apt = new Unit_Model_Apartment();
			$aptData = $apt->findById($id);
			if ( $aptData!==null ) {
				$form = new Unit_Form_CreateApartment();

				//	Populate the data
				$form->setLegend( 'updateApartment' ); // set legend text since this form is shared with create
				$form->setForm();

				$aptArray = $aptData->toArray();
				$form->populateForm($aptArray);
				$this->view->form = $form;

				// Saving form
				if ( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams())  ) {
					$newData = $form->getValues();
					$apt = new Unit_Model_Apartment( $newData );
					$apt->setId( $aptData->getId() );
					$apt->setDateCreated( $aptData->getDateCreated() );
					$saved = $apt->save();

					if ($saved) {
						$this->setFlashMessage('recordUpdatedSuccessfully');
						$this->_helper->redirector('viewallapartments', 'apartment', 'unit');
					} else {
						$this->view->msg = $this->getMessage('errorSaving');
					}
				}
			} else {
				// error message because the record does not exists
				$this->view->msg = $this->getMessage('noRecordFound');
			}
		} else {
			// error message because the id is missing
			$this->view->msg = $this->getMessage('noRecordFound');
		}
	}

	/**
	 *  View all the apartments
	 */
	public function viewallapartmentsAction() {
		$model = new Unit_Model_Apartment();
		$this->view->records = $model->fetchAll();
	}

	/**
	 *  View apartment details
	 */
	public function viewapartmentAction() {
		$id = $this->getRequest()->getParam('aptId');
		if ( !empty ($id) ) {
			$apt = new Unit_Model_Apartment();
			$aptData = $apt->findById($id);
			if ( $aptData!==null )
			$this->view->apartment = $aptData;
			else {
				//TODO create a error message because the record does not exists
				$this->view->msg = $this->getMessage('noRecordFound');
			}
		} else {
			//TODO create a error message because the id is missing
			$this->view->msg = $this->getMessage('noRecordFound');
		}
	}
}
?>
