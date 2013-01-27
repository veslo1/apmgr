<?php
/**
 * Created on Sep 13, 2009
 * CrudBar.php
 * jvazquez
 * @package application.helpers
 * <p>
 * Tiny Class that receives one array and generates the proper html output if it can iterate over the records, else it will show a no results found message
 * </p>
 */
class Wulf_View_Helper_Resultcheck extends Zend_View_Helper_Abstract {

	/**
	 * @param module string Contains the current module name to build the link
	 * @param cssClass string The css class that you want to use to apply colors in the bar
	 */
	public function resultCheck($data=array()) {
		$output = true;
		if ( count($data)==0 ) {
			$output = false;
		}
		return $output;
	}

}
?>
