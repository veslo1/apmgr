<?php
/**
 * Helper object to retrieve the report information
 */

class ZFReport_Library_DbHelper {

	protected $db;

	/**
	 * The default table we have for report information
	 * @var array
	 */
	private static $mapper = array('reports');

	/**
	 * Constructor
	 */
	public function __construct(){
		$this->db = Zend_Registry::get('db');
	}

	/**
	 * Retrieve the report information for the given module
	 * @param string $module
	 * @return array
	 */
	public function getReport($module){
		$data = array();
		$query = "SELECT R.id,R.name,R.urlPath FROM ".self::$mapper[0]." R INNER JOIN modules M ON (R.moduleId=M.id) WHERE M.name='$module' ORDER BY R.name";
		$result = $this->db->query($query);
		if(count($result)>0){
			foreach($result as $id=>$row){
				$data[] = $row;
			}
		}
		return $data;
	}

	/**
	 * Retrieve the given report data information
	 * @param string $reportName
	 * @return multitype:
	 */
	public function getReportData($reportName)
	{
		$data = array();
		$query = "SELECT R.* FROM ".self::$mapper[0]." R WHERE name='$reportName'";
		$result = $this->db->query($query);
		if( count($result)>0 )
		{
			foreach($result as $id=>$row)
			{
				$data = $row;
			}
		}
		return $data;
	}
	
	/**
	 * Retrieve all the information
	 * @return Ambigous <int,string>
	 */
	public function fetchAll()
	{
		$data = array();
		$query = "SELECT * FROM ".self::$mapper[0];
		$result = $this->db->query($query);
		if( count($result) > 0 )
		{
			foreach($result as $id=>$row)
			{
				$data[]=$row;
			}
		}
		return $data;
	}
}