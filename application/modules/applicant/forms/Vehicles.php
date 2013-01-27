<?php
/**
 * Vehicles form for applicant
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 */

class Applicant_Form_Vehicles extends ZFForm_ParentForm {

	public function init() {}

	public function setForm(){
		$this->setMethod('post');
		$this->setAttrib('name','vehicles');
		$this->addMakeAndType();
		$this->addLicense();
		$this->addState();
		$this->addDisplayGroup(array('brand','state','license'),'vehicles',array('legend' => 'yourVehicles'));
		$this->addElement('hidden','control',array('required'=>true,'value'=>0));
		$this->addElement('submit','add',array('ignore'=>true,'label'=>'add'));
		$this->getElement('add')->setAttrib('class','submit');
		$this->getElement('add')->setDecorators( array( 'ViewHelper',
		array(array('data' => 'HtmlTag'), array('tag' => 'td', 'class' => 'element')),
		array(array('label' => 'HtmlTag'), array('tag' => 'td', 'placement' => 'prepend')),
		array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
		)
		);
		$this->addElement('submit','skip',array('ignore'=>true,'label'=>'skip'));
		$this->getElement('skip')->setAttrib('class','submit');
		$this->getElement('skip')->setDecorators( array( 'ViewHelper',
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

	private function addMakeAndType() {
		$options = array(
                   			'required'=>true,
                   			'label'=>'makeAndVehicle',
							'belongsTo'=>'vehicles',
                   			'validators' =>  array( array('stringLength', false, array(1, 50) )	)
		);
		$this->addElement('textarea','brand',$options);
		$this->getElement('brand')->setAttribs(array('rows'=>5,'cols'=>15));
	}

	private function addLicense() {
		$options = array(
							'required'=>true,
                   			'label'=>'driversLicense',
							'belongsTo'=>'vehicles',
                   			'validators' =>  array( array('stringLength', false, array(1, 9) )	)
		);
		$this->addElement('text','license',$options);
	}

	private function addState() {
		//	Not likely to change
		$selectOpts = array('label' => 'state','required' => true,'belongsTo'=>'vehicles','multiple'=>false);
		$this->addElement('select','state',$selectOpts);
		$translator = Zend_Registry::get('Zend_Translate');
		$this->setTranslator($translator);
		$this->getElement('state')->addMultiOption(null, $translator->_('selectStateEmptyOption'));
		foreach(self::$states as $id=>$stateAbreviation) {
			$this->getElement('state')->addMultiOption(++$id, $stateAbreviation);
		}
		$this->getElement('state')->setAttrib('class','inputAccesible');
	}
}