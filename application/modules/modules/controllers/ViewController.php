<?php
/**
 * View controller for the modules section
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 */

class Modules_ViewController extends ZFController_Controller {

	/**
	 * Display all the options that are possible for a view
	 * @return
	 */
	public function indexAction(){

	}

	/**
	 * Display all modules
	 */
	public function viewallmodulesAction() {
		$modules = new Modules_Model_Modules();
		$this->view->modules = $modules->fetchAll();

		$page = $this->_getParam('page', 1);
		$paginator = Zend_Paginator :: factory($this->view->modules);
		//TODO Should this be a setting ?.
		$paginator->setItemCountPerPage(10);
		$paginator->setCurrentPageNumber($page);

		Zend_Paginator :: setDefaultScrollingStyle('Sliding');
		Zend_View_Helper_PaginationControl :: setDefaultViewPartial('t4.phtml');

		$this->view->paginator = $paginator;
	}
}