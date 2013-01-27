<?php
/**
 * Created on Dec 5, 2009 by rnelson
 * @name apmgr
 * @package application.modules.unit.controllers
 * <p>
 * The controller for the main view
 * </p>
 */

class Unit_IndexController extends ZFController_Controller {

	public function indexAction(){
	}

	public function unitmodelindexAction() {
		$sort=$this->_getParam('sort');
		$by=$this->_getParam('by');
		$model = new Unit_Model_UnitModel();
		$records = $model->fetchAll( $by, $sort,true);
		$this->view->sort = ( $sort=='ASC') ? 'DESC' : 'ASC';
		$this->view->unitModels= $this->paginate($records);
	}

	public function amenityindexAction() {
		$sort=$this->_getParam('sort');
		$by=$this->_getParam('by');
		$model = new Unit_Model_Amenity();
		$records = $model->fetchAll( $by, $sort,true);
		$this->view->amenities = $this->paginate( $records);
		$this->view->sort = ( $sort=='ASC') ? 'DESC' : 'ASC';
	}
}
?>
