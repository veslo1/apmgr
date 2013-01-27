<?php
/**
 * Created on September 3, 2010 by rnelson
 * @name apmgr
 * @package application.modules.unit.controllers
 * <p>
 * The controller for the unit actions
 * </p>
 */

class Unit_UnitController extends ZFController_Controller {


	/**
	 *  Create single unit
	 */
	public function createunitsingleAction() {
		$unitModelObj = new Unit_Model_UnitModel();
		$models = $unitModelObj->fetchAll();
		
		$apartmentModelObj = new Unit_Model_Apartment();
		$apartments = $apartmentModelObj->fetchAll();		
		
		if(empty($models) ){
			$this->view->msg = 'noUnitModels';
			$this->view->type = 'error';
		}
		else if(empty($apartments) ){			
			$this->view->msg = 'noApartment';
			$this->view->type = 'error';
		}
		else{
			$form = new Unit_Form_CreateUnit();
			$form->setLegend( 'createNewUnit' );  // set legend text since this form is shared with update
			$form->setModels( $models );
			$form->setForm();
			$this->view->form = $form;

			if ( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams()) ) {
				$formValues = $form->getValues();
				$unit = new Unit_Model_Unit($formValues);
				$saved=0;
				if($unit->singleSave()){
					$this->setFlashMessage(array('msg'=>'recordUpdatedSuccessfully','type'=>'success'));
					$this->_helper->redirector('viewallunits', 'unit', 'unit');
				} else {
					$this->view->msg = $unit->getMessageState();
					$this->view->type = 'error';
				}
			}
		} // end if unit model
	}


	/**
	 *  Bulk unit creation
	 */
	public function createunitbulkAction() {
		$unitModelObj = new Unit_Model_UnitModel();
		$models = $unitModelObj->fetchAll();

		$apartmentModelObj = new Unit_Model_Apartment();
		$apartments = $apartmentModelObj->fetchAll();

		if(empty($models)) {
			$this->view->msg = 'noUnitModels';
			$this->view->type = 'error';
		}
		else if(empty($apartments) ) {
			$this->view->msg = 'noApartment';
			$this->view->type = 'error';
		}
		else{
			$form = new Unit_Form_CreateUnit();
			$form->setLegend( 'createBulkUnit' );  // set legend text since this form is shared with update
			$form->setModels( $models );
			$form->setBulk( true );
			$form->setForm();
			$this->view->form = $form;

			if ( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams()) ) {
				$formValues = $form->getValues();
				$unit = new Unit_Model_Unit($formValues);

				$result = $unit->bulkSave( $form->getValue( 'numUnits' ) );

				if ($result) {
					$this->setFlashMessage(array('msg'=>'recordUpdatedSuccessfully','type'=>'success'));
					$this->_helper->redirector('viewallunits', 'unit', 'unit');
				} else {
					$this->view->msg = $unit->getMessageState();
					$this->view->type = 'error';
				}
			}
		}
	}

	/**
	 *  Index - redirects to view all
	 */
	public function indexAction(){
		//$this->_helper->redirector('viewallunits', 'unit', 'unit');
	}


	/**
	 * Update unit
	 * TODO Refactor
	 */
	public function updateunitAction() {
		$unitModelObj = new Unit_Model_UnitModel();
		$models = $unitModelObj->fetchAll();

		if(empty($models)){  // check if models exist
			$this->view->msg = 'noUnitModels';
			$this->view->type = 'error';
		}
		else{
			$id = $this->getRequest()->getParam('unitId');

			if ( empty ($id) ) {
				$this->view->msg = 'noRecordFound';
				$this->view->type = 'error';
			}
			else {
				$unit = new Unit_Model_Unit();
				$unitData = $unit->findById($id);

				if ( $unitData!==null ) {
					$this->view->unitid = $id;
					$data = $unitData->toArray();

					$form = new Unit_Form_CreateUnit();
					$form->setLegend('updateUnit');
					$form->setModels( $models );
					$form->setForm();
					//	Populate the data
					$form->setDefaults( $data );
					$this->view->form = $form;

					// Saving form
					if ( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams())  ) {
						$newData = $form->getValues();
						$unit = new Unit_Model_Unit( $newData );
						$unit->setId( $unitData->getId() );
						$unit->setDateCreated( $unitData->getDateCreated() );

						if($unit->singleSave($data['number'])){
							$this->setFlashMessage(array('msg'=>'recordUpdatedSuccessfully','type'=>'success'));
							$this->_helper->redirector('viewallunits', 'unit', 'unit');
						} else {
							$this->view->msg = $unit->getMessageState();
							$this->view->type = 'error';
						}
					}
				}
			}
		} // end if model
	}

	/**
	 * View all units for a given apartment
	 * */
	public function viewallunitsAction() {
		$aptId = $this->getRequest()->getParam('aptId');
		$this->view->aptId = $aptId;
		$model = new Unit_Model_Unit();
		$column = $this->getRequest()->getParam('by');
		$sort = $this->getRequest()->getParam('sort');
		$this->view->sort = $sort=='ASC'?'DESC':'ASC';
		$records = $model->getApartmentUnits($column,$sort);

		if($records){
			$this->view->attached = $model->getAttachedUnits();
			$this->view->records = $records;
			$this->view->paginator = $this->paginate( $this->view->records  );
		}
	}

	/*
	 public function init(){
	 $uri = $this->_request->getPathInfo();
	 $activeNav = $this->view->navigation()->findByUri($uri);
	 $activeNav->active = true;
	 }
	 */

	public function viewunitAction() {
		$id = $this->getRequest()->getParam('unitId');

		if ( !empty ($id) ) {
			$unit = new Unit_Model_Unit();
			$unit->setId( $id );
			$this->view->unit = $unit->getUnit();
		}
		else {
			//TODO create a error message because the id is missing
			$this->view->msg = $this->getMessage('noRecordFound');
		}
	}

	/**
	 * Display all the units for rent.
	 * This method can be accessed via apartmentId
	 */
	public function unitsforrentAction() {
		$id = $this->getRequest()->getParam('model');
		if( !empty($id) )
		{
			$args = $this->getRequest()->getParams();
			$searchHelper = new Unit_Library_SearchHelper($args);
			$args['id'] = $id;
			$this->view->units = $this->paginate($searchHelper->fetchUnitsToRent($args));
		}
		else
		{
			$this->view->msg = 'modelIdMissing';
		}
	}

	/**
	 *
	 * Show all the images for this unit
	 * TODO Should we add pagination ?
	 */
	public function viewunitgraphicsAction()
	{
		$id = $this->getRequest()->getParam('unitId',null);
		$service = new Unit_Library_Impl_Service();
		$service->prepareUnitFileGraphic();
		$this->view->files = $service->viewUnitsGraphics($id);
		$this->assignMessage($service->getMessageState());
	}

	/**
	 * Display the image / picture
	 */
	public function showAction() {
		$id = $this->getRequest()->getParam('id');
		$service = new File_Library_Impl_Service();
		$dao = new File_Library_Impl_Dao();
		$dao->setTemplate(new File_Model_DbTable_File());
		$service->setDao($dao);
		$image = $service->findById($id);
		if($image!==null)
		{
			$this->view->img = $image->toArray();
		}
		$this->assignMessage($service->getMessageState());
	}

	/*
	 *  Delete Unit
	 */
	public function removeAction() {
		$unitId = $this->getRequest()->getParam('unitId');

		$model = new Unit_Model_Unit();
		$result = $model->delete( $unitId );

		$this->setFlashMessage('recordDeleted');
		$this->_helper->redirector('viewallunits', 'unit', 'unit');
	}  // end addtounit function

	public function myunitAction() {
		$id = $this->getRequest()->getParam('unitId');

		// verify that the unit belongs to this user in a current or past lease
		$helper = new Unit_Library_LeaseHelper();
		if ( !empty ($id) && $helper->verifyMyUnit( $id ) ) {
			$unit = new Unit_Model_Unit();
			$unit->setId( $id );
			$this->view->unit = $unit->getUnit();
		}
		else {
			$this->view->msg = $this->getMessage('noRecordFound');
		}
	}
}
?>
