<?php
/**
 * @author janburkl
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * Filter implementation , based on Janburki's one. We display resources if the user is logged in and belongs to him
 */
class ZFViewfilter_View_Filter_Menu implements Zend_Filter_Interface
{
	/**
	 * (non-PHPdoc)
	 * @see library/Zend/Filter/Zend_Filter_Interface#filter($value)
	 */
	public function filter( $value )
	{
		$result = ZFUtil_Utils::isAdmin();
		if( $result['admin']==false )
		{
			$value = preg_replace('/<adminMenu>.*?<\/adminMenu>/sm','',$value);
		}
		return $value;
	}
}