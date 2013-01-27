<?php
/**
 * Implementation of the rules that all implementations should have.
 * This defines the method of operation , leaving place for custom implementation
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 */

interface ZFReport_Interfaces_ISpreadsheetWritable
{
  /**
   * Set the engine that will be used to write
   * @param Spreadsheet_Excel_Writer $writer
   */
  public function setWorkbook($writer);

  /**
   * Retrieve the custom writer that will be used
   * @return Spreadsheet_Excel_Writer $writer
   */
  public function getWorkbook();

  /**
   * Write the content as desired.
   * The operation should return true on success
   * @return boolean
   */
  public function write();
}
?>
