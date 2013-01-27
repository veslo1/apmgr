<?php
/**
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 *
 */
class Applicant_Form_DeleteFeeSetting extends Zend_Form {
	/**
	 *
	 * Constant that we want to delete the record
	 * @var const CONFIRMDELETE
	 */
	const CONFIRMDELETE=1;
	/**
	 *
	 * Determine if we want to keep the record
	 * @var const CONFIRMKEEP
	 */
	const CONFIRMKEEP = 0;

	public function init() {
		$translator = Zend_Registry::get('Zend_Translate');
		$this->setTranslator($translator);
		$this->setMethod('post');

		$options = array('label'=>'removeApplicantFeeSetting','required'=>true);
		$this->addElement('radio','delete',$options);
		$this->getElement('delete')->addMultiOption('0','no')
		->addMultiOption('1','yes');


		$this->addElement('submit','submit',array ('ignore' => true,'label' => 'save'));
		$this->getElement('submit')->setDecorators(array('ViewHelper',
		array(array('data' => 'HtmlTag'), array('tag' => 'td', 'class' => 'element')),
		array(array('label' => 'HtmlTag'), array('tag' => 'td', 'placement' => 'prepend')),
		array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
		)
		);
		$this->setDecorators( array( 'FormElements',array('HtmlTag', array('tag' => 'table')),'Form'));
	}
}