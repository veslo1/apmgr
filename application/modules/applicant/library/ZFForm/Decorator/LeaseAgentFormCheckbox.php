<?php
/**
 * Custom markup for the checkboxes inside the LeaseAgentFilter form
 * @author Jorge Vazquez <jorgeomar.vazquez@gmail.com>
 */
class ZFForm_Decorator_LeaseAgentFormCheckbox extends Zend_Form_Decorator_Abstract {

	/**
	 * Build the input with the required style
	 * @internal Zend_Element_File doesn't works okay with decorators
	 * @return string
	 */
	public function buildInput() {
		$element = $this->getElement();
		$helper  = $element->helper;
		$output = '';
		$output = $element->getView()->$helper( $element->getName(),
		$element->getValue(),
		$element->getAttribs(),
		$element->options
		);
		return $output;
	}

	/**
	 * Fetch the error messages that the element may have after being validated
	 * @return string
	 */
	public function buildErrors() {
		$output = '';
		$element  = $this->getElement()->removeDecorator('error');
		$messages = $element->getMessages();
		if ( !empty($messages) ) {
			//	        $output = $element->getView()->formErrors($messages);
			// We know that we can only have one error at the time and we don't want the li
			//	for more information , this is what you need to look /apmgr/library/Zend/Form/Decorator/FormErrors.php
			$output = "<p class=\"error\">".array_shift($messages)."</p>";
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

		$errors    = $this->buildErrors();
		$separator = $this->getSeparator();
		$placement = $this->getPlacement();
		$input     = $this->buildInput();
		$output = $input;
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
