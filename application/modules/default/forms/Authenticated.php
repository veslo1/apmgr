<?php
/**
 * Description of Authenticated
 *
 * @author jvazquez
 */
class Default_Form_Authenticated extends Zend_Form {

	public function init() {
		$this->setMethod('post');
		$options = array('label'=>'haveaccount','required'=>true);
		$this->addElement('radio','haveaccount',$options);
		$this->getElement('haveaccount')->addMultiOption('0','no')
		->addMultiOption('1','yes');
		$this->addElement('submit', 'submit', array ('ignore' => true,'label' => 'continue'));
	}
}
?>
