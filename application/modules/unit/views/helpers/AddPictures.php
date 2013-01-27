<?php
/**
 * Show a link to add pictures
 *
 * @author Jorge Vazquez <jvazquez@debserverp4.com.ar>
 */
class Unit_View_Helper_AddPictures extends ZFHelper_HelperCrud {

	/**
	 * Display the link to add pictures
	 * @param int $id
	 * @param Zend_View_Helper_Url $link
	 * @param string $caption
	 */
	public function addPictures($id,$link,$caption=null) {
		/**
		 * TODO Apply the logic that you consider to display icons since there are not fields
		 * available in apartment or unit to say , this app or unit belong to
		 */
		$strlink = $this->display(array('link'=>$link,'caption'=>$caption,'image'=>'/images/24/camera_add_48.gif'));
		return $strlink;
	}
}
?>
