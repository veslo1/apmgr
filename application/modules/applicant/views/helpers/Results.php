<?php
/**
 * We will display a back to search results if we have the special parameter
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 */

class Applicant_View_Helper_Results extends ZFHelper_HelperCrud {

	/**
	 * The link we use to translate
	 * @var const
	 */
	const LINKNAME='backToSearchResults';

	/**
	 * Provide a Back to search results link
	 * @example $this->results($this->restore,$this->url(array('module'=>'applicant','controller'=>'view','action'=>'viewallapplicants','restore'=>$this->restore),null,true));
	 * @param int $flag This is received via query string , it's either 1 or 0
	 * @param Zend_View_Helper_Url $link
	 * @return string
	 */
	public function results($flag=0, $link) {
		$output = parent::NOLINK;
		if( $flag==1 ){
			$args = array('link'=>$link,'caption'=>self::LINKNAME,'image'=>'/images/24/arrow_left_green_48.gif');			
			$output = $this->display($args);			
		}
		return $output;
	}
}