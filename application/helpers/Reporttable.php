<?php
/**
 *
 * Writes a HTML table that will be printed in a view object
 * The urls provided will be used with sorting.
 * The internal implementation will be handled by a Factory
 * @see ZFHtml_Reporting_Factory
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 *
 */

class Wulf_View_Helper_Reporttable extends Zend_View_Helper_Abstract
{

	/**
	 * The method displays a HTML table that will only be displayed if we have records
	 * <p>The header array will contain the elements that will be present in records, thus leveraging
	 * the dynamic portions of the code that we had to deal in the past.
	 * It provides the proper sorting options that will be used in the table</p>
	 * @param array $header Array that contains the elements that are present.
	 * @param array $records Array that contains the records from a query to the data source
	 * @param boolean $useDom Display the html using DOM or String
	 */
	public function reporttable(array $header,array $records=null,$useDom=false)
	{
	}
}