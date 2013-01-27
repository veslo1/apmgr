<?php
/**
 * Created on Sep 28, 2009
 * JoinController.php
 * @author Jorge Vazquez <jvazquez@debserverp4.com.ar>
 *
 */
class User_JoinController extends ZFController_Controller {

	/**
	 * Main action to create accounts in the system.
	 * @return unknown_type
	 */
	public function indexAction() {
		$control = new ZFWorkflow_WorkflowControl();
		$workflowRegistered = $control->getWorkFlowRegistered();
		if( true==$workflowRegistered ) {
			$form = new User_Form_Join();
			$form->setLegend( 'createUser' ); 
			$form->setForm();
			if ( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams() ) ) {			
				$joinHelper = new User_Library_Helper_Join($this->getRequest()->getParams());
				$id = $joinHelper->createAccount();
				if ( $id!=false and $joinHelper->authenticate($this->isLoggedin(),$id)!=false ) {
					//	Determine which workflow is active and go with the return url of that one
					//TODO This seems like a good spot to lock the session for wf when we are applying to a hosue
					$desturl = $control->passUser(array('userid'=>$id));
					$desturl = !empty($desturl)?$desturl:User_Library_Helper_Join::DEFAULTPAGE;
					$this->_redirector = $this->_helper->getHelper('Redirector');
					$this->_redirector->gotoUrl($desturl);
				}				
				$this->view->msg = array('msg'=>$joinHelper->getMessageState(),'type'=>'error');
			}			
			$this->view->form = $form;
		} else {
			$this->view->msg = array('msg'=>'noWorkflowRegistered','type'=>'error');
		}
	}
}
?>