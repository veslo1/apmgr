<?php
/**
 * Implementation of the SpreadSheet_Excel_Writer object
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 */
class Financial_View_Helper_Export extends Zend_View_Helper_Abstract
{
	/**
	 * Generate the proper header when we are going to export the report
	 * @param boolean $exporting
	 * @param array $data
	 */
	public function export($exporting=false,array $info)
	{
		if($exporting==true)
		{
			$workbook = new Spreadsheet_Excel_Writer();
			$worksheet = &$workbook->addWorksheet('Rent Roll');
			$headers = Financial_Library_Reports_RentRoll::$columnMap;
			$column = 0;
			$row = 0;
			$totalColumns = count($headers);
			//	Write the header
			for($column=0;$column<$totalColumns;$column++)
			{
				$worksheet->write($row, $column, $headers[$column],null);
			}
			//	Move one row so we start pushing the information
			$row = $row+1;
			$workbook->send('report.xls');
		}
		exit();
	}
}