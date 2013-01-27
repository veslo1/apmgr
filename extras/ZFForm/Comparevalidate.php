<?php
/**
 * Compare two different dates and validate that the range is valid.
 * The pivot for this object is dateTo , and the comparator is dateFrom.
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @since 2010-11-30 , Added configuration to allow different keys, by default will compare against startDate
 */
class ZFForm_Comparevalidate extends Zend_Validate_Abstract {
	
	/**
	 * @var Const
	 */
	const NOT_MATCH = 'notvaliddaterange';

	const DEFAULTKEY = 'startDate';
	
	/**
	 * @var array
	 */
	protected $_messageTemplates = array(self::NOT_MATCH => 'notvaliddaterange');

	/**
	 * The key that will be used in the object
	 * @var string
	 */
	protected $targetKey;
	
	/**
	 * Configure this validator to compare two different dates
	 * @param string $targetKey
	 */
	public function __construct($targetKey=self::DEFAULTKEY)
	{
		$this->targetKey = $targetKey;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see library/Zend/Validate/Zend_Validate_Interface#isValid($value)
	 */
	public function isValid($dateTo,$dateFrom=null)
	{
		$valid = false;
		//	Date must come in SQL format
		try
		{
			$events = new Calendar_Model_Events();
			$props = $events->getProperties();
			$format = $props->date->sqlformat;

			Zend_Date::setOptions(array('format_type' => 'php'));
			$zendDateFrom =  new Zend_Date($dateFrom[$this->targetKey],$format,Zend_Registry::get('Zend_Locale'));
			$zendDateTo = new Zend_Date($dateTo,$format,Zend_Registry::get('Zend_Locale'));
			//	We can save events for the same day.
			$buffer[] = $zendDateTo->isEarlier($zendDateFrom);
			$buffer[] = $zendDateTo->isToday($zendDateFrom) ;
			$valid = in_array(false,$buffer)==true?true:false;
			if( $valid===false )
			{
				$this->_error(self::NOT_MATCH);
			}
			else
			{
				$valid = true;
			}
		}
		catch(Exception $e)
		{
			$this->_error(self::NOT_MATCH);
		}
		catch (Zend_Date_Exception $e)
		{
			$this->_error(self::NOT_MATCH);
		}
		return $valid;
	}

}