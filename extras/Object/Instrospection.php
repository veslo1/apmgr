<?php
/**
 * Base class for objects
 * @author Jorge Omar Vazquez<jvazquez@debserverp4.com.ar>
 */
abstract class Object_Instrospection implements ZFInterfaces_Messageable {

	/**
	 * Default constant used for setters
	 * @var const
	 */
	const SET='set';

	/**
	 * A string that identifies an message that the current object has
	 * @var string
	 */
	protected $msg;

	/**
	 * Zend_Config object to store properties
	 * @var Zend_Config
	 */
	protected $properties;

	/**
	 * Read the object methods and set them
	 * @return Object_Instropection
	 */
	public function instrospect(array $options=null)
	{
		if($options!==null)
		{
			$methods = get_class_methods($this);
			foreach ($options as $key => $value)
			{
				$method = self::SET.ucfirst($key);
				if ( in_array($method, $methods) )
				{
					$this->$method($value);
				}
			}
		}
		return $this;
	}


	/**
	 * Set the state of the object
	 * @param string $msg
	 */
	public function setMessageState($msg) {
		$this->msg = $msg;
	}

	/**
	 * Retrieve the state of the object
	 * @return string
	 */
	public function getMessageState(){
		return $this->msg;
	}

	/**
	 * Set the properties of this class
	 * @param string $path
	 * @param string $env
	 */
	public function setProperties($path,$env) {
		$this->properties = new Zend_Config_Ini($path,$env);
	}

	/**
	 * Retrieve the properties of this object
	 * @return Zend_Config
	 */
	public function getProperties() {
		return $this->properties;
	}
}