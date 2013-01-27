<?php
/**
 * Retrieve all the fee's that aren't disabled
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 */
class Applicant_Form_CreateFeeSettings extends ZFForm_ParentForm {

	/**
	 * (non-PHPdoc)
	 * @see Zend_Form::init()
	 */
	public function init() {
		$this->setMethod('post');
		$this->setLegend('applicantFeeSettingsTitle');
		
		$this->displayGroupArray = array();	
		$this->createFeeSelect();
		/*$this->addElement('submit','submit',array ('ignore' => true,'label' => 'save'));
		$this->getElement('submit')->setDecorators(
		array('ViewHelper',
		array(array('data' => 'HtmlTag'), array('tag' => 'td', 'class' => 'element')),
		array(array('label' => 'HtmlTag'), array('tag' => 'td', 'placement' => 'prepend')),
		array(array('row' => 'HtmlTag'), array('tag' => 'tr'))
		)
		);
		$this->setDecorators( array( 'FormElements',array('HtmlTag', array('tag' => 'table')),'Form'));
		*/
		$this->addSubmitButton();		
		$this->setDisplayGroup();
	}

	/**
	 * Create a select with all the fees that are enabled
	 */
	protected function createFeeSelect() {
		$fees = array();
		$fees = $this->getEnabledAccounts();

		if (count($fees)>0) {
			$element = 'feeId';
			$options = array('label'=>'fees','required'=>false,'registerInArrayValidator'=>false,'multiple'=>true,'isarray'=>false);
			$this->addElement('multiselect', $element,$options);
			foreach($fees as $id=>$text) {
				$this->getElement($element)->addMultiOption($id ,$text );
			}
			//	And set the selected on selected
			$this->setSelectedFees();
			$this->applyDecorator($element);
		        $this->addToGroup($element);
		}
	}

	/**
	 * Return only the enabled fees that can be used in the system
	 * @todo How do I determine the kind of fee's that are for applicant only?
	 * @return array
	 */
	public function getEnabledAccounts() {
		$fee = new Financial_Model_Fee();
		$params = array( 'search'=>array('enabled'=>1) );
		$enabledFees = array();
		$result = array();
		$feeId = null;
		$strName = null;
		$enabledFees = $fee->findByKey($params);

		if( !empty($enabledFees) ) {
			if ( count($enabledFees) > 0 ) {
				foreach($enabledFees as $id=>$feeObject) {
					$feeId = $feeObject->getId();
					$strName = $feeObject->getName()." $".$feeObject->getAmount();
					$result[$feeId] = $strName;
				}
				//	And before you push them , take out those that are in applicantFee's
				$appFees = new Applicant_Model_FeeSetting();
				$existentFees = $appFees->fetchAll(false,false,true);
				foreach($existentFees as $id=>$object) {
					if (isset($result[$object['feeId']])) {
						unset($result[$object['feeId']]);
					}
				}
			}			
		}
		return $result;
	}

	/**
	 *
	 * Retrieve all the values on the app fee's table and merge them into the array
	 */
	private function setSelectedFees() {
		$fee = new Applicant_Model_FeeSetting();
		$fees = $fee->fetchAll();
		$bufferResults = array();
		$feeId = null;

		if (!empty($fees)) {
			foreach ($fees as $id=>$element) {
				$feeId = $element->getId();
				$bufferResults[$feeId] = $feeId;
			}
			$this->getElement('feeId')->setValue($bufferResults);			
		}
	}
}
?>