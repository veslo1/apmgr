<?php
error_reporting(E_ALL | E_COMPILE_WARNING);

// Define path to application directory
defined('APPLICATION_PATH')|| define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../../application'));

// Define path to application test directory
defined('APPLICATION_TEST')|| define('APPLICATION_TEST', realpath(dirname(__FILE__) . '/../../'));

// Define application environment
defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'testing'));

// Define application environment
defined('APPLICATION_LOGS') || define('APPLICATION_LOGS', realpath(dirname(__FILE__) . '/../../logs') );

defined('APPLICATION_FAKESETS') || define('APPLICATION_FAKESETS', realpath(dirname(__FILE__) . '/datasets/') );

defined('APPLICATION_UPLOADS') || define('APPLICATION_UPLOADS',realpath(dirname(APPLICATION_PATH.'/../../')));

//Used for dummy emails
defined('APPLICATION_FAKEMAILS') || define('APPLICATION_FAKEMAILS', realpath( dirname(__FILE__ ).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'fakemails' ) );

// Ensure library/ is on include_path
set_include_path( implode (PATH_SEPARATOR, array(realpath(APPLICATION_PATH . '/../../library'),realpath(APPLICATION_PATH . '/modules'),get_include_path() ) ) );

date_default_timezone_set("America/Chicago");
setlocale(LC_ALL,'en_US');

require_once 'Zend/Loader/Autoloader.php';
$loader = Zend_Loader_Autoloader :: getInstance();
$loader->setFallbackAutoloader(true);
$loader->suppressNotFoundWarnings(false);
require_once 'Zend/Application.php';
//	Adding the email stub element
require_once realpath(dirname(__FILE__).'/../library/Email/File.php');
$directoryIterator = new DirectoryIterator(APPLICATION_PATH.'/modules/');

//		Appending module discovery.Now, you don't need to hardcode the entry into the array, this fixes that. A nice addition, will be to create a class with directoryiterator plus a filter iterator.But, this makes the work.
foreach( $directoryIterator as $module )
{
	if ( preg_match('/^[^\.]/',$module->getBaseName() ) )
	{
		$moduleDirectory  = APPLICATION_PATH.'/modules/'.$module->getBaseName();
		$config = array('basePath'  => $moduleDirectory,'namespace' =>ucfirst($module->getBaseName()));
		$resourceLoader = new Zend_Loader_Autoloader_Resource($config);
		$resourceLoader->addResourceType('library', 'library/', 'Library');
		$resourceLoader->addResourceType('forms', 'forms/', 'Form');
		$resourceLoader->addResourceType('models', 'models/', 'Model');
		$resourceLoader->addResourceType('dbtable', 'models/DbTable/', 'DbTable');
		$resourceLoader->addResourceType('controllers', 'controllers', 'Controller');
	}
}
require_once 'ControllerTestCase.php';
require_once 'DatabaseFlatXmlSeed.php';
require_once 'DatasetArrayFilterIterator.php';
require_once 'ZFModel/ParentModel.php';
$locale = new Zend_Locale('en_US');
Zend_Registry::set('Zend_Locale', $locale);
?>