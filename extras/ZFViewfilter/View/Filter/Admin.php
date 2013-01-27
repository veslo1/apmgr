<?php
/**
 * @author janburkl
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * <p>Filter implementation , based on Janburki's one. We display resources if the user is logged in and belongs to him</p>
 */
class ZFViewfilter_View_Filter_Admin implements Zend_Filter_Interface {

	/**
	 * (non-PHPdoc)
	 * @see library/Zend/Filter/Zend_Filter_Interface#filter($value)
	 */
	public function filter( $value )
	{
		$result = ZFUtil_Utils::isAdmin();
		if( $result['admin'] == false )
		{
			$value = preg_replace('/<admin>.*?<\/admin>/sm','',$value);
		}

		return $value;
	}
}