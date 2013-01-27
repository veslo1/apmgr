<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ViewPictures
 *
 * @author jvazquez
 */
class Unit_View_Helper_ViewPictures extends ZFHelper_HelperCrud {

	/**
	 * Display the link to view all the pictures
	 * @param int $id
	 * @param Zend_View_Helper_Url $link
	 * @param string $caption
	 */
	public function viewPictures($id,$link,$caption=null) {
		/**
		 * TODO Apply the logic that you consider to display icons since there are not fields
		 * available in apartment or unit to say , this app or unit belong to
		 */
		$strlink = $this->display(array('link'=>$link,'caption'=>$caption,'image'=>'/images/24/camera_48.gif'));
		return $strlink;
	}
}
?>
