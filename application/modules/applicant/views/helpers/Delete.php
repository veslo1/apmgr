<?php
/**
 * Provides a delete icon if the setting is not protected
 *
 * @author jvazquez <jvazquez@debserverp4.com.ar>
 */
class Applicant_View_Helper_Delete extends ZFHelper_HelperCrud {

	/**
	 *
	 * @param int $recordId
	 * @param string $link
	 * @param string $caption
	 * @return string
	 */
	public function delete($recordId,$link,$caption) {
		$strlink = '';
		$setting = new Applicant_Model_FeeSetting();
		$record = $setting->findById($recordId);

		if( !empty($record) ) {
			$userId = User_Library_Helper_Utils::currentUserId();
			$helper = new User_Library_Helper_Utils();
			$isAdmin = $helper->isRole('admin');
			if( $isAdmin==true )
			{
				$strlink = $this->display(array('link'=>$link,'caption'=>$caption,'image'=>'/images/24/onebit_33.gif'));
			}
		}
		return $strlink;
	}
}
?>