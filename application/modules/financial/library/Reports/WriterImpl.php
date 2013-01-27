<?php
/**
 * Implementation of the excel writer app for the custom report Income Statement
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 */
class Financial_Library_Reports_WriterImpl implements ZFReport_Interfaces_ISpreadsheetWritable
{
	/**
	 * @var Spreadsheet_Excel_Writer $workbook
	 */
	private $workbook;

	/**
	 * @var Spreadsheet_Excel_Writer_Worksheet
	 */
	private $worksheet;

	/**
	 * Title of the sheet
	 * @var string $sheetName
	 */
	private $sheetName;

	/**
	 * This way , you can push stuff into the array , and you can control it on write
	 * @var array
	 */
	private $sections;

	/**
	 * Set the sections used in this writer
	 * @param array $sections
	 */
	public function setSections(array $sections)
	{
		$this->sections = $sections;
	}

	/**
	 * Retrieve the sections used in this writer
	 * @return multitype:
	 */
	public function getSections()
	{
		return $this->sections;
	}

	/**
	 * Set the title of the sheet
	 * @param string $sheetName
	 */
	public function setSheetName($sheetName)
	{
		$this->sheetName = $sheetName;
	}

	/**
	 * Get the name of the sheet
	 * @return string
	 */
	public function getSheetName()
	{
		return $this->sheetName;
	}

	/* (non-PHPdoc)
	 * @see src/com/vazney/writer/Interface/ISpreadsheetWritable::setWorkbook()
	 */
	public function setWorkbook($writer)
	{
		$this->workbook = $writer;
	}

	/* (non-PHPdoc)
	 * @see src/com/vazney/writer/Interface/ISpreadsheetWritable::getWorkbook()
	 */
	public function getWorkbook()
	{
		return $this->workbook;
	}

	/**
	 * Set the date
	 * @param date $date
	 */
	public function setDate($date)
	{
		$this->date = $date;
	}

	/**
	 * Retrieve the date
	 * @return date
	 */
	public function getDate()
	{
		return $this->date;
	}

	/* (non-PHPdoc)
	 * @see src/com/vazney/writer/Interface/ISpreadsheetWritable::write()
	 */
	public function write()
	{
		$payload = $this->getSections();
		if( $payload==null )
		{
			throw new Exception('There is no information to write in the file');
		}
		$this->workbook->send('report.xls');
		$this->worksheet = &$this->workbook->addWorksheet($this->getSheetName());
		//	We retrieve the information to write
		//	format the date
		$format_courier =& $this->workbook->addFormat();
		$format_courier->setFontFamily('Courier');
		$format_courier->setItalic();
		$format_courier->setSize(10);
		$this->worksheet->write(0,0, current($payload[0]), $format_courier);

		//	we format the numbers to the left
		$formatNumber =& $this->workbook->addFormat();
		$formatNumber->setAlign('left');

		//	And the accounts to the right
		$formatRegularElements=& $this->workbook->addFormat();
		$formatRegularElements->setAlign('right');

		//	Format the title
		$format_title =& $this->workbook->addFormat();
		$format_title->setBold();
		// Tell excel to center the content
		$format_title->setAlign('center');
		// Merge cells from row 0, col 0 to row 0, col 2
		$this->worksheet->setMerge(1, 0, 1, 2);
		$this->worksheet->write(1,0, current($payload[1]), $format_title);

		/**
		 * Now deal with the core
		 * Though , if you don't want that , you can create it by other means, I don't know, I think that if you set this as a setter
		 * you are done with this
		 */
		$row = 2;
		$col = 0;

		//  We start at row 2, because we put the date on row 0 , title in row 1, now we take control of this
		foreach($payload[2] as $name=>$value)
		{
			$this->worksheet->write($row,$col,$name,$formatRegularElements);
			$col+=2;
			$this->worksheet->write($row,$col,$value,$formatNumber);
			//  We write in fixed positions , so we really need to reset after writting
			$col = 0;
			$row++;
		}
		//  Cols are defined like this , because we know that we have a span from 0 to 2
		//  Wr write Total revenue
		$formatBold = & $this->workbook->addFormat();
		$formatBold->setBold();
		$formatBold->setAlign('right');
		$this->worksheet->write($row,0, key($payload[3]), $formatBold );
		$this->worksheet->write($row,2, current($payload[3]),$formatNumber );
		$row+=2;

		//	Title for expense and formated
		$format_title =& $this->workbook->addFormat();
		$format_title->setBold();
		// Tell excel to center the content
		$format_title->setAlign('center');
		// Merge cells from row 0, col 0 to row 0, col 2
		$this->worksheet->setMerge($row, 0, $row, 2);
		$this->worksheet->write($row,0, current($payload[4]),$format_title);
		$row++;
		//	Reset the column
		$col = 0;
		foreach($payload[5] as $name=>$value)
		{
			$this->worksheet->write($row,$col, $name,$formatRegularElements);
			$col+=2;
			$this->worksheet->write($row,$col, $value,$formatNumber);
			//  We write in fixed positions , so we really need to reset after writting
			$col = 0;
			$row++;
		}
		//	Print the total for expense
		$this->worksheet->write($row,0, key($payload[6]),$formatBold );
		$this->worksheet->write($row,2, current($payload[6]),$formatNumber);
		$row+=2;

		//  Wr write the balance
		$this->worksheet->write($row,0, key($payload[7]),$formatBold );
		$this->worksheet->write($row,2, current ($payload[7]),$formatNumber);

		return $this->workbook->close();
	}
}
?>
