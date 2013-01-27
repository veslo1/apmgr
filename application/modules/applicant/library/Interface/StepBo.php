<?php
/**
 * Implementation of the business object for Step
 * @author Jorge Omar Vazquez<jvazquez@debserverp4.com.ar>
 * @package application.modules.applicant.library.interface
 */
interface Applicant_Library_Interface_StepBo extends ZFInterfaces_Messageable
{
	/**
	 * Contains a set of validation options for the apply process
	 * @return boolean
	 */
	public function indexValidate();
	
	/**
	 * Retrieve the form that will be used in this step
	 * @return Zend_Form
	 */
	public function getIndexStepForm();
	
	/**
	 * Perform the apply operation
	 * @return boolean
	 */
	public function indexAction();
	
	/**
	 * Perform the validation in the apply user validation page
	 * @return boolean
	 */
	public function applyuserValidate();
	
	/**
	 * Contains the logic rules for joining under a work flow
	 * @return boolean
	 */
	public function joinValidate();
	
	/**
	 * Retrieves the corresponding form given the page
	 * @return Zend_Form
	 */
	public function getApplyUserStepForm();
	
	/**
	 * Contains the validation logic corresponding to the apply action, which is a sub set of index.
	 * In this step , we validate that the give user is valid and exists and will move the user to the <strong>next</strong> step in
	 * a work flow 
	 */
	public function applyuserAction();
	
	/**
	 * Contains the validation logic corresponding to the join action , which is a sub set of index also.
	 * In this step , we will create a user account , and will move the user to the <strong>next</strong> step in
	 * a work flow 
	 */
	public function joinAction();
	
	/**
	 * Verify that the current step that is being actively used is valid
	 * @param int $currentStep
	 * @throws ErrorException
	 * @return boolean
	 */
	public function currentStepIsValid($currentStep);
	
	/**
	 * Retrieve the injected parameters
	 * @param Applicant_Library_Interface_FlowApplyBo $bo
	 */
	public function setBo(Applicant_Library_Interface_FlowApplyBo $bo);
}