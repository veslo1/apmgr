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

class Country_ViewController extends Zend_Controller_Action {

	public function indexAction() {
		$model = new Country_Model_Country();
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
