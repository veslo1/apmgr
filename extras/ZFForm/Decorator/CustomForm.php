<?php

class ZFForm_Decorator_CustomForm extends Zend_Form_Decorator_Abstract {

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

		if ( $element->isRequired() ) {
			$output = "<p class='labelAccesibleRequired'>".$label.":</p>";
		} else {
			$output = "<p>".$label.":</p>";
		}
		return $output;
	}

	/**
	 * Build the input with the required style
	 * @internal Zend_Element_File doesn't works okay with decorators
	 * @return string
	 */
	public function buildInput() {
		$element = $this->getElement();
		$helper  = $element->helper;
		$output = '';
		if( $element->isRequired() ) {
			$output = $element->getView()->$helper( $element->getName(),
			$element->getValue(),
			$element->getAttribs(),
			$element->options
			);
			$output .="<td><p class=\"requiredmark\">*</p></td>";
		} else {
			$output = $element->getView()->$helper( $element->getName(),
			$element->getValue(),
			$element->getAttribs(),
			$element->options
			);
		}

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
		return $element->getView()->formErrors($messages);
	}



	public function buildDescription() {
		$element = $this->getElement();
		$desc    = $element->getDescription();

		if ( !empty($desc) ) {
			$translator = $element->getTranslator();
			if ( $translator ) {
				$desc = $translator->translate($desc);
			}
			return '<div class="description">'.$desc.'</div>';
		} else {
			return '';
		}
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
		$output = '<tr><td>'.$label.'</td><td>'.$input.'</td><td>'.$errors.'</td></tr><tr><td>'.$desc.'</td></tr>';
		switch ($placement) {
			case (self::PREPEND):
				return $output.$separator.$content;
			case (self::APPEND):
			default:
				return $content.$separator.$output;
		}
	}
}
?>