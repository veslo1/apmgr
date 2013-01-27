<?php
/**
 * Created on September 3, 2010 by rnelson
 * @name apmgr
 * @package application.modules.unit.controllers
 * <p>
 * The controller for the model rent schedule actions
 * </p>
 */

class Unit_ModelrentscheduleController extends ZFController_Controller {

	public function indexAction(){
	}

	/**
	 *  Create rent schedule for model
	 */
	public function createmodelrentscheduleAction() {
		$formControl = new ZFForm_FormControl();
		$payload = $this->getRequest()->getParams();
		$form = $formControl->repopulateForm(array('name'=>'Unit_Form_CreateRentSchedule','formName'=>'schedule','childForm'=>'Unit_Form_SubCreateRentSchedule'),$payload);
		$this->view->form = $form;
		$modelId = $this->getRequest()->getParam('modelId');
		$this->view->modelId = $modelId;
		
		if( $this->getRequest()->getParam('submit')
		    and $formControl->validateForm($form,$this->getRequest()->getParams()) ) {
			//	If he says that he is going to save , just try this
			$iterator = new Unit_Library_ScheduleFilterIterator(new ArrayIterator($this->getRequest()->getParams()));
			$month = array();
			$amount = array();
			$effDate = null;
			$modelId = $this->getRequest()->getParam('modelId');
			
			try {
				$createObj = new Unit_Model_CreateModelRentSchedule();
				foreach($iterator as $key=>$value) {
					if(array_key_exists('effectiveDate',$value)){
						$effDate = $value['effectiveDate'];
					}
					$month[] = $value['month'];
					$amount[] = $value['amount'];
				}
				$createObj->setUnitModelId($modelId);
				$createObj->setEffectiveDate($effDate);
				$createObj->setNumMonths($month);
				$createObj->setRentAmount($amount);
				
				if($createObj->saveRentSchedule()){
					$this->setFlashMessage('recordUpdatedSuccessfully');					
					$this->_helper->redirector('viewallmodelrentschedule', 'modelrentschedule', 'unit',array('modelId'=>$modelId));
				} else {
					$this->view->msg = $this->getMessage( $createObj->getMessageState()  );										
				}				
			} catch (Zend_Db_Exception $e) {
				$this->view->msg = $this->getMessage('errorSaving');
			}
		}		
		
	} // end function
	 
	/**
	 *  Used to verify the dynamic fields for creating model rent schedule
	 *  This is kinda lame
	 */
	private function validateDynamicFields( $numMonths, $rentAmount ) {
		if( !isset( $numMonths ) && !isset($rentAmount))
		return false;
		else {
			foreach( $numMonths as $id=>$value ) {
				if( empty( $value ) || empty( $rentAmount[$id] ) )
				return false;
			}
		}
		return true;
	}

	/**
	 *  Needs model id to pull the model rent info
	 **/
	public function viewallmodelrentscheduleAction() {
		// 	    $this->view->moduleName = 'ModelRentSchedule';

		$id = $this->getRequest()->getParam('modelId');
		$this->view->modelId = $id;
		
		if( !empty( $id ) ) {
			$model = new Unit_Model_ModelRentSchedule();
			$unitmodel = new Unit_Model_UnitModel();
			$um = $unitmodel->findById( $id );

			$this->view->records = $model->findByKey(array('search'=>array('unitModelId'=>$id)));
			$this->view->unitmodel = $um;

			if( $this->view->records ){
 			    $this->view->attached = $model->getAttachedSchedules();
 			    $this->view->paginator = $this->paginate( $this->view->records );
 			}
		}
	}

	/**
	 * Pulls  individual model schedule
	 **/
	public function viewmodelrentscheduleAction() {
		$id = $this->getRequest()->getParam('scheduleId');
		
		$modelId = $this->getRequest()->getParam('modelId');
		$this->view->modelId = $modelId;
		
		$model = new Unit_Model_ModelRentSchedule();
		$model->setId( $id );
		$records = $model->getSchedule();
		$this->view->records = $records;

		if( $records ) {
			$row = array_shift($records);
			$unitmodel = new Unit_Model_UnitModel();
			$um = $unitmodel->findById( $row['unitModelId'] );
			$this->view->unitmodel = $um;
		}
	}
        
	/*
 	 *  Delete rent schedule
 	 */
 	public function removeAction() {
 	    $scheduleId = $this->getRequest()->getParam('scheduleId');
 	    $modelId = $this->getRequest()->getParam('modelId');
 
 	    $model = new Unit_Model_ModelRentSchedule();	    
 	    $result = $model->delete( $scheduleId );	    
 
            $this->setFlashMessage('recordDeleted');	   
            $this->_helper->redirector('viewallmodelrentschedule', 'modelrentschedule', 'unit', array('modelId'=>$modelId) );		
 	}
}
?>
