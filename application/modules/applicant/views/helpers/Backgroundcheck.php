<?php
/**
 * Provide a link that allows the user to take notes when the background check is run
 *
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 */
class Applicant_View_Helper_Backgroundcheck extends ZFHelper_HelperCrud {

	/**
	 * Basic link creation for lease agent view
	 * @param int $billId
	 * @param Zend_View_Helper_Url $link
	 * @param string $caption
	 * @return string
	 */
	public function backgroundcheck($billId=null,$link,$caption) {
		$strlink = parent::NOLINK;
		if( $billId!=null ){
			$strlink = $this->display(array('link'=>$link,'image'=>'/images/24/hot.gif','caption'=>$caption));
		}
		return $strlink;
	}
}
?>