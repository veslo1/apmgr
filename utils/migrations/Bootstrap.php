<?php
error_reporting(E_ALL | E_COMPILE_WARNING);

// Define path to application directory
defined('APPLICATION_PATH')|| define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../../application'));

// Define application environment
defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'migrations'));

// Define application environment
defined('APPLICATION_LOGS') || define('APPLICATION_LOGS', realpath(dirname(__FILE__) . '/../../logs') );

//	Our migration path
defined('MIGRATION_PATH') || define('MIGRATION_PATH', realpath(dirname(__FILE__) . '/../migrationClasses') );

// Ensure library/ is on include_path
set_include_path( implode (PATH_SEPARATOR, array(realpath(APPLICATION_PATH . '/../library'),realpath(APPLICATION_PATH . '/modules'),get_include_path() ) ) );
//TODO Change this to your tz
date_default_timezone_set("America/Buenos_Aires");
setlocale(LC_ALL,'es_AR');

//	Init Doctrine
require_once 'Doctrine/lib/Doctrine.php';
spl_autoload_register(array('Doctrine', 'autoload'));

require_once 'Zend/Loader/Autoloader.php';
$loader = Zend_Loader_Autoloader :: getInstance();
$loader->setFallbackAutoloader(true);
$loader->suppressNotFoundWarnings(false);
require_once 'Zend/Application.php';
//require_once 'ZFObserver/ILogeable.php';
$directoryIterator = new DirectoryIterator(APPLICATION_PATH.'/modules/');

//		Appending module discovery.Now, you don't need to hardcode the entry into the array, this fixes that. A nice addition, will be to create a class with directoryiterator plus a filter iterator.But, this makes the work.
foreach( $directoryIterator as $module ) {
	if ( preg_match('/^[^\.]/',$module->getBaseName() ) ) {
		$moduleDirectory  = APPLICATION_PATH.'/modules/'.$module->getBaseName();
		$config = array('basePath'  => $moduleDirectory,'namespace' =>ucfirst($module->getBaseName()));
		$resourceLoader = new Zend_Loader_Autoloader_Resource($config);
		$resourceLoader->addResourceType('forms', 'forms/', 'Form');
		$resourceLoader->addResourceType('models', 'models/', 'Model');
		$resourceLoader->addResourceType('dbtable', 'models/DbTable/', 'DbTable');
	}
}