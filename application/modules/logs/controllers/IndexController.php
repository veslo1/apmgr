<?php
/**
 *@package application.modules
 *@subpackage roles.controllers
 *<p>
 *	Backend section for the forensic module.
 *	This module, will show all the logs in the application, Text Logs, Db Logs.
 *</p>
 */

class Logs_IndexController extends Zend_Controller_Action {

	public function indexAction() {
		$this->view->actions = array('db','text');
	}

	public function dbAction() {
		$log = new Logs_Model_Logs();
		$column = $this->getRequest()->getParam('by');
		$sort = $this->getRequest()->getParam('sort');
		$this->view->logs = $log->fetchAll($column,$sort);
		$page=$this->_getParam('page',1);
		$paginator = Zend_Paginator::factory($this->view->logs);
		$paginator->setItemCountPerPage(10);
		$paginator->setCurrentPageNumber($page);

		Zend_Paginator::setDefaultScrollingStyle('Sliding');
		Zend_View_Helper_PaginationControl::setDefaultViewPartial('t3.phtml');

		$this->view->paginator=$paginator;
	}

	/**
	 * Display all the files that we have on the filesystem.
	 * When the user clicks in one file, he will be able to view it.
	 */
	public function textAction() {
		$files = new Logs_Model_Files();
		$this->view->files = $files->fetchAll();
	}

	public function readAction() {
		$files = new Logs_Model_Files();
		$filename = $this->getRequest()->getParam('filename');
		if( !empty($filename) ){
			$this->view->filecontent = $files->fetchByFilename(APPLICATION_LOGS.DIRECTORY_SEPARATOR.$filename);
			$this->view->filename = $filename;
			$this->view->fullpath = APPLICATION_LOGS.DIRECTORY_SEPARATOR.$filename;
		}
	}
}
?>