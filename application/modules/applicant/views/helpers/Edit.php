<?php
/**
 * Provides an icon to view the delete icon
 * Only the admin can delete roles
 * @author jvazquez
 */
class Applicant_View_Helper_Edit extends ZFHelper_HelperCrud {

	public function edit($recordId,$link,$caption=null) {
		$userId = User_Library_Helper_Utils::currentUserId();
		$helper = new User_Library_Helper_Utils();
		$isAdmin = $helper->isRole('admin');
		if( $isAdmin==true )
		{
			$strlink = $this->display(array('link'=>$link,'image'=>'/images/24/onebit_20.gif','caption'=>$caption));
		}
		return $strlink;
	}
}
?>