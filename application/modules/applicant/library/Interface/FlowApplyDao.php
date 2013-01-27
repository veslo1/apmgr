<?php
/**
 * Implementation of the DAO for flows
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @package application.modules.applicant.library.interfaces
 */
interface Applicant_Library_Interface_FlowApplyDao
{
	/**
	 * Perform a save operation to persist the information
	 * @param array $args
	 */
	public function save(array $args);

	/**
	 * Retrieve a record by the given name
	 * @param string $step
	 */
	public function findByStepName($step);

	/**
	 * Retrieves the engine used to persist our information
	 */
	public function getPersistanceTemplate();

	/**
	 * Initialize for the first time the persistance engine
	 * @param string $namespace
	 */
	public function initPeristanceTemplate(array $namespace);
	
	/**
	 * Finalize the engine
	 */
	public function endSession();
}
?>
