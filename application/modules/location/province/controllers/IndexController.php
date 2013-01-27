<?php
/**
 * Created on Sep 21, 2009 by jvazquez
 * @name datesite
 * @package application.modules.region.controllers
 * <p>
 * Controller class for region
 * </p>
 */

class Province_IndexController extends Zend_Controller_Action {
	/**
	 * Main action for Region
	 */
	public function indexAction() {
		$this->view->moduleName = 'Province';
	}
}
?>
