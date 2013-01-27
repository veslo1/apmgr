<?php
/**
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * Authorizaton form.
 * @todo We should retrieve the name of the company that buys our application and place it here
 */
class Applicant_Form_Authorization extends ZFForm_ParentForm {
	/**
	 * (non-PHPdoc)
	 * @see library/Zend/Zend_Form#init
	 */
	public function init() {}

	public function setForm() {
		$this->setMethod('post');
		$this->setFormTranslator();
		$this->setName('authorization');
		$this->addApplicantSignature();
		$this->addSpouseSignature();
		$this->addReadSignatureCheck();
		$this->addSubmitButton('accept');
		$this->setLegend('authorization');
		//$this->addLegalText();
		$this->setDisplayGroup();
	}

	private function addApplicantSignature() {
		$textOptions = array('label'=>'applicantSignature','description'=>'applicantSignatureDescription','validators' =>  array( array('stringLength', false, array(1, 50))),'required'=>true);
		$this->addElement('text','applicantSignature',$textOptions);
		$this->applyDecorator('applicantSignature');
		$this->addToGroup('applicantSignature');
	}

	private function addSpouseSignature() {
		$element = 'spouseSignature';
		$textOptions = array('label'=>'spouseSignature','description'=>'spouseSignatureDescription','validators' =>  array( array('stringLength', false, array(1, 50))),'required'=>false);
		$this->addElement('text',$element,$textOptions);
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	private function addReadSignatureCheck() {
		$element = 'acceptedContract';
		///'authorizeLegal',
		$radio = array('required'=>true,'label'=>'iAcceptThisContract','listsep'=>'','validators' => array('notEmpty'),'uncheckedValue'=> null,'registerInArrayValidator'=>false);
		$this->addElement('radio',$element,$radio);
		$content = self::$answer;
		$content = array_reverse($content);
		foreach($content as $id=>$value){
			$this->getElement($element)->addMultiOption($id,$value);
		}
		$this->getElement($element)->setAttrib('label_class','list');	
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}
	
	/**
	 * Add the legal text to the form
	 */
	private function addLegalText() {
		$suffix = ZFForm_CustomLabel::DEFAULTSUFIX;
		$content = array('applicationLeaseContractInformation','applicationFeeLegal','applicationDeposit','approvalLeaseSign','approvalLeaseNotSign','approvalLeaseFail','withdrawBeforeApproval','completedApplication','nonApprovalInSevenDays','refundAfterNonApproval','extensionOfDeadline','coApplicantNotice','keysOrAccess');
		foreach($content as $identifier){
			$label= new ZFForm_CustomLabel("$identifier$suffix");
			$label->setContent($identifier);
			$this->addPrefixPath('ZFForm_CustomLabel', 'ZFForm', Zend_Form::ELEMENT);
			$this->addElement($label);
			$this->applyDecorator("$identifier$suffix");
			$this->addToGroup("$identifier$suffix");
		}
	}
}