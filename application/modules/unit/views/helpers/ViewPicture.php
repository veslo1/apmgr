<?php
/**
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 *
 */
class Unit_View_Helper_ViewPicture extends ZFHelper_HelperCrud {

	/**
	 * Display the link to view all the pictures
	 * @param int $id
	 * @param Zend_View_Helper_Url $link
	 * @param string $caption
	 */
	public function viewPicture($id,$link,$caption=null) {
		/**
		 * TODO Apply the logic that you consider to display icons since there are not fields
		 * available in apartment or unit to say , this app or unit belong to
		 */
		$strlink = $this->display(array('link'=>$link,'caption'=>$caption,'image'=>'/images/24/onebit_02.gif'));
		return $strlink;
	}
}