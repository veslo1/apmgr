<?php
//	This path points to the upper application
defined ('APPLICATION_PATH')|| define('APPLICATION_PATH', realpath( dirname(__FILE__).'/../application' ) );
//	And this define , is for our application path.
defined ('APPLICATION_ENV') || define('APPLICATION_ENV','development');

//	Set the include path of our application
set_include_path( implode ( PATH_SEPARATOR , array(APPLICATION_PATH . '/../library',get_include_path() ) ) );
require_once 'Zend/Loader/Autoloader.php';
Zend_Loader_Autoloader::getInstance();

try {
	#	Bootstrap
	$application = new Zend_Application(APPLICATION_ENV,APPLICATION_PATH.DIRECTORY_SEPARATOR.'configs'.DIRECTORY_SEPARATOR.'application.ini');
	$bootstrap = $application->getBootstrap();
	$bootstrap->bootstrap('db');
	$db = $bootstrap->getResource('db');
	$result = $db->fetchAll("SELECT id FROM permission");
	# 	Add a fancy progress bar
	$adapter = new Zend_ProgressBar_Adapter_Console(array(Zend_ProgressBar_Adapter_Console::ELEMENT_BAR=>'=',Zend_ProgressBar_Adapter_Console::ELEMENT_PERCENT=>null,Zend_ProgressBar_Adapter_Console::ELEMENT_ETA=>null,Zend_ProgressBar_Adapter_Console::ELEMENT_TEXT=>"Updating the permissions for Admin"));
	$progressBar = new Zend_ProgressBar($adapter);
	$i = 0;
	#	And verify the records
	foreach($result as $id=>$row)
	{
		$match = $db->fetchAll("SELECT * FROM rolePermission WHERE roleId=1 AND permissionId={$row['id']}");
		if( 0==count($match) )
		{
			$query = "INSERT INTO rolePermission(roleId,permissionId,dateCreated) VALUES(1,{$row['id']},NOW())";
			$db->query($query);
		}
		$progressBar->update($i);
		$i++;
	}
	$progressBar->finish();
} catch (Zend_Db_Statement_Exception $e) {
	print $e->getMessage().PHP_EOL;
}
//mysql_free_result($result);
print "Database records for admin are set".PHP_EOL;
return 0;
?>