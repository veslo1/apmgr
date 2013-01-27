<?php
/**
 * This utility class aids in the construction of sql queries that deals with orders
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 */

class ZFDb_SortHelper extends Object_Instrospection implements
ZFInterfaces_Sortable,
ZFInterfaces_Messageable
{
	/**
	 * A string that holds a token to identify errors
	 * @var string
	 */
	protected $msg;

	/**
	 * The order that we will use to sort the records
	 * @var string
	 */
	protected $mode;

	/**
	 * Contains the column that will be used
	 * @var string
	 */
	protected $by;

	/**
	 * This attribute contains an array of your valid columns
	 * @var array
	 */
	protected $validColumns;

	/**
	 * Constructor of this helper
	 * @param array $options
	 */
	public function __construct(array $options=null)
	{
		$this->instrospect($options);
	}

	/* (non-PHPdoc)
	 * @see library/ZFInterfaces/ZFInterfaces_Sortable::setMode()
	 */
	public function setMode($order=null)
	{
		$this->mode = $order;
	}

	/* (non-PHPdoc)
	 * @see library/ZFInterfaces/ZFInterfaces_Sortable::getMode()
	 */
	public function getMode()
	{
		return $this->mode;
	}

	/* (non-PHPdoc)
	 * @see library/ZFInterfaces/ZFInterfaces_Sortable::setBy()
	 */
	public function setBy($column=null)
	{
		$this->by = $column;
	}

	/* (non-PHPdoc)
	 * @see library/ZFInterfaces/ZFInterfaces_Sortable::getBy()
	 */
	public function getBy()
	{
		return $this->by;
	}

	/* (non-PHPdoc)
	 * @see library/ZFInterfaces/ZFInterfaces_Sortable::setValidColumns()
	 */
	public function setValidColumn(array $columns)
	{
		$this->validColumns = $columns;
	}

	/* (non-PHPdoc)
	 * @see library/ZFInterfaces/ZFInterfaces_Sortable::getValidColumns()
	 */
	public function getValidColumns()
	{
		return $this->validColumns;
	}

	/* (non-PHPdoc)
	 * @see library/ZFInterfaces/ZFInterfaces_Sortable::isSorting()
	 */
	public function isSorting()
	{
		$sorting = false;
		$order = $this->getMode();
		$column = $this->getBy();
		$validColumns = $this->getValidColumns();
		if( ( $order==self::ASCVIEW or $order==self::DESCVIEW ) and null!==$column and is_array($validColumns) )
		{
			$sorting = in_array($column,$validColumns);
		}
		//	We buffer it here, so then we confirm it later
		$this->state = $sorting;
		return $sorting;
	}

	/* (non-PHPdoc)
	 * @see library/ZFInterfaces/ZFInterfaces_Sortable::prepareOrderQuery()
	 */
	public function prepareOrderQuery()
	{
		$order = '';
		$mode = '';
		switch($this->getMode())
		{
			case self::ASCVIEW:
				$mode = self::ASC;
				break;
			case self::DESCVIEW:
				$mode = self::DESC;
				break;
			default:
				$this->setMessageState('invalidColumnSpecified');
				throw new Exception('Unhandled mode');
				break;
		}
		$order = $this->getBy().' '.$mode;
		return $order;
	}

	/* (non-PHPdoc)
	 * @see library/Object/Object_Instrospection::setMessageState()
	 */
	public function setMessageState($msg)
	{
		$this->msg = $msg;
	}

	/* (non-PHPdoc)
	 * @see library/Object/Object_Instrospection::getMessageState()
	 */
	public function getMessageState()
	{
		return $this->msg;
	}
}