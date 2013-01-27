<?php
/**
 * Created on 27/01/2010
 *
 * @author Jorge
 * <p>Abstract builder for the different kinds of bars</p>
 */

abstract class ZFHelper_Bar_HtmlClassBuilder {
	/**
	 * @param object $htmlBar An htmlbar concrete object
	 */
	protected $htmlBar;

	public function getBar() {
		return $this->htmlBar;
	}

	/**
	 * Create the concrete product
	 */
	public function createHtmlBar() {
		$this->htmlBar = new ZFHelper_Bar_HtmlBar();
	}

	/**
	 * Determine the default image that is going to be used
	 */
	abstract function buildDefaultImage($image);

	/**
	 * Determine the targets that our bar will deal with
	 */
	abstract function buildTargets($targets);

	/**
	 * Determine the type of html container that we will use for our bar
	 */
	abstract function buildContainer($container);

	/**
	 * The closing tag for the container
	 */
	abstract function buildContainerCloseTag($container);

	/**
	 * Determine the style of the html container that we will use
	 */
	abstract function buildContainerStyle($style);

	/**
	 * Generate the html bar string representation
	 * @return string The bar that you are seeing
	 */
	abstract function yield();

	/**
	 * Determine the object that you are setting up.
	 * If the client is on the module user and he wants a controller bar for user
	 * this parameter sets this attribute in the destination object
	 */
	abstract function buildBarContext($destination);

	/**
	 * Set the attribute query string in the parent object
	 */
	abstract function buildQueryString($queryString);

	/**
	 * Set if we should display hidden icons
	 */
	abstract function buildHiddenIcons($displayHiddenIcons);

	/**
	 * Provide a way to hide certain elements disregarding the value on hidden
	 * @param array $hiddenElements
	 */
	abstract function buildIgnoreList($hiddenElements);

	/**
	 * Holds the titles array
	 * @param array $titles
	 */
	abstract function buildTitles($titles);

	/**
	 * Build a text bar rather
	 * @param boolean $displayText
	 */
	abstract function buildTextBar($displayText);

	/**
	 * Retrieve the credentials for the given user
	 * @return Zend_Auth
	 */
	abstract function getCredentials();

	/**
	 * Inject the current user credentials
	 * @param Zend_Auth $auth
	 */
	abstract function setCredentials(Zend_Auth $auth);
	
	/**
	 * 
	 * Determines how the containerPerElement is applied
	 * The default mode is false
	 * @param boolean $mode
	 */
	abstract function buildContainerPerElement($mode=false);
}
?>