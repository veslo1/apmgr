<?php
/**
 * Created on 27/01/2010
 *
 * @author Jorge
 * <p>
 * Implementation of the creation of different kinds of bars
 * This class realizes the call to the director, that will determine what we have to build
 * </p>
 */

class Wulf_View_Helper_Bar extends Zend_View_Helper_Abstract {

	/**
	 * @return string The html bar that the client requested
	 */
	public function bar($config) {
		$bar = new ZFHelper_Bar_BarBuilder();
		//	Determine which kind of bar you want to create, a controller, a module or an action bar
		switch($config['type']) {
			case'controller':
				$bar->setBar(new ZFHelper_Bar_ControllerBar());
				break;
			case'module':
				$bar->setBar(new ZFHelper_Bar_ModuleBar());
				break;
			case'action':
				$bar->setBar(new ZFHelper_Bar_ActionBar());
				break;
		}
		echo $bar->constructBar($config);
	}
}
?>
