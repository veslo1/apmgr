<?php
/**
 * Created on January 28, 2010 by rnelson
 * @name apmgr
 * @package application.modules.payment.controllers
 * <p>
 * Search form for the user to search by unit number
 * </p>
 */
class Unit_Form_SearchUnit extends Zend_Form {

	public function init() {
		// Set the method for the display form to POST
		$this->setMethod('post');

		// unit number search - pulls in bills with ajax - will need to post bills with ajax too

		// Unit Number	- look up unit id on back end for saving

		$this->addElement('text', 'number', array (
                'label' => 'unitnumber',
                'required' => true,
                'filters' => array ( 'StringTrim' ),
                'validators' => array (array ('validator' => 'StringLength','options' => array (1,50)))));
		$this->addElement('submit', 'submit', array ('ignore' => true,'label' => 'search'));

		$input = $this->getElement('number');
		$input->setDecorators(
		array(
                'ViewHelper',
                'Errors',
		array(array('data' => 'HtmlTag'), array('tag' => 'td', 'class' => 'element')),
		array( 'Label', array('tag' => 'td'), array( array('row' => 'HtmlTag'), array('tag' => 'tr') ) )
		)
		);

		$submit = $this->getElement('submit');
		$submit->setDecorators(
		array(
                'ViewHelper',
		array(array('data' => 'HtmlTag'), array('tag' => 'td', 'class' => 'element')),
		array(array('label' => 'HtmlTag'), array('tag' => 'td', 'placement' => 'prepend')),
		array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
		)
		);

		$this->setDecorators( array( 'FormElements',array('HtmlTag', array('tag' => 'table')),'Form'));

		/**
		 * This generates
		 * <input type='text' name='number'/>
		 * <label>Unit Number</label>
		 * @example
		 * $label = $this->getElement('number')->getDecorator('label');
		 * $label->setOption('placement', 'append');
		 * Play with append, prepend
		 */

	}
}
?>
