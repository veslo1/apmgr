<?php
/**
 * Created on Sep 21, 2009 by jvazquez
 * @name datesite
 * @package application.modules.region.controllers
 * <p>
 * Controller class for region view
 * </p>
 */

class Province_ViewController extends Zend_Controller_Action {

	public function indexAction() {
		$model = new Province_Model_Province();
		$this->view->msg = $this->getRequest()->getParam('message'); // TODO:  this isn't working for some reason....dammit!!

		$sort=$this->_getParam('sort');
		$by=$this->_getParam('by');

		$this->view->records = $model->fetchAll( $by, $sort);

		$page=$this->_getParam('page',1);
		$paginator = Zend_Paginator::factory($this->view->records);

		$paginator->setItemCountPerPage(30);  // TODO needs to be a setting somewhere
		$paginator->setCurrentPageNumber($page);

		Zend_Paginator::setDefaultScrollingStyle('Sliding');
		Zend_View_Helper_PaginationControl::setDefaultViewPartial(
            't3.phtml'  // pass the template needed, which is in application/modules/country/views/scripts   prolly need to put the template in some universally accessible folder
		);

		$this->view->paginator=$paginator;

	}
}
?>
