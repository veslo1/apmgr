<?php
/**
 * This is a model that works with the form
 *
 * @author jvazquez
 */
class Unit_Model_UnitSearch extends ZFModel_ParentModel {

	/**
	 * Retrieve the instace of a zend form, and add more search criteria
	 * @param array $args
	 */
	public function addCriteria($args) {
		$element = new Zend_Form_Element('text',$args);
		$element->setDecorators(
		array(
                'ViewHelper',
                'Errors',
		array(array('data' => 'HtmlTag'), array('tag' => 'td', 'class' => 'element')),
		array( 'Label', array('tag' => 'td'), array( array('row' => 'HtmlTag'), array('tag' => 'tr') ) )
		)
		);
		return $element;
	}
}
?>
