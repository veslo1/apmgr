<?php
/**
 * Allow the admin to delete permissions
 *
 * @author jvazquez
 */
class Role_View_Helper_PermissionDelete extends ZFHelper_HelperCrud {

	public function permissionDelete($id,$link,$caption=null) {
		$strlink = '';
		$userHelper= new User_Library_Helper_Utils();
		$userId = User_Library_Helper_Utils::currentUserId();
		$isAdmin = $userHelper->isRole('admin');
		if( $isAdmin==true ) {
			$strlink = $this->display(array('link'=>$link,'caption'=>$caption,'image'=>'/images/24/onebit_33.gif'));
		}
		return $strlink;
	}
}
?>
