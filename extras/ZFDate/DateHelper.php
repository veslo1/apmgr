<?php
/**
 * Determine that given dates that are going to be used in sql queries are safe to be used
 * We rely on the Zend_Date object to implement this validation
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 */

class ZFDate_DateHelper
{
	/**
	 * for singleton
	 * @var ZFDate_DateHelper
	 */
	private static $state;

	/**
	 * Object used in validation
	 * @var Zend_Date
	 */
	private $zendDate;

	/**
	 * Locale object
	 * @var Zend_Locale
	 */
	private $locale;
	
	final private function __construct()
	{
		$this->locale = Zend_Registry::get('Zend_Locale');
		Zend_Date::setOptions(array('format_type' => 'php'));
		$this->zendDate= new Zend_Date();
		$this->zendDate->setLocale($this->locale);
	}

	/**
	 * Retrieve the instance
	 * @return ZFDate_DateHelper
	 */
	public static function getInstance()
	{
		if (!(self::$state instanceof self))
		{
			self::$state = new self();
		}

		return self::$state;
	}

	/**
	 * Determine if a date is valid or not
	 * @param string $date
	 * @return boolean
	 */
	public function isValidDate($date=null)
	{
		$valid = false;
		try
		{
			$value = date_parse($date);
			if(isset($value['error_count']) and $value['error_count']>=1 )
			{
				$valid = false;
			}
			else
			{
				$timestamp = mktime(null, null, null, $value['month'], $value['day'], $value['year']);

				$this->zendDate->setTimestamp($timestamp);
				$valid = $this->zendDate->isDate($this->zendDate->toString('Y-m-d'), 'Y-m-d', $this->locale );
			}
		}
		catch(Zend_Date_Exception $e)
		{
			//nothing ...
		}
		return $valid;
	}
	
	/**
	 * No clones
	 */
	final private function __clone(){}
}