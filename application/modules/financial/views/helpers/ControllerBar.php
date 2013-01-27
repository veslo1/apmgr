<?php
/**
 *  Standardize the financial controller bar
 */
class Financial_View_Helper_ControllerBar extends ZFHelper_HelperCrud {
	
	public function controllerBar() {		
		return $this->view->bar(array('type'=>'controller','destination'=>'financial', 'hiddenElements'=>array('error','index', 'payment', 'accounttransaction', 'bill' ) ));
	}
}
?>
