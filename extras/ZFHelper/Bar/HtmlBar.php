<?php
/**
 * Created on 27/01/2010
 *
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * <p>This is the concrete bar that we see on the page</p>
 */

class ZFHelper_Bar_HtmlBar {
	/**
	 * @param string $defaultImage The default image that is being used in case the icon does not have an image set up
	 */
	protected $defaultImage;

	/**
	 * @param array $targets This contains an associative arrays, of target and query string, that allows our consumer to prepend a particular query string to the desired action,controller or module
	 */
	protected $targets;

	/**
	 * @param string $container This contains the container in which we are going to serve our bar
	 */
	protected $container;

	/**
	 * @param string $containerStyle This contains the Css that will be used for your container
	 */
	protected $containerStyle;

	/**
	 * @param string $destination The module we are going to create the bar for
	 *TODO Pick a better name
	 */
	protected $destination;

	/**
	 * @param boolean $displayHiddenIcons Dislpay or not hidden icons
	 */
	protected $displayHiddenIcons;

	/**
	 * @param string $queryString the query string that is going to be appended
	 */
	protected $queryString;

	/**
	 * @param string $containerCloseTag
	 */
	protected $containerCloseTag;

	/**
	 * List of strings that contains the elements to hide,overwritting the value on the database
	 * @var array $hiddenList
	 */
	protected $hiddenList;

	/**
	 *  Holds the titles to translate
	 *  @var array $titles
	 */
	protected $titles;

	/**
	 * Use a text bar
	 * @var boolean $textBar
	 */
	protected $textBar;

	/**
	 * List of strings that contains the elements to hide,overwritting the value on the database
	 * @var array $hiddenList
	 */
	protected $credentials;

	/**
	 * 
	 * Boolean value that toogles on/off the containerElement
	 * @var boolean
	 */
	protected $containerPerElement;
	
	/**
	 * @param string $defaultImage
	 */
	public function setDefaultImage($defaultImage) {
		$this->defaultImage = $defaultImage;
		return $this;
	}

	/**
	 * @return string The default image that was set for this product
	 */
	public function getDefaultImage() {
		return $this->defaultImage;
	}

	public function setTargets($targets) {
		$this->targets = $targets;
		return $this;
	}

	/**
	 * @param array $targets
	 */
	public function getTargets() {
		return $this->targets;
	}

	/**
	 * @param string $container
	 */
	public function setContainer($container) {
		$this->container = $container;
		return $this;
	}

	/**
	 * @return string The container that is used
	 */
	public function getContainer() {
		return $this->container;
	}
	
	/**
	 * 
	 * Retrieve the boolean setting that determines how we apply the container per element rule
	 * @return boolean
	 */
	public function getContainerPerElement()
	{
		return $this->containerPerElement;
	}
	
	/**
	 * 
	 * Applies the container and containerCloseTag per each element instead of them all
	 * @param boolean $mode
	 */
	public function setContainerPerElement($mode = false)
	{
		$this->containerPerElement= $mode;
	}
	
	/**
	 * The closing tag for your container
	 * @param string $tag
	 */
	public function setContainerClosingTag($tag) {
		$this->containerCloseTag = $tag;
	}

	/**
	 * @return string
	 */
	public function getContainerClosingTag() {
		return $this->containerCloseTag;
	}

	/**
	 * @param string $style
	 */
	public function setContainerStyle($style) {
		$this->container = preg_replace('/%s/',$style,$this->container);
		$this->containerStyle = $style;
		return $this;
	}

	/**
	 * @return string The style that is used in the bar
	 */
	public function getContainerStyle() {
		return $this->containerStyle;
	}

	/**
	 * @param string $destination
	 */
	public function setDestination($destination) {
		$this->destination = $destination;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getDestination() {
		return $this->destination;
	}

	/**
	 * @param boolean $display
	 */
	public function setDisplayHiddenIcons($display) {
		$this->displayHiddenIcons = $display;
		return $this;
	}

	/**
	 * @return boolean Return objects that we are going to display or not
	 */
	public function getDisplayHiddenIcons() {
		return $this->displayHiddenIcons;
	}

	/**
	 * @param boolean $titles
	 */
	public function setTitles($titles) {
		$this->titles = $titles;
		return $this;
	}

	/**
	 * @return boolean Return titles to translate
	 */
	public function getTitles() {
		return $this->titles;
	}


	/**
	 * @param string $queryString
	 */
	public function setQueryString($queryString) {
		$this->queryString = $queryString;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getQueryString() {
		return $this->queryString;
	}

	/**
	 * Create a custom hidden list
	 * @param array $list
	 */
	public function setHiddenList($list) {
		$this->hiddenList = $list;
		return $this;
	}

	/**
	 * Retrieve the list of elements to hide
	 * @return array
	 */
	public function getHiddenList() {
		return $this->hiddenList;
	}

	/**
	 * Set the boolean property
	 * @param boolean $useText
	 */
	public function setTextBar($useText) {
		$this->textBar = $useText;
		return $this;
	}

	/**
	 * @return boolean
	 */
	public function getTextBar() {
		return $this->textBar;
	}

	/**
	 * Set the credentials that you are currently using
	 * @param Zend_Auth $credentials
	 * @return ZFHelper_Bar_HtmlBar
	 */
	public function setCredentials(Zend_Auth $credentials) {
		$this->credentials = $credentials;
		return $this;
	}

	/**
	 * Retrieve the credentials
	 * @return Zend_Auth
	 */
	public function getCredentials() {
		return $this->credentials;
	}
}
?>