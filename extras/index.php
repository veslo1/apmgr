<?php
/**
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @author Rachael Michele Nelson <wtcfg1@gmail.com>
 * <p>The entry point for our application</p>
 * @internal Seems we are this old date Created on Sep 9, 2009 , actually is a tad older than this, circa august
 */
date_default_timezone_set("America/Chicago");
// Define path to application directory
defined('APPLICATION_PATH')|| define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../apmgr/application'));

// Define application environment
defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Define application environment
defined('APPLICATION_LOGS') || define('APPLICATION_LOGS', realpath(dirname(__FILE__) . '/../apmgr/logs') );

// Define for the translation files
defined('APPLICATION_LANGUAGE') || define('APPLICATION_LANGUAGE',APPLICATION_PATH.'/../../apmgr/lang/translations.tmx');

defined('APPLICATION_UPLOADS') || define('APPLICATION_UPLOADS',realpath(dirname(__FILE__).'/uploads'));

// Ensure library/ is on include_path
set_include_path( implode (PATH_SEPARATOR, array(realpath(APPLICATION_PATH . '/../../library'),realpath(APPLICATION_PATH . '/modules'),get_include_path() ) ) );

require_once 'Zend/Loader/Autoloader.php';

//require_once 'ZFAutoloader/Autoloader.php';

$loader = Zend_Loader_Autoloader :: getInstance();
$loader->setFallbackAutoloader(true); // if overriding loader, disable this
$loader->suppressNotFoundWarnings(false);

/** Zend_Application */
require_once 'Zend/Application.php';
// Create application, bootstrap, and run


/**
 * Appending module discovery.
 * Allow the module to have his own helpers now and using cache to avoid loading the Directory Iterator twice
 * TODO Configure this , if both projects share the same session namespace , you are in big problems.
 */
$cacheDirectory = new Zend_Session_Namespace('moduleDirectoryApmgr');
if ( !isset($cacheDirectory->initialized) )
{
	Zend_Session::regenerateId();
	$cacheDirectory->initialized = true;
	$cacheDirectory->moduleDirectory = array();
	$directoryIterator = new DirectoryIterator(APPLICATION_PATH.'/modules/');
	foreach( $directoryIterator as $module )
	{
		if ( !$module->isDot() )
		{
			$cacheDirectory->moduleDirectory[] = array('moduleDirectory'=>APPLICATION_PATH.'/modules/'.$module->getBaseName(),'baseName'=>$module->getBaseName());
			$moduleDirectory  = APPLICATION_PATH.'/modules/'.$module->getBaseName();
			$config = array('basePath'  => $moduleDirectory,'namespace' =>ucfirst($module->getBaseName()));
			$resourceLoader = new Zend_Loader_Autoloader_Resource($config);
			$resourceLoader->addResourceType('library', 'library/', 'Library');
			$resourceLoader->addResourceType('forms', 'forms/', 'Form');
			//$resourceLoader->addResourceType('layouts', 'layouts/', 'Layout');
			$resourceLoader->addResourceType('models', 'models/', 'Model');
			$resourceLoader->addResourceType('dbtable', 'models/DbTable/', 'DbTable');
			$resourceLoader->addResourceType('helper', 'helpers/', $module->getBaseName().'_Helper');
		}
	}
	$cacheDirectory->lock();//Lock it, we don't want changes
}
else
{
	foreach( $cacheDirectory->moduleDirectory as $index=>$module )
	{
		$moduleDirectory  = $module['moduleDirectory'];
		$config = array('basePath'  => $moduleDirectory,'namespace' =>ucfirst($module['baseName']));
		$resourceLoader = new Zend_Loader_Autoloader_Resource($config);
		$resourceLoader->addResourceType('library', 'library/', 'Library');
		$resourceLoader->addResourceType('forms', 'forms/', 'Form');
		//$resourceLoader->addResourceType('layouts', 'layouts/', 'Layout');
		$resourceLoader->addResourceType('models', 'models/', 'Model');
		$resourceLoader->addResourceType('dbtable', 'models/DbTable/', 'DbTable');
		$resourceLoader->addResourceType('helper', 'helpers/', $module['baseName'].'_Helper');
	}
}
$application = new Zend_Application(APPLICATION_ENV,APPLICATION_PATH . '/configs/application.ini');
$application->bootstrap();
$application->run();
?>
