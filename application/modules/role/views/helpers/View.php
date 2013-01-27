<?php
/**
 * Provide a view icon
 *
 * @author jvazquez
 */
class Role_View_Helper_View extends ZFHelper_HelperCrud {

	/**
	 * Do not apply filtering to the views
	 * @param string $link
	 * @param string $caption
	 * @return string
	 */
	public function view($link,$caption=null) {
		$strlink = $this->display(array('link'=>$link,'caption'=>$caption,'image'=>'/images/24/onebit_02.gif'));
		return $strlink;
	}
}
?>