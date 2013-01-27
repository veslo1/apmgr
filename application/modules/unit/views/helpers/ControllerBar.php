<?php
/**
 *  Standardize the unit controller bar
 */
class Unit_View_Helper_ControllerBar extends ZFHelper_HelperCrud {
	
	public function controllerBar() {		
		return $this->view->bar(array('type'=>'controller','destination'=>'unit','hiddenElements'=>array('add','delete','error','index','lease','leasewizard','modelrentschedule','tenant','update') ));
	}
}
?>
