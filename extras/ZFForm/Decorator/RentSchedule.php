<?php
/**
 *
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * Creates the custom html tags for this particular form
 * This is a heavy customized form, due to the special needs it has, it has to be used
 * with the rentSchedule.css style, since I fixed it to work that way.
 */

class ZFForm_Decorator_RentSchedule extends Zend_Form_Decorator_Abstract {

	/**
	 * Build the lable of the element
	 * @return string
	 */
	public function buildLabel() {
		$element = $this->getElement();
		$label = $element->getLabel();

		if ($translator = $element->getTranslator()) {
			$label = $translator->translate($label);
		}

		if ( $element->isRequired() ) {
			$output = "<div class='labelAccesibleRequired'>".$label.":</div>";
		} else {
			$output = $label;
		}
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
		if( $element->isRequired() ) {
			$output = $element->getView()->$helper( $element->getName(),
			$element->getValue(),
			$element->getAttribs(),
			$element->options
			);
			$output .="<div class='requiredmark'>*</div>";
		} else {
			$output = $element->getView()->$helper( $element->getName(),
			$element->getValue(),
			$element->getAttribs(),
			$element->options
			);
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
		$output = '<span>'.$label.''.$input.''.$errors.''.$desc.'</span>';

		if( strcmp( $element->getName(),'add' ) == 0 ) {
			$output .="<table class='rentscheduletable'>
			<thead><tr><th><i18n>numberofmonths</i18n></th><th><i18n>rentamount</i18n></th><th><i18n>actions</i18n></th></tr></thead>
			<tbody id='tableitems'></tbody>
			</table>";
		}

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