<?php
/**
 *  Wrap up the controller bar for the module user
 *  @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 *  @package application.modules.user.views.helpers
 */
class User_View_Helper_ControllerBar extends ZFHelper_HelperCrud
{
	public function controllerBar()
	{		
		return $this->view->bar(array('type'=>'controller','destination'=>'user', 'hiddenElements'=>array('update','error','join','login') ));
	}
}
?>
