<?php
/**
 * Provides a link that links you to bill information if the user paid, else we display a text message
 *
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 */
class Applicant_View_Helper_Paid extends ZFHelper_HelperCrud {

	/**
	 * Basic link creation for lease agent view
	 * @param int $billId
	 * @param Zend_View_Helper_Url $link
	 * @param string $caption
	 * @return string
	 */
	public function paid($billId=null,$link,$caption) {
		$strlink = '';
		if($billId!=null){
			$strlink = $this->display(array('link'=>$link,'image'=>'/images/24/hot.gif','caption'=>$caption));
		} else {
			$strlink = $this->display(array(null,'image'=>'/images/24/dollar.gif','caption'=>'userDidNotPayYet'));
		}
		return $strlink;
	}
}
?>