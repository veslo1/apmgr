<?php
/**
 * @author janburkl
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * <p>Filter implementation , based on Janburki's one. We display resources if the user is logged in and belongs to him</p>
 */
class ZFViewfilter_View_Filter_Show implements Zend_Filter_Interface {

	/**
	 * (non-PHPdoc)
	 * @see library/Zend/Filter/Zend_Filter_Interface#filter($value)
	 */
	public function filter( $value )
	{
		//	Retrieve identity
		$auth = Zend_Auth::getInstance();
		$auth->setStorage(new Zend_Auth_Storage_Session('vazneyStorage'));  // needs to match the loggedIn helper name
		$loggedIn = $auth->getIdentity();

		if( $loggedIn === NULL )
		{
			$value = preg_replace('/<display>.*?<\/display>/sm','',$value);
		}
		return $value;
	}
}