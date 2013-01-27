<?php
/**
 * Created on Sep 20, 2009 by jvazquez
 * @name datesite
 * @package application.modules.permission.forms
 * <p>
 * Form for the search on permissions
 * </p>
 */

class Permission_Form_Search extends Zend_Form {

	public function init() {
		$this->setMethod('post');

		$this->addElement('text', 'name', array (
			'label' => 'Name:',
			'required' => true,
			'filters' => array (
				'StringTrim'
				),
			'validators' => array (
				array (
					'validator' => 'StringLength',
					'options' => array (1,10)
				)
				)
				));

				//	This checkbox repesents the logical value of Read flag
				$this->addElement('checkbox','read',array(
			'label' => 'Read',
			'required' =>false
				));

				//	This checkbox repesents the logical value of write flag
				$this->addElement('checkbox','write',array(
			'label' => 'Write',
			'required' =>false
				));

				//	This checkbox repesents the logical value of execute flag
				$this->addElement('checkbox','execute',array(
			'label' => 'Execute',
			'required' =>false
				));

				//	This checkbox repesents the type of criteria that you do.
				$this->addElement('checkbox','connector',array(
			'label' => 'Inclusive / Exclusive',
			'required' =>false,
			'ignore' => true
				));

				$this->addDisplayGroup(array('name', 'read','write','execute'), 'Search Criteria');
				$this->addDisplayGroup(array('connector', 'searchtype'), 'Search Type');
				$this->addElement('submit', 'submit', array (
			'ignore' => true,
			'label' => 'Search',
					
				));
	}
}
?>
