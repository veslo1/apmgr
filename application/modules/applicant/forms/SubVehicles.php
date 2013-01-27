<?php
/**
 * Sub-form for other vehicles
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 */

class Applicant_Form_SubVehicles extends Zend_Form_SubForm {
	/**
	 * (non-PHPdoc)
	 * @see library/Zend/Zend_Form#init()
	 */
	public function init(){

		$translator = Zend_Registry::get('Zend_Translate');
		$this->setTranslator($translator);
		$this->addMakeAndType();
		$this->addLicense();
		$this->addState();
	}

	private function addMakeAndType() {
		$options = array(
                   			'required'=>false,
                   			'label'=>'makeAndVehicle',
							'belongsTo'=>'vehicles',
                   			'validators' =>  array( array('stringLength', false, array(1, 50) )	)
		);
		$this->addElement('textarea','brand',$options);
		$this->getElement('brand')->setAttribs(array('rows'=>5,'cols'=>15));
	}

	private function addLicense() {
		$options = array(
							'required'=>false,
                   			'label'=>'driversLicense',
							'belongsTo'=>'vehicles',
                   			'validators' =>  array( array('stringLength', false, array(1, 9) )	)
		);
		$this->addElement('text','license',$options);
	}

	private function addState() {
		$translator = Zend_Registry::get('Zend_Translate');
		$this->setTranslator($translator);
		//	Not likely to change
		$states = array('AL','AK','AZ','AR','CA','CO','CT','DE','FL','GA','HI','ID','IL','IN','IA','KS','KY','LA','ME','MD','MA','MI','MN','MS','MO','MT','NE','NV','NH','NJ','NM','NY','NC','ND','OH','OK','OR','PA','RI','SC','SD','TN','TX','UT','VT','VA','WA','WV','WI','WY') ;
		$selectOpts = array('label' => 'state','required' => false,'multiple'=>false,'belongsTo'=>'vehicles');
		$this->addElement('select','state',$selectOpts);
		$this->getElement('state')->addMultiOption(null, $translator->_('selectStateEmptyOption'));
		foreach($states as $id=>$stateAbreviation) {
			$this->getElement('state')->addMultiOption(++$id, $stateAbreviation);
		}
		$this->getElement('state')->setAttrib('class','inputAccesible');
	}
}
