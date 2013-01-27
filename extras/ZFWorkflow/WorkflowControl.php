<?php
/**
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * <p>Proxy for the workflow objects</p>
 */
class ZFWorkflow_WorkflowControl implements ZFObserver_ILogeable {
	/**
	 * @return string
	 */
	public function passUser(array $args=null) {
		$logger = new ZFObserver_Forensic();
		$logger->attach(new ZFObserver_Observers_Db());
		$logger->attach(new ZFObserver_Observers_Text());
		$logger->setStatus(ZFObserver_ILogeable ::INFO);
		$logger->notify($this, "WorkflowControl called with args['userid']={$args['userid']}");

		$desturl = '';
		$helper = new Applicant_Library_WaitListHelper();
		$awh = new Applicant_Library_WorkflowHelper();
		//	We are applying to a wait list
		$logger->notify($this, "Doing checks , first checking wait list");
		$wActive = $helper->isActive($helper->getSessionNamespace())?1:0;
		$logger->notify($this,"Results say that wait list is {$wActive}");

		if( $helper->isActive($helper->getSessionNamespace() ) !=null ) {
			$orders = $helper->getSessionStepsKey('end');
			$desturl = join('/',array($orders['module'],$orders['controller'],$orders['action']));
			$helper->setSessionSteps('userid',$args['userid']);
			$logger->notify($this, "User {$args['userid']} will go to {$desturl}");
		} elseif($awh->isActive($awh->getSessionNamespace())!=null ) {
			//	We are applying to a unit
			$logger->notify($this,"Working on apply process");
			$applicant = new Applicant_Model_Applicant();
			$applicant->setUserId($args['userid']);
			$logger->notify($this,"The seed for applicant::userId is = {$args['userid']}");
			$logger->notify($this,"Preparing to save the applicant with user id {$applicant->getUserId()}");
			try{
				$applicantId = $applicant->save();
				if( false===$applicantId ) {
					//TODO Email the user and us.
					//	Clean the user since application failed
					$user = new User_Model_User();
					$user->delete($args['userid']);
					$logger->notify($this,"Purging records for user {$args['userid']} due to caught exception");
				}
				$logger->notify($this, "Applicant created properly, application moves on, the id is {$applicantId}");
				$awh->setSessionSteps('applicantId',$applicantId);
				$awh->updateStep(array('payload'=>$args['userid'],'name'=>'one','current'=>0,'complete'=>1,'applicantId'=>$applicantId));
				$orders = $awh->getSessionStepsKey('steps');
				$desturl = $orders['one']['next'];
				$logger->notify($this, "User {$args['userid']} will go to {$desturl}");
			} catch(Zend_Db_Exception $e) {
				$user = new User_Model_User();
				$user->delete($args['userid']);
				$logger->notify($this,"Purging records for user {$args['userid']} due to caught exception");
				$logger->notify($this,"Zend_Db_Exception caught {$e->getMessage()}");
			} catch (Applicant_Library_Exception $e ) {
				$logger->notify($this,"Applicant_Library_Exception Caught with message {$e->getMessage()}");
			}
		}
		$logger->notify($this, "User {$args['userid']} leaves workflow control with {$desturl}");
		return $desturl;
	}

	/**
	 * Determine if there is a registered workflow
	 * @return boolean
	 */
	public function getWorkFlowRegistered(){
		$helper = new Applicant_Library_WaitListHelper();
		$awh = new Applicant_Library_WorkflowHelper();
		$buffer[] = $helper->isActive($helper->getSessionNamespace())!=null?true:false;
		$buffer[] = $awh->isActive($awh->getSessionNamespace())!=null?true:false;
		return in_array(true,$buffer);
	}

	/**
	 * Enter description here ...
	 * @return string
	 */
	public function __toString()
	{
		return "WorkflowControl";
	}
}