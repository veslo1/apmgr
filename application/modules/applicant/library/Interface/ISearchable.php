<?php
/**
 * Implementation that creates the rules that search objects should implement
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 */

interface Applicant_library_Interface_ISearchable {
	
	/**
	 * Perform a search against the given object that you define as your target
	 * @return array
	 */
	public function search();
	
	/**
	 * Build the query that you are going to implement
	 * @return Zend_Db_Select|string
	 */
	public function buildQuery();
	
	/**
	 * Set the arguments that are pertinent to the query
	 * @param array $arguments
	 */
	public function setArguments(array $arguments=null);
	
	/**
	 * Retrieve the arguments that are pertinent to the query
	 */
	public function getArguments();

}