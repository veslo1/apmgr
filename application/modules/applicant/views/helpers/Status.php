<?php
/**
 * Display an html box for the list of statuses
 * @author Jorge Omar Vazquez
 *
 */

class Applicant_View_Helper_Status extends ZFHelper_HelperCrud {
	/**
	 * prepare a table with all the records
	 * @param array $recordId
	 * @return string
	 */
	public function status($status){
		$output = "<div>";
		$output .=$this->buildHistory($status);
		$ouput .="</div>";
		$this->roundHtml('blue',0,"style=\"width: 80%;height:50%; margin-top: 0%;\"");
		return $output;
	}

	private function buildHistory($status){
	}
}