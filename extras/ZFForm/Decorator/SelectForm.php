<?php

class ZFForm_Decorator_SelectForm extends Zend_Form_Decorator_Abstract {

	/**
	 * Build the lable of the element
	 * @return string
	 */
	public function buildLabel() {
		$element = $this->getElement();
		$name = $element->getName();
		$label = $element->getLabel();

		if ($translator = $element->getTranslator())
		$label = $translator->translate($label);

		$output=null;
		// Do not build label for submit button
		if( !($element instanceof Zend_Form_Element_Submit) ) {
			if ( $element->isRequired() )
			$output = "<label for='$name' class='labelAccesibleRequired'>".$label."</label>";
			else
			$output = "<label for='$name'>".$label."</label>";
		}
		else
		$output = "<label for='$name' style='visibility:hidden;'> &nbsp; </label>";

		return $output;
	}

	/**
	 * Build the input with the required style
	 * @return string
	 */
	public function buildInput() {
		$element = $this->getElement();
		$helper  = $element->helper;
		$output = '';

		if( !($element instanceof Zend_Form_Element_Submit) ) {
			if( $element->isRequired() ) {
				$output = $element->getView()->$helper( $element->getName(),
				$element->getValue(),
				$element->getAttribs(),
				$element->options
				);
				$output .="<span class='required'>*</span>";
			}
			else {
				$output = $element->getView()->$helper( $element->getName(),
				$element->getValue(),
				$element->getAttribs(),
				$element->options
				);
			}
		}
		else {  // place the label as the value for the submit
			$label = $element->getLabel();
			$output = $element->getView()->$helper( $element->getName(),
			$label,
			$element->getAttribs(),
			$element->options
			);	;
		}

		return $output;
	}



	public function buildErrors() {
		$element  = $this->getElement();
		$messages = $element->getMessages();
		if (empty($messages)) {
			return '';
		}
		//		return '<div class="errors">'.$element->getView()->formErrors($messages).'</div>';
		return $element->getView()->formErrors($messages);
	}



	public function buildDescription() {
		$element = $this->getElement();
		$desc    = $element->getDescription();


		if (empty($desc)) {
			return '';
		}
		if ($translator = $element->getTranslator()) {
			$desc = $translator->translate($desc);
		}
		return '<div class="description">'.$desc.'</div>';
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

		//		$output = '<div class="form element">'.$label.$input.$desc.$errors.'</div>';
		//$output = '<tr><td>'.$label.'</td><td>'.$input.'</td><td>'.$errors.'</td></tr><tr><td>'.$desc.'</td></tr>';
		$output = $label.$input.$errors.$desc;
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