<?php
/**
 * @package application.modules
 * @subpackage Modules.controllers
 * @author Jorge Vazquez <jvazquez@debserverp4.com.ar>
 * <p>
 * Controller for the Modules module
 * This module allows the admin to view all the modules.
 * </p>
 */

class Modules_IndexController extends Zend_Controller_Action {

	public function indexAction(){}

	public function __toString(){
		return "Role_IndexController";
	}
}