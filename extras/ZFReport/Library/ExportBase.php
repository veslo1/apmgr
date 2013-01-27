<?php
/**
 * Implementation of the exporting API
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 */

abstract class ZFReport_Library_ExportBase extends Object_Instrospection implements ZFInterfaces_Messageable
{
	protected $msg;
	
	/* (non-PHPdoc)
	 * @see Object_Instrospection::setMessageState()
	 */
	public function setMessageState($msg)
	{
		$this->msg = $msg;
	}
	
	/* (non-PHPdoc)
	 * @see Object_Instrospection::getMessageState()
	 */
	public function getMessageState()
	{
		return $this->msg;
	}
}