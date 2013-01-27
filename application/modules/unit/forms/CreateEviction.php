<?php
/**
 * Created on January 13, 2011 by rnelson
 * @name apmgr
 * @package application.modules.unit.controllers
 * <p>
 * Create form for lease eviction
 * </p>
 */
class Unit_Form_CreateEviction extends ZFForm_ParentForm {
	public function init() {
		$this->setLegend('createEviction');		
	}
	 
	public function setForm( $leaseId ) {				
		$this->addTenant( $leaseId );
		$this->addIsEvicted();
		$this->addComment();
		$this->addSubmitButton();
	  
		$this->setDisplayGroup();  // add display group
		$this->setFormTranslator();  // add translator
	} 
	 
	/**
	 *  Add tenants
	 */
	private function addTenant($leaseId){
		$element = 'tenantId';
		$this->addElement('select',$element,array(
			'label' => 'tenant',
			'required' => true,
		));
		$tenantObj = new Unit_Model_Tenant();
		$tenantObj->setLeaseId( $leaseId );
		$tenants = $tenantObj->getTenants();
		foreach ($tenants as $t) {
			$this->getElement($element)->addMultiOption($t['id'], $t['firstName'] . ' ' . $t['lastName']);
		}
		$this->addDecoratorAndGroup( $element );
	}
	
	/**
	 *  Is evicted
	 */
	private function addIsEvicted(){
		$element = 'isEvicted';
		$this->addElement('checkbox',$element,array(
		    'label' => 'isEvicted',
		    'required' => false		    
		));
		$this->addDecoratorAndGroup( $element );
	}
	 
	/**
	 *  Add comment
	 */
	private function addComment(){
		$element = 'comment';
		$this->addElement('textarea', $element, array (
			'label' => 'comment',
			'required' => true,
			'filters' => array ( 'StringTrim' ),
			'col'=>50,
			'row'=>40,
			'validators' => array (array ('validator' => 'StringLength','options' => array (1,2000)))));		 
		$this->addDecoratorAndGroup( $element );
	}		
}
?>
