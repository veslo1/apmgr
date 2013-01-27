<?php
/**
 * Created on May 2, 2010 by rnelson
 * @name apmgr
 * @package library.ZFForm
 * <p>
 * Allows user to make a custom text label for displaying instructions and other text that do not need
 * the element setDescription method
 * </p>
 */

class ZFForm_CustomLabel extends Zend_Form_Element
{
	/**
	 * The default sufix used for the constructor
	 * @var const
	 */
	const DEFAULTSUFIX="Label";
	
	private $_content;
	private $translator;

	 
	/**
	 * Setter for the element content
	 *
	 * @param string
	 */
	public function setContent($content) {
		$this->_content = $content;
	}
	 
	public function getContent() {
		$this->translator = Zend_Registry::get('Zend_Translate');
		return $this->translator->translate($this->_content);
	}

	/**
	 * Render form element
	 *
	 * @param  Zend_View_Interface $view
	 * @return string
	 */
	public function render(Zend_View_Interface $view = null) {
		if(null !== $view)
		$this->setView($view);

		return '<p>'.$this->getContent().'</p>';
	}

	public function isValid($value, $context = null) {
		// this element is always valid
		return true;
	}
}
?>