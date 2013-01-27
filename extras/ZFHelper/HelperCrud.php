<?php
/**
 * Description of HelperCrud
 *
 * @author jvazquez
 */
abstract class ZFHelper_HelperCrud extends Zend_View_Helper_Abstract implements ZFHelper_Interface_Html,ZFHelper_Interface_Round{

	/**
	 * Return the translator for i18n
	 * @return Zend_Translate
	 */
	protected function getTranslator(){
		return Zend_Registry::get('Zend_Translate');
	}

	/**
	 * Array that contains a `link` Zend_View_Helper_Url,a string `caption`that is the text of the anchor and optionally the path of an image `image`
	 * @param array $args
	 * @return string
	 */
	protected function display($args) {
		$translator = $this->getTranslator();
		if(isset($args['link'])==false){
			$strlink = "<img src=\"".$args['image']."\" title=\"".$translator->translate($args['caption'])."\" alt=\"".$translator->translate($args['caption'])."\"/>";
		} else {
			$strlink = "<a href=\"".$args['link']."\"><img src=\"".$args['image']."\" title=\"".$translator->translate($args['caption'])."\" alt=\"".$translator->translate($args['caption'])."\"/></a>";
		}
		return $strlink;
	}

	/**
	 * Create a regular <a>... link
	 * @param array $args
	 * @return string
	 */
	public function createAnchor($args){
		$translator = $this->getTranslator();
		$strlink = "<a href=\"".$args['link']."\">".$translator->translate($args['caption'])."</a>";
		return $strlink;
	}
	
	/* (non-PHPdoc)
	 * @see Interface/ZFHelper_Interface_Round::roundHtml()
	 */
	public function roundHtml($cssSpanClass='grey',$cssSpanIndex=0,$divWrapperStyle=null,$element){
		$divWrapperStyle = $divWrapperStyle==null?self::DEFAULTDIVSTYLE:$divWrapperStyle;
		$output = "<div =\"".$divWrapperStyle."\">";
		$output .="<span class=\"roundcorner_32".$cssSpanClass."\">";
		//	0 to max
		for($i=$cssSpanIndex;$i<self::DEFAULTMAXLEVEL;$i++){
			$output .="<span class=\"roundcorner_32".$cssSpanClass.$i."\"></span>";
		}
		$output .="</span>";
		$output .= $element;
		$output .="<span class=\"roundcorner_32".$cssSpanClass."\">";
		//	max to 0
		for($i=self::DEFAULTMAXLEVEL;$i<=$cssSpanIndex;$i++){
			$output .="<span class=\"roundcorner_32".$cssSpanClass.$i."\"></span>";
		}
		$output .="</span>";
		$output .="</div>";
		return $output;
	}
}
?>
