<?php
/**
 * Create event in the calendar
 * @author jvazquez
 *
 */
class Calendar_Form_Create extends Zend_Form {

	/**
	 * (non-PHPdoc)
	 * @see library/Zend/Zend_Form#init()
	 */
	public function init() {
		$translator = Zend_Registry::get('Zend_Translate');
		$this->setMethod('post');
		//  Validate one date
		$dateCheck = new ZFForm_Datevalidate();
		//  And validate both dates
		$dateCompare = new ZFForm_Comparevalidate();
		//  Validate time
		$timeCheck = new ZFForm_Timevalidate();
		//  And compare two times
		$timeCheckRange = new ZFForm_Comparetimevalidate();

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

		$this->addElement('text' , 'startDate',array('required'=>true,'label'=>'startDate','description'=>'usesqlformat'));
		$this->getElement('startDate')->addValidator($dateCheck);
		$this->getElement('startDate')->setAttrib('class','inputAccesible');
		$this->getElement('startDate')->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement('startDate')->setDecorators(array('CustomForm'));

		$this->addElement('text', 'endDate',array('required'=>true,'label'=>'endDate','description'=>'usesqlformat'));
		$this->getElement('endDate')->addValidator($dateCheck);
		//	And compare that both dates are sane , ie, date to is not earlier than from
		$this->getElement('endDate')->addValidator($dateCompare);
		$this->getElement('endDate')->setAttrib('class','inputAccesible');
		$this->getElement('endDate')->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement('endDate')->setDecorators(array('CustomForm'));

		$this->addElement('text' , 'startTime',array('required'=>false,'label'=>'startTime'));
		$this->getElement('startTime')->setAttrib('class','inputAccesible');
		$this->getElement('startTime')->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement('startTime')->setDecorators(array('CustomForm'));
		$this->getElement('startTime')->addValidator($timeCheck);

		$this->addElement('text' , 'endTime',array('required'=>false,'label'=>'endTime'));
		$this->getElement('endTime')->setAttrib('class','inputAccesible');
		$this->getElement('endTime')->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement('endTime')->setDecorators(array('CustomForm'));
		$this->getElement('endTime')->addValidator($timeCheck);
		$this->getElement('endTime')->addValidator($timeCheckRange);

		/**
		 * 	Inject options
		 * $db = Zend_Db_Table_Abstract::getDefaultAdapter();
		 * $table = $table->info('NAME');
		 * $select = $db->select()->from($table, $cols);
		 * if($where)
		 * 	$select->where($db->quoteInto($where[0], $where[1]));
		 * $options = $db->fetchPairs($select, $cols[0]);
		 * Needs call to add multi here
		 */

		$this->addElement('multiselect', 'attendees', array ('label' => 'attendees','required' => false,'description'=>'attendeesDescription','registerInArrayValidator'=>false));
		$user = new User_Model_User();
		$userList = $user->fetchAll();
		foreach( $userList as $id=>$object ) {
			$name = $object->getFirstName()." ".$object->getLastName();
			$id = $object->getId();
			$this->getElement('attendees')->addMultiOption($id, $name);
		}
		$this->getElement('attendees')->setAttrib('class','inputAccesible');
		$this->getElement('attendees')->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement('attendees')->setDecorators(array('CustomForm'));

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