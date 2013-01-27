<?php
/**
 * Business logic that all of our models should implement
 * @author jvazquez
 */
interface Calendar_Model_Interface_Rules {

	/**
	 * Determine if the given record exists
	 * @param int $id
	 */
	public function exists($id);

	/**
	 * Will take care of validating that the current record belongs
	 * to the current user or the current user is an admin and can
	 * alter this recrod
	 * @param arrary $args
	 * @return boolean
	 */
	public function ownership(array $args=null);
}
?>
