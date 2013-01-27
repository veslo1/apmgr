<?php

/**
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * <p>Controller icons
 * Provides a set of icons for the user.
 * </p>
 */
class Wulf_View_Helper_Controllers extends Zend_View_Helper_Abstract {
	/**
	 * The default image
	 * @var string
	 */
	static $IMAGE = '/images/24/golden_offer.gif';

	/**
	 * @param array assembleOptions Options that are sent to this controller to prepend a query string
	 */
	private $assembleOptions;

	/**
	 * The dashboard that the user see's
	 * @return string
	 */
	public function controllers( $assembleOptions ) {
		$actions = '';
		if ( isset($assembleOptions['controllerName']) ) {
			$assembleOptions['target'] = isset($assembleOptions['target'])?$assembleOptions['target']:null;

			//	Wipe the first / if the client sends it
			if( isset($assembleOptions['queryString']) )
			$assembleOptions['queryString'] = preg_replace('/^\//','',$assembleOptions['queryString']);
			else
			$assembleOptions['queryString'] = null;
				
			$this->assembleOptions = $assembleOptions;
			$actions = $this->assemble();
		}
		return $actions;
	}

	/**
	 * Build the controller bar that the user will see
	 * @return string The assembled controller bar
	 */
	public function assemble() {
		$main = new Modules_Model_ModuleControllers();
		$baseurl = Zend_Controller_Front :: getInstance()->getBaseUrl() ? Zend_Controller_Front :: getInstance()->getBaseUrl() : "/";

		//TODO This must be a configurable setting
		$actions = "<div class='controllers'>";
		$url ='#';

		foreach ($main->fetchModuleController($this->assembleOptions['controllerName']) as $id => $object) {
			if ($object['controller']->getIcon() == null)
			$object['controller']->setIcon(self :: $IMAGE);

			$url = $baseurl.$object['module']->getName() .'/'. $object['controller']->getName();
			if( strcmp($this->assembleOptions['target'],$object['controller']->getName())==0 )
			$url .= '/'.$this->assembleOptions['queryString'];

			$actions .= "<a href='$url'><img src='" . $object['controller']->getIcon() . "' title='" . ucfirst($object['controller']->getName()) . "' alt='" . ucfirst($object['controller']->getName()) . "'/></a>";
		}
		$actions .= "</div>";

		return $actions;
	}
}