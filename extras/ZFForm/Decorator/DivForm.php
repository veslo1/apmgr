<?php

class ZFForm_Decorator_DivForm extends Zend_Form_Decorator_Abstract {

	/**
	 * Build the lable of the element
	 * @return string
	 */
	public function buildLabel() {
		$element = $this->getElement();
		$label = $element->getLabel();
		$translator = $element->getTranslator();
		if ( $translator ) {
			$label = $translator->translate($label);
		}
		$output = "<p class=\"cell label\">".$label."</p>";
		return $output;
	}

	/**
	 * Build the input with the required style
	 * @internal Zend_Element_File doesn't works okay with decorators
	 * @return string
	 */
	public function buildInput() {
		$element = $this->getElement();
		$element->setAttrib('class', 'cell');
		$helper  = $element->helper;
		$output = $element->getView()->$helper( $element->getName(),$element->getValue(),$element->getAttribs(),$element->options);
		return $output;
	}


	/**
	 * Fetch the error messages that the element may have after being validated
	 * @return string
	 */
	public function buildErrors() {
		$element  = $this->getElement();
		$messages = $element->getMessages();
		if (empty($messages)) {
			return '';
		}
		$output="<div class=\"errorbox\">".$element->getView()->formErrors($messages)."</div>";
		return $output;
	}



	public function buildDescription() {
		$element = $this->getElement();
		$desc    = $element->getDescription();
		$output = '';
		if ( !empty($desc) ) {
			$translator = $element->getTranslator();
			if ( $translator ) {
				$desc = $translator->translate($desc);
			}
			$output="<p class=\"cell description\">$desc</p>";
		}
		return $output;
	}


	/**
	 * (non-PHPdoc)
	 * @see library/Zend/Form/Decorator/Zend_Form_Decorator_Abstract#render($content)
	 */
	public function render($content) {
		$element = $this->getElement();
		if (!$element instanceof Zend_Form_Element) {
			return $content;
		}
		if (null === $element->getView()) {
			return $content;
		}

		$separator = $this->getSeparator();
		$placement = $this->getPlacement();
		$label     = $this->buildLabel();
		$input     = $this->buildInput();
		$errors    = $this->buildErrors();
		$desc      = $this->buildDescription();
		//		$output = '<tr><td>'.$label.'</td><td>'.$input.'</td><td>'.$errors.'</td></tr><tr><td>'.$desc.'</td></tr>';
		$output='';
		switch( $element->getType() ) {
			case 'Zend_Form_Element_Text':
			case 'Zend_Form_Element_Password':
			case 'Zend_Form_Element_Captcha':
			case 'Zend_Form_Element_Textarea':
			case 'Zend_Form_Element_Select':
				$output = $this->buildElementText($element,$label,$input,$desc,$errors);
				break;
			case 'Zend_Form_Element_Submit':
				$output = $this->buildElementSubmit($element,$input);
				break;
			default:
				break;
		}

		switch ($placement) {
			case (self::PREPEND):
				return $output.$separator.$content;
			case (self::APPEND):
			default:
				return $content.$separator.$output;
		}
	}

	/**
	 * Build up the markup for regular inputs
	 * @param Zend_Form_Element $element
	 * @param string $label
	 * @param string $input
	 * @param string $desc
	 * @param string $errors
	 * @return string
	 */
	private function buildElementText($element,$label,$input,$desc,$errors){
		$output = "<div class=\"containerinputbox\">";
		$output .= "<div class=\"inputbox\">";
		$output .=$label;
		$output .="<div class=\"wrapperInput\">$input</div>";
		if( $element->isRequired() ) {
			$output .="<p class=\"cell required\">*</p>";
		}
		$output.=$desc.$errors."</div></div>";
		return $output;
	}

	/**
	 * Build the markup for a submit
	 * @param Zend_Form_Element $element
	 * @param string $input
	 * @return string
	 */
	private function buildElementSubmit($element,$input){
		$output = "<div class=\"containerinputbox\">";
		$output .= "<div class=\"submit\">";
		$output .= $input;
		$output.="</div></div>";
		return $output;
	}
}
?>