<?php
/**
 *  @author rnelson
 *  date: Jan 28, 2010
 *
 *  Am a lazy fuck and stole this from here:  http://www.ninjacipher.com/2007/11/14/view-helpers-in-zend-framework/
 *  However, the code sucked in some places and didn't work in others so had to modify a tad
 */

class Wulf_View_Helper_DateFormat extends Zend_View_Helper_Abstract {
	private $date_formats = array("mdy"=>"MM/dd/yyyy",
				      "fy"=>"MMMM yyyy",
				      "mdyt"=>"MM/dd/yyyy hh:mm:ss");

	public function dateFormat($date, $formatName, $formatStr = '') {
		$formattedDate = null;
		// assume mysql datetime
		//if (!Zend_Date::isDate($date, 'Y-m-d H:i:s'))
		if (!Zend_Date::isDate($date, 'Y-m-d')) {
			$formattedDate = $date;
		} else {
			$zendDate = new Zend_Date($date, Zend_Date::ISO_8601);

			if( isset($formatName) ) {
				$formattedDate = $zendDate->toString($this->date_formats[$formatName]);
			}  else if( isset($formatStr) ) {
				$formattedDate = $zendDate->toString($formatStr);
			}
		}
		return $formattedDate;
	}
}
?>