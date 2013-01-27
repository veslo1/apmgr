<?php
/**
 * Description of DeletePictures
 * @author jvazquez
 * @package application.modules.unit.views.scripts.helpers
 */

class Unit_View_Helper_DeletePictures extends ZFHelper_HelperCrud
{
	/**
	 * Display the link to delete picture
	 * @param int $id
	 * @param Zend_View_Helper_Url $link
	 * @param string $caption
	 */
	public function deletePictures($id,$link,$caption=null)
	{
		/**
		 * TODO Apply the logic that you consider to display icons since there are not fields
		 * available in apartment or unit to say , this app or unit belong to
		 */
		$helper = new User_Library_Helper_Utils;
		$strlink = '';
		if( $helper->isRole('admin') == true )
		{
			$strlink = $this->display(array('link'=>$link,'caption'=>$caption,'image'=>'/images/24/cancel.gif'));
		}
		return $strlink;
	}
}
?>