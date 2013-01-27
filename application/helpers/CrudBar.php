<?php
/**
 * Created on Sep 13, 2009
 * CrudBar.php
 * jvazquez
 * @package application.helpers
 * <p>
 * Tiny Class that receives one parameter and builds a nice crud bar
 * </p>
 */
class Wulf_View_Helper_Crudbar extends Zend_View_Helper_Abstract {

	/**
	 * @param module string Contains the current module name to build the link
	 * @param cssClass string The css class that you want to use to apply colors in the bar
	 */
	public function crudBar($module,$cssClass='crudbar') {
		$output  = "<div id=\"cscorange\">
 							<span class=\"trorange\"></span>
							<a  href='/$module/index'>Index</a>
							<a  href='/$module/create'>Create</a>
							<a href='/$module/search'>Search</a>
							<a href='/$module/view'>View All</a>
							 <span class=\"blorange\"></span>
 							<span class=\"brorange\"></span>
							</div>";
		return $output;
	}

}
?>
