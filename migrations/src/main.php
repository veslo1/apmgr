#!/usr/bin/env php
<?php
/**
 * @package migrations
 * @subpackage src
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * <p> Custom migration system</p>
 */
include 'includes.php';
require_once 'Zend/Loader/Autoloader.php';
Zend_Loader_Autoloader::getInstance();
include realpath(dirname(__FILE__).'/lib/Task.php');
include realpath(dirname(__FILE__).'/lib/Helper.php');
include realpath(dirname(__FILE__).'/lib/Down.php');
include realpath(dirname(__FILE__).'/lib/Cleanup.php');
include realpath(dirname(__FILE__).'/lib/Lists.php');
include realpath(dirname(__FILE__).'/lib/Append.php');
include realpath(dirname(__FILE__).'/lib/Acl.php');

try {
    $application = new Zend_Application(APPLICATION_ENV,WULFMIGRATIONS_PATH . '/configs/application.ini');
    $bootstrap = $application->getBootstrap();
    $bootstrap->bootstrap('db');
    $dbAdapter = $bootstrap->getResource('db');

    if ( count($argv)==1 ) {
        throw new Exception("You need to have some argument to feed me");
    }
    $option = $argv[1];
    switch($option) {
    	
        case 'list': case '-l':
            print "List Migrations and current system state".PHP_EOL;
            $libList = new Lists($dbAdapter);
            $result = $libList->showVersion();
            $libList->printMessage($result);
            break;
        
        case 'append': case'-a':
        //	Append a new migration into the system.
            $append = new Append($dbAdapter);
            $files = array($argv[2],$argv[3]);
            $append->setFileName($files);
            $append->appendFile();
            print "Now your system is ready to go up or down".PHP_EOL;
            break;
        
        case 'up': case '-u':
        //  Upgrade your database
            $up = new Down($dbAdapter);
            $up->setVersion($argv[2]);
            $up->migrateUp();
            print "Your system is updated :D".PHP_EOL;
            break;
        
        case 'down': case '-d':
        //  No,not the Phil Anselmo band :P
            $down = new Down($dbAdapter);
            $down->setVersion($argv[2]);
            $down->migrateDown();
            print "Your system has been downgraded :O".PHP_EOL;
            break;

        case 'cleanup': case '-c':
            $sweep = new Cleanup($dbAdapter);
            $max = $sweep->sweep();
            print "System says that max is $max".PHP_EOL;
            $up = new Down($dbAdapter);
            $up->setVersion($max);
            $up->migrateUp();
            break;
        case 'aclup': case '-f':
        	//	F is for fuck mysql
        	$acl = new Acl($dbAdapter);
        	$acl->setConfig(new Zend_Config_Ini(WULFMIGRATIONS_PATH . '/configs/application.ini',APPLICATION_ENV));
        	$acl->setMode(Task::UP);
        	$acl->task();
        	break;
        case 'acldown': case '-z':
        	//	F is for fuck mysql
        	$acl = new Acl($dbAdapter);
        	$acl->setConfig(new Zend_Config_Ini(WULFMIGRATIONS_PATH . '/configs/application.ini',APPLICATION_ENV));
        	$acl->setMode(Task::DOWN);
        	$acl->task();
        	break;
        case 'help': case '-h':
 $str = <<<EOD
Welcome to the help section of migrations.
    USAGE:
        migrations.php OPTS FLAGS

        OPTS
        append -a string string Append migration files into the system.
                                  This is the first option that you should
                                  use when you are adding files into the
                                  system. The two string arguments are required
                                  and you must provide them in the following
                                  order.
                                  migrationThatGoesUp migrationThatGoesDown
                                  The order is required , and the second option
                                  `migrationThatGoesDown` must have the word
                                  down or Down or DOWN somewhere on the name.
                                  You don't need to add the .sql extension, the
                                  program takes care of that.
                                  Both files must reside on the storage folder
        up int   -u            Migrate the system to the desired version.
                                  The int argument is required, and is the vers
                                  ion you are going to.
        down int -d            Downgrade the migration system.
        clean   -c             Fetch the latest version and migrate to that or just show which is the latest version
        help    -h           This message
        list    -l             List the state of your migration system.
        aclup	-f 	  	     Generates a template that will dump the ACL tables changes that you did
        acldown	-z			 Generates a template that will dump the ACL tables before you alter them
EOD;
            echo $str.PHP_EOL;
            break;
        default:
            print "You need to give me arguments to run.".PHP_EOL;
            break;
    }
} catch ( Exception $e ) {
    echo $e->getMessage().PHP_EOL;
} catch (Zend_Db_Exception $e) {
    echo $e->getMessage().PHP_EOL;
}
?>
