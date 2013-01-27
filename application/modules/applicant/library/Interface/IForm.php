<?php
interface Applicant_Library_Interface_IForm {
	/**
	 * The Zend_Form_Element type that has problems when it's populated
	 * @var const
	 */
	const TARGETCASE = 'Zend_Form_Element_Select';

	/**
	 * Prefix for the form
	 * @var const
	 */
	const FORMPREFIX = 'Applicant_Form_';

	/**
	 * Prefix used for sub forms
	 * @var const
	 */
	const SUBFORMPREFIX = 'Applicant_Form_Sub';
}