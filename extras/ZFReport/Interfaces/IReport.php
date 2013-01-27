<?php
/**
 * Interface for the report object
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 */
interface ZFReport_Interfaces_IReport {

	/**
	 * Constant used by the Base class to determine that our dataprovider is a database
	 * @var const
	 */
	const DB='db';

	/**
	 * Constant used by the Base class to determine that our dataprovider is a file
	 * @var const
	 */
	const FILE='file';

	/**
	 * Constant used by the Base class to determine that our dataprovider is on a url
	 * @var const
	 */
	const URL='url';

	/**
	 * The default timeout for a cache
	 * @var const
	 */
	const LIFETIME=60;

	/**
	 * Constant that is used in URLS to denote pagination
	 * @var const
	 */
	const PAGINATING='page';

	/**
	 * Default constants applied to queries that depend on date filtering
	 * @var string
	 */
	const DEFAULTLIMIT ='BETWEEN DATE(NOW()) - INTERVAL 30 DAY AND DATE(NOW())';
	
	/**
	 * Set the cache for the frontend
	 * @param string $type
	 */
	public function setCacheFrontEnd($type);

	/**
	 * Set the cache for the backend
	 * @param string $type
	 */
	public function setCacheBackEnd($type);

	/**
	 * Configure the cache options for the frontend
	 * @return array
	 */
	public function configureCacheFrontEnd();

	/**
	 * Configure the cache options for the backend
	 * @return array
	 */
	public function configureCacheBackEnd();

	/**
	 * Execute the report.
	 * The boolean option useCache orders the application to store the obtained results in cache
	 * @param boolean $cache
	 * @return array
	 */
	public function runReport($useCache=false);

	/**
	 * Preform the caching.
	 * Implementation will change depending on the engine that you use
	 * @param array $information
	 * @throw Exception
	 */
	public function cacheData(array $information=null);

	/**
	 * We can retrieve the seed of the cache to perform additional transformations when needed
	 * @return string
	 */
	public function getSeed();

	/**
	 * Set the seed of the element that will be stored in the Zend_Cache_Manager
	 * @param string $seed
	 */
	public function setSeed($seed);

	/**
	 * Set the page the user is viewing when he is paginating
	 * @param int $page
	 */
	public function setPage($page);

	/**
	 * Retrieve the page that user sets when he is paginating.
	 * @return int
	 */
	public function getPage();

	/**
	 * With this method you generate the corresponding seed that goes into the seed.
	 * The seed is the record identifier for your query results.
	 * We may generate different types of records, mainly due to the fact that we have
	 * pagination and sorting. Sorting is delegated to the ZFDb_SortHelper object
	 */
	public function prepareCacheSeed();
	

	/**
	 * Definition of the method exportReport.
	 * In order to allow extra flexibility , I define this method as an interface.
	 * The implementation depends on how you want to implement it from now on, in order to 
	 * avoid establishing harsh rules.
	 * @return boolean
	 */
	public function exportReport();
	
	/**
	 * Internal implementation of the report configuration.
	 * This should be called outside the code or inside the constructor.
	 * I'd rather go with the external implementation to keep the code clean
	 */
	public function init();
}