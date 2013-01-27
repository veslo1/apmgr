<?php
/**
 * Sub-form for rent schedule 
 */

class Unit_Form_SubCreateRentSchedule extends Zend_Form_SubForm {
	/**
	 * (non-PHPdoc)
	 * @see library/Zend/Zend_Form#init()
	 */
	public function init(){

		$translator = Zend_Registry::get('Zend_Translate');
		$this->setTranslator($translator);
		$this->addMonth();
		$this->addAmount();
	}

	private function addMonth(){
		$element = 'month';
		        $this->addElement('text', $element, array(
                    'label'		 => $element,
                    'required'   => true,
                    'filters'    => array('StringTrim'),
		    'belongsTo'=>'schedule',
	      //      'readonly' => false,
		    'validators' => array (array ('validator' => 'int'),
		                    array ('validator' => 'Between','options' => array (1,18)))
		));	  	
			
	}
	
	private function addAmount(){
	    $element = 'amount';
		$this->addElement('text', $element, array(
                    'label'		 => $element,
                    'required'   => true,
                    'filters'    => array('StringTrim'),
		    'belongsTo'=>'schedule',
	    //        'readonly' => false,
		    'validators' => array (array ('validator' => 'float'),
		                    array ('validator' => 'Between','options' => array (1.00,100000.00)))
		));	  					   			
	}		
}
