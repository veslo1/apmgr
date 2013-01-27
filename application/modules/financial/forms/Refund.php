<?php
/**
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * Refund form for the lease agent.
 */
class Financial_Form_Refund extends ZFForm_ParentForm {

	/* (non-PHPdoc)
	 * @see library/Zend/Zend_Form::init()
	 */
	public function init(){}

	/**
	 * Insantiate the form
	 */
	public function setForm() {
		$this->setMethod('post');
		$this->addMaxAmount();
		$this->addRefundAmount();
		$this->addComment();		
		$this->addSubmitButton();
		
		$this->setDisplayGroup();  // add display group
		$this->setFormTranslator();  // add translator
	}

	/**
	 * Add a comment text area
	 */
	private function addComment() {
		$element = 'comment';
		$htmlOpts = array();
		$validation = array ('validator' => 'StringLength','options' => array (0,500));
		$commentOptions = array(
								'label' => 'comment',
								'required' => true,
								'filters' => array ( 'StringTrim' ),
								'validators' => array ($validation)
		);
		$this->addElement('textarea', $element, $commentOptions);
		$this->getElement($element)->setAttribs(array('rows'=>10,'cols'=>22));
		$this->addDecoratorAndGroup( $element );
	}

	/**
	 * Add an input so the user an add a refund
	 */
	private function addRefundAmount() {
		$locale = Zend_Registry::get('Zend_Locale');
		$lang = $locale->getLanguage();
		$element = 'amount';
		$validation = array ('validator'=>'float','options' => array('locale'=>$lang));
		$amountOptions = array(
								'label' => 'amount',
								'required' => true,
								'filters' => array ('LocalizedToNormalized'),
								'validators' => array ($validation)
		);
		$this->addElement('text', $element, $amountOptions);
		$this->addDecoratorAndGroup( $element );
	}
	
	/**
	 * Max Amount the user can refund
	 */
	private function addMaxAmount() {		
		$element = 'maxAmount';		
		$amountOptions = array(	'label' => 'maxAmount', 'required' => false );
		$this->addElement('text', $element, $amountOptions);
		$this->addDecoratorAndGroup( $element, true );
	}
}