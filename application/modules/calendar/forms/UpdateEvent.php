<?php
/**
 * Form to update an event
 *
 * @author jvazquez
 */
class Calendar_Form_UpdateEvent extends Zend_Form {

	public function init() {
		$translator = Zend_Registry::get('Zend_Translate');
		$this->setMethod('post');

		$this->addElement('text' ,
                'title',
		array(
                    'required'=>true,
                    'label'=>'eventTitle',
                    'validators' =>  array( array('stringLength', false, array(1, 12))
		)
		)
		);
		$this->getElement('title')->setAttrib('class','inputAccesible');
		$this->getElement('title')->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement('title')->setDecorators(array('CustomForm'));

		$this->addElement('textarea', 'data', array ('label' 	=> 'eventData','required' 	=> true));
		$this->getElement('data')->setAttribs(array('cols'=>25,'rows'=>10));
		$this->getElement('data')->setAttrib('class','inputAccesible');
		$this->getElement('data')->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement('data')->setDecorators(array('CustomForm'));

		$this->addElement('checkbox', 'allDayEvent', array ('label'=> 'allDayEventLbl','required' => false));
		$this->getElement('allDayEvent')->setAttrib('class','inputAccesible');
		$this->getElement('allDayEvent')->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement('allDayEvent')->setDecorators(array('CustomForm'));

		$this->addElement('submit', 'submit', array ( 'ignore' => true, 'label' => 'save','translator'=>$translator) );
		$this->getElement('submit')->setDecorators(
		array(
                'ViewHelper',
		array(array('data' => 'HtmlTag'), array('tag' => 'td', 'class' => 'element')),
		array(array('label' => 'HtmlTag'), array('tag' => 'td', 'placement' => 'prepend')),
		array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
		)
		);
		$this->setDecorators( array( 'FormElements',array('HtmlTag', array('tag' => 'table')),'Form'));
	}
}
?>
