<?php
/**
 * Created on Sep 14, 2009 by jvazquez
 * @package application.modules.default.controllers
 * <p>
 * The main page that users will see when they view our application
 * </p>
 */

class IndexController extends Zend_Controller_Action {

	public function indexAction() {
	}

	public function searchAction() {
		//  Don't render the view, this is an ajax call.
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		$searchTerm = $this->getRequest()->getParam('searchbox');
		$config = new Zend_Config_Ini( APPLICATION_AJAX_SEARCH,'production');
		$url = $config->url;
		//	This is what the server has to return, an ul http://wiki.github.com/madrobby/scriptaculous/ajax-autocompleter
		$domResults = new DOMDocument();
		$root = $domResults->createElement('ul');
		$domResults->appendChild($root);

		if($config->xml) {
			$file =APPLICATION_PATH.'/../defs/tree/map.xml';
			$dom = new DOMDocument('1.0');
			$dom->load($file);
			$childNodes = $dom->getElementsByTagName('item');

			foreach($childNodes as $node) {
				$nodeaction = $node->getAttribute('module');
				if(preg_match("/$searchTerm/",$nodeaction)) {
					$li = $domResults->createElement('li');
					$address = $domResults->createElement('a');
					$address->setAttribute('href',$url.$node->getAttribute('module')."/".$node->getAttribute('controller')."/".$node->getAttribute('action'));
					$textNode = $domResults->createTextNode(ucfirst($node->getAttribute('module'))." ".ucfirst($node->getAttribute('controller'))." ".ucfirst($node->getAttribute('action')));
					$address->appendChild($textNode);
					$li->appendChild($address);
					$root->appendChild($li);
				}
			}
			echo $domResults->saveHtml();

		} else if($config->html) {

		} else if( $config->csv ) {

		}
	}
}
?>