<?php
/**
 * Created on Jan 25, 2010 by rnelson
 * @name apmgr
 * @package application.modules.unit.controllers
 * <p>
 * Create form for units
 * </p>
 */
class Unit_Form_CreateAmenity extends Zend_Form {

	public function init() {
	}

	public function setForm(){
		// Set the method for the display form to POST
		$translator = Zend_Registry::get('Zend_Translate');
		$this->setMethod('post');
		 
		$this->addElement('text', 'name', array (
			'label' => 'amenityName',
			'required' => true,
			'filters' => array ( 'StringTrim' ),
			'validators' => array (array ('validator' => 'StringLength','options' => array (1,50)))));

		$this->getElement('name')->setAttrib('class','inputAccesible');
		$this->getElement('name')->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement('name')->setDecorators(array('FieldsetForm'));


		$this->addElement('submit', 'submit', array ('ignore' => true,'label' => 'save',));
		$this->getElement('submit')->setAttrib('class','submit');
		$this->getElement('submit')->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement('submit')->setDecorators(array('FieldsetForm'));

		$this->addDisplayGroup(array(
                    'name',                   
		    'submit'
        
		    ),'createAmenity',array('legend' => $this->getLegend()));

		    $this->getDisplayGroup('createAmenity')->setDecorators(array(
                    'FormElements',
                    'Fieldset',                    
		    ));
	}
}
?>
