<?php
/**
 * Generic contract that all implementations of a work flow should implement
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @package applicant
 * @subpackage library.interface
 *
 */
interface Applicant_Library_Interface_WorkFlow {

  /**
   * Return a string that determines the name of the current workflow
   * @return string
   */
  public function getSessionNameSpace();

  /**
   * Set the identifier for this object
   * @param string $name
   */
  public function setSessionNameSpace($name);

  /**
   * Init the persistent object that you are using
   * @return boolean
   */
  public function initSession();

  /**
   * Return an associative array that tell us the steps that the user shuold follow when he is in the apply process
   * We don't want to push this into a database, since the steps are defined and static
   * An array is the fastest way to store this information.
   * Why I don't use a file ?, you will be opening a file on each request, an array against a file is faster
   * and by file,  I mean any kind, Xml, Ini, config or whatever you want to use
   * @return array
   */
  public function getSteps();

  /**
   * Clear out the persistent object
   */
  public function terminateSession();
}
?>
