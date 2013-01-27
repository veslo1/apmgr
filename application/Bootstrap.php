<?php
/**
 * Created on Sep 5, 2009 by jvazquez
 * This class is loaded and provides the resources that we will be using.
 * Why we can't use the functionality of request, plugins , zend view and other things and depend on the registry
 * Because the core.php isn't calling the run method, that allows you to have that. If we <strong>run()</strong>, we will
 * go to the zend framework environment fully, and controllers will have to be created for that.
 * For more information, please read
 * @link http://framework.zend.com/manual/en/zend.application.theory-of-operation.html Read this page, there is the correct explanation of why things are working this way.
 * I don't think that switching will be much of a problem, the model section of zend is basically covered here.
 */

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initAppProperties()
	{
		$options = array ('nestSeparator' => ".");
		Zend_Registry::set('properties',new Zend_Config_Ini(APPLICATION_PATH . "/configs/application.ini", APPLICATION_ENV, $options));
	}
	
	/**
	 * Initializes the database connection.
	 * From any point of the application, now you can do
	 * @example connection $db = Zend_Registry::get('db'); and it will allow you to do queries against the database
	 */
	protected function _initDb() {
		$options = array ('nestSeparator' => ".");
		$config = new Zend_Config_Ini(APPLICATION_PATH . "/configs/application.ini", APPLICATION_ENV, $options);

		//db config and connect
		$params = array (
                'host' => $config->resources->db->params->host,
                'username' => $config->resources->db->params->username,
                'password' => $config->resources->db->params->password,
                'dbname' => $config->resources->db->params->dbname,
				'profiler' => $config->resources->db->params->profiler
		);

		$db = Zend_Db :: factory($config->resources->db->adapter, $params);
		$db->query("SET NAMES 'utf8'");
		Zend_Db_Table :: setDefaultAdapter($db);
		Zend_Registry::set('db', $db);//Register
		return $db;
	}

	/**
	 * Initializes the view doctype and the filter for i18n
	 */
	protected function _initDoctype() {
		$this->bootstrap('view');
		$view = $this->getResource('view');
		$view->doctype('XHTML1_STRICT');

		$options = array ('nestSeparator' => ".");
		$config = new Zend_Config_Ini(APPLICATION_PATH . "/configs/application.ini", APPLICATION_ENV, $options);
		$view->appTitle = $config->appsettings->appname;
		//	Let Zend know about all of our helpers
		$view->addHelperPath(APPLICATION_PATH . '/helpers', 'Wulf_View_Helper');

		//	And let Zend know about jquery	This doesn't works that well, it's faster to add the javascript by hand man...you end up including a lot of new php files, adding new elements, but you still need to add the javascript code on the page
		//		$view->addHelperPath("ZendX/JQuery/View/Helper", "ZendX_JQuery_View_Helper");

		/**
		 * @internal Add the filter for i18n
		 * @link http://devzone.zend.com/article/4513-Zend-Framework-and-Translation
		 */
		$view->addFilterPath('ZFTranslate/View/Filter', 'ZFTranslate_View_Filter');
		$view->setFilter('Translate');

		/**
		 * Append our experiment to filter resources
		 * if the user is logged in, we will show the html , else we won't
		 */
		$view->addFilterPath('ZFViewfilter/View/Filter', 'ZFViewfilter_View_Filter');
		$view->addFilter('Show');
		//	We display content or an error message , the file is on the same path
		$view->addFilter('Contentcheck');

		$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
		$viewRenderer->setView($view);
		Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);#TEst
		return $view;
	}

	/**
	 * Sets up the autoloader for zend.
	 * @return Zend_Application_Module_Autoloader
	 */
	/*
	 protected function _initAutoload() {
	 $moduleLoader = new Zend_Application_Module_Autoloader(array ('namespace' => '','basePath' => APPLICATION_PATH));
	 return $moduleLoader;
	 }
	 */

	/**
	 * @internal This allows us to load the models, since the way zend tries to determine paths is quite difficult to understand
	 */
	protected function _initModelPlugin() {
		$this->bootstrap('frontcontroller');
		$frontController = $this->getResource('frontcontroller');
		$frontController->registerPlugin(new ZFModel_Plugin_Error());
	}

	/**
	 * Set up Zend so it's aware of the files that it needs to handle.
	 */
	protected function _initModularApplication() {
		$this->bootstrap('frontcontroller');

		// add 9-20-10
		//$this->bootstrap('autoloaders');
		//$plugin = new ZFPlugin_LayoutPlugin();
		//$this->frontController->registerPlugin($plugin);

		$front = $this->getResource('frontcontroller');
		$front->addModuleDirectory(APPLICATION_PATH.'/modules/');
		$front->setModuleControllerDirectoryName('controllers');
		$directoryIterator = new DirectoryIterator(APPLICATION_PATH.'/modules/');
		$modules = array();
		foreach( $directoryIterator as $module ) {
			if( !$module->isDot() ) {
				$modules[$module->getBaseName()] = APPLICATION_PATH.'/modules/'.$module->getBaseName().'/controllers';
			}
		}
		$front->setControllerDirectory($modules);
		$front->setDefaultControllerName('index');
	}

	//  http://cmorrell.com/webdev/zf/zend-framework-using-separate-layouts-per-module-329
	protected function _initLayout() {
		Zend_Layout::startMvc();
	}

	protected function _initCacheTableAbstract() {
		$frontEndOptions = array('automatic_serialization' => true,'lifetime' => 3600);
		$backEndOptions = array('lifetime' => 3600,'cache_dir'=> APPLICATION_PATH.'/../cache');
		$cache = Zend_Cache::factory('Core','File',$frontEndOptions,$backEndOptions,false);
		Zend_Db_Table_Abstract::setDefaultMetadataCache( $cache );
		Zend_Registry::set('cache',$cache); // http://www.sadtrombone.com   :(
	}

	/**
	 * Integration of the Acl plugins.
	 * This plugins will validate that the user is logged in and has access to the request that he is seeing.
	 */
	protected function _initAcl() {
		$auth = Zend_Auth::getInstance();
		$this->bootstrap('frontcontroller');
		$frontController = $this->getResource('frontcontroller');
		$acl = new ZFAcl_Plugin_Acl($auth);
		$frontController->registerPlugin($acl);
		Zend_Registry::set('ACL',$acl);
		return $acl;
	}

	/**
	 * Set up the Locale for our application based on what the user has in his browser.
	 * @internal The zend_translate must be set on the registry first , because , when navigation
	 * tries to recover it , it will find out that he wasn't set , and I do not like the idea of
	 * calling the locale from the navigation. So I just rather call him first.
	 * @todo i18n <strong>is broken</strong>
	 */
	protected function _initLocale() {
		$cache = Zend_Registry::get('cache');
		$tag = 'locale';
		$container = null;
		try
		{
			$locale = new Zend_Locale(Zend_Locale::BROWSER);
			$lang = $locale->getLanguage();
			$region = $locale->getRegion();
			//	If he has another variation then fallback to en_US or es_AR that are the languages that we support
			if( $lang=='en' and $region!='US')
			{
				$locale->setLocale('en_US');
			}
			else if($lang=='es' and $region!='AR')
			{
				$locale->setLocale('es_AR');
			}
		}
		catch(Exception $e )
		{
			// I set this to environment for testing
			$locale = new Zend_Locale('en_US');
		}
		Zend_Registry::set('Zend_Locale', $locale);
		Zend_Translate::setCache($cache);
		$translate = new Zend_Translate('tmx',APPLICATION_PATH.'/../lang/translations.tmx',$locale->__toString());
		Zend_Registry::set('Zend_Translate', $translate);
	}

	/**
	 * Register the plugin that checks the Docklet session and cleans it in case of a match
	 * @return unknown_type
	 */
	protected function _initDockletCheck() {
		$this->bootstrap('frontcontroller');
		$frontController = $this->getResource('frontcontroller');
		$frontController->registerPlugin( new ZFController_Plugin_Controller() );
	}
}
?>
