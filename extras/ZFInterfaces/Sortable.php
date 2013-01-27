<?php
/**
  * Definition of rules that a sortable data object should implement
  * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
  */
interface ZFInterfaces_Sortable
{
	/**
	 * Constants used in this interface
	 * @var const
	 */
	const MODE='mode';
	const ASCVIEW='up';
	const DESCVIEW='down';
	const COLUMN='by';
	const ASC='ASC';
	const DESC='DESC';

	/**
	 * This method takes care of setting the mode that the records will be sorted.
	 * Usually , you would like to conver tthis in transformOrder, which usually will conver the mode to a sort for
	 * sql
	 * @param string|null $order
	 */
	public function setMode($order=null);

	/**
	 * Retrieve the mode that the query will use
	 * @return string
	 */
	public function getMode();

	/**
	 * Set the column that will be used for sorting.
	 * This is a convenience method that will retrieve the value that you want to order
	 * @param string|null $column
	 */
	public function setBy($column=null);

	/**
	 * Set the valid columns that you will allow your client to use while using this object.
	 * It's a regular array, not a key pair one.
	 * @param array $columns
	 */
	public function setValidColumn(array $columns);

	/**
	 * Retrieve the valid columns that you are allowing the user to view while using this object
	 * @return array
	 */
	public function getValidColumns();

	/**
	 * Retrieve the column that will be used to sort records
	 * This method will return the column that you will be using the query
	 * @return string|null
	 */
	public function getBy();

	/**
	 * Convenience method that should determine if we are sorting a query.
	 * The implementation should stick to returning true or false, and should
	 * rely on the getMode and getBy implentations to discover this.
	 * @return boolean
	 */
	public function isSorting();


	/**
	 * This implementation will prepare the string that will be appended to the sql query
	 * It just builds the string and nothing else
	 * @return string
	 */
	public function prepareOrderQuery();
}