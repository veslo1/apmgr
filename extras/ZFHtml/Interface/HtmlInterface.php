<?php
/**
 * Interface that determines the methods that must be implemented
 * @author jvazquez <jvazquez@debserverp4.com.ar>
 */
interface ZFHtml_Interface_HtmlInterface {

	/**
	 * Interface that all the html widgets must implement.
	 * Define the html structure that you want to create.
	 */
	public function yield();

	/**
	 * Defines the method that all html widgets that retrieve
	 * events must implement.
	 * @param array $date
	 */
	public function fetchEvents($date);

	/**
	 * Retrieve an array and iterate the contents of the array
	 * to produce the proper html string
	 * @param array $source
	 */
	public function forgeHtml($source);

	/**
	 * Generate a dom element based on the contents of the array
	 * @param recordset $dom
	 */
	public function glueElements($recordset);
}
?>