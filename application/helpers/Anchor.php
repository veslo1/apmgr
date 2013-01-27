<?php
/**
 * We will display a back to search results if we have the special parameter
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 */

class Wulf_View_Helper_Anchor extends ZFHelper_HelperCrud {

	/**
	 * The link we use to translate
	 * @var const
	 */
	const LINKNAME='backToPreviousPage';

	/**
	 * Provide a Back to search results link
	 * @example $this->results($this->restore,$this->url(array('module'=>'applicant','controller'=>'view','action'=>'viewallapplicants','restore'=>$this->restore),null,true));
	 * @param int $flag This is received via query string , it's either 1 or 0
	 * @param Zend_View_Helper_Url $link
	 * @return string
	 */
	public function anchor(array $url=null) {
		$output = parent::NOLINK;
		
		if( isset($url['module']) and isset($url['controller']) and isset($url['action']) and isset($url['persist']) ) {
			$text = new Zend_View_Helper_Url();
			$translator = $this->getTranslator();
			$anchor=$text->url(array('module'=>$url['module'],'controller'=>$url['controller'],'action'=>$url['action']));
			$anchorText = isset($url['text'])?$url['text']:self::LINKNAME;
			$output ="<a href=\"$anchor\">".$translator->_($anchorText)."</a>";
		}
		return $output;
	}
}