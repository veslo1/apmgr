<?php
/**
 * Provides a delete icon if the role is not protected
 *
 * @author jvazquez <jvazquez@debserverp4.com.ar>
 */
class Role_View_Helper_Delete extends ZFHelper_HelperCrud {

	/**
	 *
	 * @param int $recordId
	 * @param string $link
	 * @param string $caption
	 * @return string
	 */
	public function delete($recordId,$link,$caption) {
		$strlink = '';
		$role = new Role_Model_Role();
		$record = $role->findById($recordId);

		if( !empty($record) and $record->getProtected()==false) {
			$userHelper= new User_Library_Helper_Utils();
			$userId = User_Library_Helper_Utils::currentUserId();
			$isAdmin = $userHelper->isRole('admin');
			if( $isAdmin==true ) {
				$strlink = $this->display(array('link'=>$link,'caption'=>$caption,'image'=>'/images/24/onebit_33.gif'));
			}
		}
		return $strlink;
	}
}
?>