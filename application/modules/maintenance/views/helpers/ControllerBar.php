<?php
/**
 *  Standardize the maintenance controller bar
 */
class Maintenance_View_Helper_ControllerBar extends ZFHelper_HelperCrud {
	
	public function controllerBar() {		
		return $this->view->bar(array('type'=>'controller','destination'=>'maintenance', 'hiddenElements'=>array('error','index' ) ));
	}
}
?>
