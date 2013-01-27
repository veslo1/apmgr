<?php
/**
 * @author janburkl
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * <p>Filter implementation , based on Janburki's one. We display resources if the user is logged in and belongs to him</p>
 */
class ZFViewfilter_View_Filter_Contentcheck implements Zend_Filter_Interface {

	/**
	 * (non-PHPdoc)
	 * @see library/Zend/Filter/Zend_Filter_Interface#filter($value)
	 */
	public function filter( $value )
	{
		$start = strpos($value, "<contentcheck>");
		$end = strpos($value, "</contentcheck>");
		$test = preg_split('/<contentcheck>.*?<\/contentcheck>/sm',$value,0,PREG_SPLIT_NO_EMPTY);
		//	If we have an empty value that the user wants to show , replace it with an error message.
		if( empty($value) )
		{
			/**
			 * Find the generic Missing value message
			 * Now show that message and voila , no more if else's on the view
			 */
			if( $start!=false and $end!=false)
			{
				$value = 'missingValue';
			}
		}
		return $value;
	}
}