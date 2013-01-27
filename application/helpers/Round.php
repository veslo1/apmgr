<?php
/**
 * Add the html for round
 * @internal What do you need ? ->headLink()->appendStylesheet('/css/roundcorner_32_grey.css');
 * The element that you sent must contain this stlye class="roundcorner_32_grey_content"
 * It will generate a grey circle
 */
class Wulf_View_Helper_Round extends Zend_View_Helper_Abstract {

	/**
	 * Using the css for round elements, spit out the complex html this form uses
	 * @param Zend_Form|string $element
	 * @return string
	 */
	public function round($element) {
		$output = "<div style=\"width: 80%;height:50%; margin-top: 0%;\">
		<span class=\"roundcorner_32_grey\"> 
			<span class=\"roundcorner_32_grey0\"></span>
			<span class=\"roundcorner_32_grey1\"></span>
			<span class=\"roundcorner_32_grey2\"></span>
			<span class=\"roundcorner_32_grey3\"></span>
			<span class=\"roundcorner_32_grey4\"></span>
			<span class=\"roundcorner_32_grey5\"></span>
			<span class=\"roundcorner_32_grey6\"></span>
			<span class=\"roundcorner_32_grey7\"></span>
			<span class=\"roundcorner_32_grey8\"></span>
			<span class=\"roundcorner_32_grey9\"></span>
			<span class=\"roundcorner_32_grey10\"></span>
			<span class=\"roundcorner_32_grey11\"></span>
			<span class=\"roundcorner_32_grey12\"></span>
			<span class=\"roundcorner_32_grey13\"></span>
			<span class=\"roundcorner_32_grey14\"></span>
			<span class=\"roundcorner_32_grey15\"></span>
			<span class=\"roundcorner_32_grey16\"></span>
			<span class=\"roundcorner_32_grey17\"></span>
			<span class=\"roundcorner_32_grey18\"></span>
			<span class=\"roundcorner_32_grey19\"></span>
			<span class=\"roundcorner_32_grey20\"></span>
			<span class=\"roundcorner_32_grey21\"></span>
			<span class=\"roundcorner_32_grey22\"></span>
			<span class=\"roundcorner_32_grey23\"></span>
		</span>
		$element
		<span class=\"roundcorner_32_grey\">
			<span class=\"roundcorner_32_grey23\"></span>
			<span class=\"roundcorner_32_grey22\"></span>
			<span class=\"roundcorner_32_grey21\"></span>
			<span class=\"roundcorner_32_grey20\"></span>
			<span class=\"roundcorner_32_grey19\"></span>
			<span class=\"roundcorner_32_grey18\"></span>
			<span class=\"roundcorner_32_grey17\"></span>
			<span class=\"roundcorner_32_grey16\"></span>
			<span class=\"roundcorner_32_grey15\"></span>
			<span class=\"roundcorner_32_grey14\"></span>
			<span class=\"roundcorner_32_grey13\"></span>
			<span class=\"roundcorner_32_grey12\"></span>
			<span class=\"roundcorner_32_grey11\"></span>
			<span class=\"roundcorner_32_grey10\"></span>
			<span class=\"roundcorner_32_grey9\"></span>
			<span class=\"roundcorner_32_grey8\"></span>
			<span class=\"roundcorner_32_grey7\"></span>
			<span class=\"roundcorner_32_grey6\"></span>
			<span class=\"roundcorner_32_grey5\"></span>
			<span class=\"roundcorner_32_grey4\"></span>
			<span class=\"roundcorner_32_grey3\"></span>
			<span class=\"roundcorner_32_grey2\"></span>
			<span class=\"roundcorner_32_grey1\"></span>
			<span class=\"roundcorner_32_grey0\"></span>
		</span>";
		return $output;
	}



}
?>