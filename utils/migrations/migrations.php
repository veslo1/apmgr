<?php
/**
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @link http://www.doctrine-project.org/documentation/manual/1_2/en/introduction-to-connections
 */
include 'Bootstrap.php';

//	Instantiate Doctrine
$manager = Doctrine_Manager::getInstance();

//	Set up connection DSN and retrieve the configuration
$zendConfigIni = new Zend_Config_Ini(APPLICATION_PATH.'/configs/application.ini',APPLICATION_ENV);

$username = $zendConfigIni->appsettings->db->username;
$password = $zendConfigIni->appsettings->db->password;
$db 	  = $zendConfigIni->appsettings->db->dbname;
$host 	  = $zendConfigIni->appsettings->db->host;
$dbType   = $zendConfigIni->appsettings->db->kind;
$dsn 	  = "$dbType:dbname=$db;host=$host";
$dbh 	  = new PDO($dsn, $username, $password);
$conn 	  = Doctrine_Manager::connection($dbh);
//	This sets up the options that this application can handle.
$getopt = new Zend_Console_Getopt(array('migrate|m=i'=>'Migrate up or down to version specified by %d.','list|l'=>'List the available migrations'));
try {
	$getopt->parse();
	// Set up migrations
	$migration 		= new Doctrine_Migration(MIGRATION_PATH, $conn);

	//	Parse command line arguments,retrieve the version that you want to go up or down to
	$option = array_shift( $getopt->getOptions('m') );

	//	We want to migrate
	if( $option == 'migrate' ) {
		$flag	  		= explode("=",$getopt->toString() );
		$version 		= (int) $flag[1];
		if( !is_numeric($version) or $version<0 ) {
			throw new Exception('Version is not supported.Correct the version that you want to go to');
		}
	}

	//	We want to list the current version
	$option = array_shift( $getopt->getOptions('l') );
	if( $option == 'list' ) {
		echo $migration->getCurrentVersion().PHP_EOL;
	}
} catch ( Exception $e ) {
	echo $e->getUsageMessage();
	return false;
}
