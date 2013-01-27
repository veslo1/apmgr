<?php
/**
 * Created on March 2, 2010 by rnelson
 * @name apmgr
 * @package application.modules.maintenance.controllers
 * <p>
 * Create form for the user to enter comments
 * </p>
 */
class Maintenance_Form_ChangeStatusAndAssignment extends Zend_Form {

	public function init() {
		// Set the method for the display form to POST
		$this->setMethod('post');

		$hidden = new Zend_Form_Element_Hidden('statusassigned');
		$hidden->setValue(1);
		$this->addElement($hidden);
			
		// Status
		$this->addElement('select','status',array(
			'label' => 'Status',
			'required' => false,
		));

		$statusObj = new Maintenance_Model_MaintenanceStatus();
		$statuses = $statusObj->fetchAll();

		$this->getElement('status')->addMultiOption( null,'--select--');

		foreach( $statuses as $id=>$status ){
			$this->getElement('status')->addMultiOption( $status->getId(), $status->getStatus() );
		}

		// Assigned
		$this->addElement('select','assignedTo',array(
			'label' => 'Assigned To',
			'required' => false,
		));

		$user = new User_Model_User();

		// TODO filter out tenant users
		$this->getElement('assignedTo')->addMultiOption(null, '--select--');
		foreach ($user->fetchAll() as $u) {
			$this->getElement('assignedTo')->addMultiOption($u->getId(), $u->getFirstName() . ' ' .  $u->getLastName() );
		}

		// sets decorators for form elements added to this point
		$this->setElementDecorators(array(
			'ViewHelper',
			'Errors',
		array(array('data' => 'HtmlTag'), array('tag' => 'td', 'class' => 'element')),
		array( 'Label', array('tag' => 'td'), array( array('row' => 'HtmlTag'), array('tag' => 'tr') ) ),
		array(array('row' => 'HtmlTag'), array('tag' => 'tr'))
		));

		$this->addElement('submit', 'submit', array ('ignore' => true ,'label' => 'changeStatusAssignedTo'));
		$submit = $this->getElement('submit');
		$submit->setDecorators(
		array(
    									'ViewHelper',
		array(array('data' => 'HtmlTag'), array('tag' => 'td', 'class' => 'element')),
		array(array('label' => 'HtmlTag'), array('tag' => 'td', 'placement' => 'prepend')),
		array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
		)
		);

		$this->setDecorators( array( 'FormElements',array('HtmlTag', array('tag' => 'table')),'Form'));
	}

	private function addStatus(){
	  
	}
}
?>