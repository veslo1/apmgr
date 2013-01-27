<?php
/**
 * Created on Feb 6, 2010 by rnelson
 * @name apmgr
 * @package application.modules.financial.controllers
 * <p>
 * The controller for the main index
 * </p>
 */

class Financial_IndexController extends ZFController_Controller {
	public function indexAction() {
		$this->view->moduleName = 'Financial';

	}

}
?>
