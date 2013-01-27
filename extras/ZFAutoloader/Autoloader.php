<?php
require_once 'Zend/Loader/Autoloader.php';

class ZFAutoloader_Autoloader extends Zend_Loader_Autoloader {

	public function __construct() {
		parent::__construct();
	}

	public static function autoload($path) {
		include str_replace('_','/',$path) . '.php';
		return $path;
	}

}

?>
