<?php
/**
 * Object that deals with the logic for the lease agent view to construct and populate forms
 * @author Jorge Omar Vazquez<jvazquez@debserverp4.com.ar>
 */

class Applicant_Library_LeaseAgent_FormHelper implements Applicant_Library_Interface_IForm {
	/**
	 * Edge cases that need to be dealt specially
	 * @var array
	 */
	static $edgeCases=array('occupants','vehicles');

	/**
	 * Map the name of the form
	 * @param array $args
	 * @return string
	 */
	public function mapApplicantFormName(Applicant_Library_LeaseAgent_DataMapper $mapper,array $args=null){
		$map = $mapper->getApplicantMap();
		return self::FORMPREFIX.$map[$args['page']]['form'];
	}

	/**
	 * Populate the form and take care of the elements that are select.
	 * @param Zend_Form $form
	 * @param array $data
	 * @return Zend_Form
	 */
	public function dressForm(Zend_Form $form,array $data=null) {
		if($data!=null){
			if( in_array($form->getName(),self::$edgeCases) ) {
				$data[0]=$this->prepareData($form,$data[0]);
				$form->populate($data[0]);
				unset($data[0]);
				//	Retrieve the name of the form to prepare as many subforms as needed
				$name = $form->getName();
				foreach($data as $content) {
					$subFormName = self::SUBFORMPREFIX.ucfirst($name);
					$subForm = new $subFormName;
					$content = $this->prepareData($subForm,$content);
					$subForm->populate($content);
					$form->addSubForm($subForm, $subFormName);
				}
				//	Now lock it
				foreach($form->getSubForms() as $id=>$subForm){
					foreach($subForm->getElements() as $index=>$element){
						$element->setRequired(false);
						$element->setAttrib('disabled',true);
					}
				}
			} else {
				$data=$this->prepareData($form,$data);
				$form->populate($data);
			}
		}
		return $form;
	}

	/**
	 * Prepare the information that is going to be used to populate a select
	 * @param Zend_Form $form
	 * @param array $data
	 * @return array
	 */
	private function prepareData(Zend_Form $form,array $data=null){
		foreach(new Applicant_Library_Filter_Element(new ArrayIterator($form->getElements())) as $id=>$element) {
			$multiOptionIterator = new Applicant_Library_Filter_Comparator(new ArrayIterator($element->getMultiOptions()));
			if( isset($data[$id]) ) {
				$multiOptionIterator->setTarget($data[$id]);
				foreach($multiOptionIterator as $index=>$value){
					$data[$id] = $index;
				}
			}
		}
		return $data;
	}

	/**
	 * Apply a different action to each form
	 * @param string $page
	 * @param Zend_Form $form
	 */
	public function triggerAction($page = null,Zend_Form &$form){
		if ( null!==$page ) {
			switch($page){
				case 'cwork':
					$form->setIsSkippable(false);
					break;
				case 'pwork':
					$form->setIsSkippable(true);
					break;
				case 'caddress':
					$form->setIsSkippable(false);
					break;
				case 'paddress':
					$form->setIsSkippable(true);
					break;
			}
		}
	}
}