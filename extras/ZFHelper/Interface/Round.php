<?php
/**
 * We define the basic attributes for round
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 */

interface ZFHelper_Interface_Round {
	/**
	 * Default div wrapper style for the fancy round
	 * @var const
	 */
	const DEFAULTDIVSTYLE="style=\"width: 80%;height:50%; margin-top: 0%;\"";

	/**
	 * The default css class
	 * @var const
	 */
	const DEFAULTCSSCLASS="roundcorner_32_grey";

	/**
	 * The max range in the css for round
	 * @var unknown_type
	 */
	const DEFAULTMAXLEVEL=23;

	/**
	 * Generate the cool round html
	 * @param string $cssSpanClass The base class you use for the coloring
	 * @param int $cssSpanIndex the default index
	 * @param string $divWrapperStyle
	 * @param string $element The element to display , that must have the style
	 * @return string
	 */
	function roundHtml($cssSpanClass='grey',$cssSpanIndex=0,$divWrapperStyle=null,$element);
}