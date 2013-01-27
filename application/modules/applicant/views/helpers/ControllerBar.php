<?php
/**
 *  Standardize the applicant controller bar
 */
class Applicant_View_Helper_ControllerBar extends ZFHelper_HelperCrud {
	
	public function controllerBar() {		
		return $this->view->bar(array('type'=>'controller','destination'=>'applicant','hiddenElements'=>array('apply','create','delete','backend','waitlist','index','update','error') ));
	}
}
?>
