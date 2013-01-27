<?php
/**
 * Provides a delete icon if the role is not protected
 *
 * @author jvazquez <jvazquez@debserverp4.com.ar>
 */
class Settings_View_Helper_Delete extends ZFHelper_HelperCrud {

	/**
	 *
	 * @param int $recordId
	 * @param string $link
	 * @param string $caption
	 * @return string
	 */
	public function delete($recordId,$link,$caption) {
		$strlink = '';
		$settings = new Settings_Model_Settings();
		$record = $settings->findById($recordId);

		if( !empty($record) ) {
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