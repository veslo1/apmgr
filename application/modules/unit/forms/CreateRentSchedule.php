<?php
/**
 * Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * Creates the custom form for rent scheduling
 */

class Unit_Form_CreateRentSchedule extends ZFForm_ParentForm  {
	
	public function init() {		
			
	}
	
	public function setForm(){
		$this->setMethod('post');
		$this->setAttrib('name','schedule');
		
		$this->addDate();
		$this->addMonth();
		$this->addAmount();		
		
		$this->addDisplayGroup(array('effectiveDate','month','amount'),'createrentschedule',array('legend' => 'createRentSchedule'));
		$this->addElement('hidden','control',array('required'=>true,'value'=>0));
		$this->addElement('submit','add',array('ignore'=>true,'label'=>'add'));
		$this->getElement('add')->setAttrib('class','submit');
		$this->getElement('add')->setDecorators( array( 'ViewHelper',
		array(array('data' => 'HtmlTag'), array('tag' => 'td', 'class' => 'element')),
		array(array('label' => 'HtmlTag'), array('tag' => 'td', 'placement' => 'prepend')),
		array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
		)
		);		

		$this->addElement('submit','remove',array('ignore'=>true,'label'=>'remove'));
		$this->getElement('remove')->setAttrib('class','submit');
		$this->getElement('remove')->setDecorators( array( 'ViewHelper',
		array(array('data' => 'HtmlTag'), array('tag' => 'td', 'class' => 'element')),
		array(array('label' => 'HtmlTag'), array('tag' => 'td', 'placement' => 'prepend')),
		array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
		)
		);
		$this->addElement('submit', 'submit', array( 'ignore'   => true, 'label' => 'save' ));
		$this->getElement('submit')->setAttrib('class','submit');
		$this->getElement('submit')->setDecorators( array( 'ViewHelper',
		array(array('data' => 'HtmlTag'), array('tag' => 'td', 'class' => 'element')),
		array(array('label' => 'HtmlTag'), array('tag' => 'td', 'placement' => 'prepend')),
		array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
		)
		);
	}
	
	/**
	 *  Adds effective date
	 */
	private function addDate(){
		$element = 'effectiveDate';
		$this->addElement('text', $element, array(
                    'label'	 => $element,
                    'required'   => true,
                    'filters'    => array('StringTrim'),
		    'belongsTo'=>'schedule',
	            'readonly' => true
		));	  
		$dateCheck = new ZFForm_Datevalidate();
		$this->getElement($element)->addValidator($dateCheck);
		$this->getElement($element)->setAttrib('class','inputAccesible');
		
	}	
		
	private function addMonth(){
		$element = 'month';
		        $this->addElement('text', $element, array(
                    'label'		 => 'numMonths',
                    'required'   => true,
                    'filters'    => array('StringTrim'),
		    'belongsTo'=>'schedule',
	           // 'readonly' => false,
		    'validators' => array (array ('validator' => 'int'),
		                    array ('validator' => 'Between','options' => array (1,18)))
		));
		$this->getElement($element)->setAttrib('class','inputAccesible');
			
	}
	
	private function addAmount(){
	    $element = 'amount';
		$this->addElement('text', $element, array(
                    'label'		 => $element,
                    'required'   => true,
                    'filters'    => array('StringTrim'),
		    'belongsTo'=>'schedule',
	           // 'readonly' => false,
		    'validators' => array (array ('validator' => 'float'),
		                    array ('validator' => 'Between','options' => array (1.00,100000.00)))
		));
		$this->getElement($element)->setAttrib('class','inputAccesible');
	}		
}