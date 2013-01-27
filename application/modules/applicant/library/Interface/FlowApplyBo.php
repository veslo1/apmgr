<?php
/**
 * Implementation of the business object for a work flow
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @package application.modules.applicant.library.interface
 */
interface Applicant_Library_Interface_FlowApplyBo
{
	/**
	 * Terminate the work flow
	 * @param array $args
	 */
	public function endFlow(array $args);

	/**
	 * Core element for a work flow , they payload contains all the information
	 * that allows the application to work
	 * @param array $args
	 */
	public function setPayload(array $args);

	/**
	 * Retrieve the payload that allows the application to work
	 * @return array
	 */
	public function getPayload();

	/**
	 * Applies a set of rules common for a step in a work flow
	 * @return boolean
	 */
	public function validateWorkflowStep();

	/**
	 * Get the next step in a workflow and perform the corresponding actions
	 * such as persistance or validation
	 * @return string
	 */
	public function moveNext();

	/**
	 * Retrieve the previous step in a work flow and perform the corresponding actions
	 * such as validation of the information
	 * @return string
	 */
	public function movePrevious();

	/**
	 * Perform a save operation
	 * @param array $args
	 * @return boolean
	 */
	public function save(array $args);

	/**
	 * Retrieve a record by the given name
	 * @param string $step
	 */
	public function findByStepName($step);

	/**
	 * Handle errors during the flow of the application
	 */
	public function handleError(Zend_Namespace_Session $session);
}
