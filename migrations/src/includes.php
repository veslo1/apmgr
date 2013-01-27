<?php
/**
 * Include files for all the scripts in this application
 * @author Jorge Vazquez <jvazquez@debserverp4.com.ar>
 * @package utils.src
 *
 */

//	This path points to the upper application
defined ('APPLICATION_PATH')|| define('APPLICATION_PATH', realpath( dirname(__FILE__).'/../../application' ) );
//	This path , points to our internal structure
defined ('WULFMIGRATIONS_PATH')|| define('WULFMIGRATIONS_PATH', realpath( dirname(__FILE__).'/../' ) );
//	And this define , is for our application path.
defined ('APPLICATION_ENV') || define('APPLICATION_ENV','migrations');

//	Set the include path of our application
set_include_path( implode ( PATH_SEPARATOR , array(APPLICATION_PATH . '/../../library',get_include_path() ) ) );
$os = exec("uname -ra");
if( stristr($os,"darwin") ) {
	define('MYSQLBINARY','mysql5');
        define('MYSQLDUMP','mysqldump5');
} else {
	define('MYSQLBINARY','mysql');
        define('MYSQLDUMP' ,'mysqldump');
}
?>
