<?php
/**
 *
 * Interface that a the object that clones forms implements
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 */
interface ZFForm_Interface_Duplicable
{
	/**
	 * Name used in the form to deal with the dynamic-ness of it
	 * @var const
	 */
	const HIDDEN_INPUT = 'control';

	/**
	 * Magic key that triggers the action "repopulate"
	 * @var const
	 */
	const ACTION_ADD = 'add';

	/**
	 * Magic key to remove elements from the form.
	 * It acts on the child forms, and will not remove the parent form
	 * @var const
	 */
	const ACTION_REMOVE = 'remove';

	/**
	 * The default value of the seed
	 * @var const
	 */
	const DEFAULT_SEED_VALUE = 1;

	/**
	 * Which variable is used to create the child forms
	 * @var const
	 */
	const CHILD_FORM_SEPARATOR = "_";

	/**
	 * Set the flag
	 * @param boolean $isAdd
	 */
	public function setAdd($arg);

	/**
	 * Retrieve the isAdd state
	 * @return boolean
	 */
	public function getAdd();

	/**
	 * Set the seed for the form control.
	 * When the seed is invalid, we default it to 1
	 * @param int $seed
	 * @return number
	 */
	public function setSeed($seed);

	/**
	 * Return the control of the form.
	 * This integer value determines how many sub<tt>i</tt> elements we will spawn
	 * @return int
	 */
	public function getSeed();

	/**
	 * Set the flag
	 * @param boolean $remove
	 */
	public function setRemove($arg);

	/**
	 * Retrieve if we perform a remove action
	 * @return boolean
	 */
	public function getRemove();

	/**
	 * Realize the validation pertinent to an add
	 * @return int
	 */
	public function initAdd(array $request);

	/**
	 * Realize the validation pertinent to perform a remove action
	 * @return int
	 */
	public function initRemove(array $request);

	/**
	 * Determine the action that we will perform over a form.
	 * We can perform two kinds of actions, add or remove
	 * @param array $request
	 */
	public function determineAction(array $request);
}