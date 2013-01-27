<?php
/**
 * Migrate your system down
 *
 * @author jvazquez <jvazquez@debserverp4.com.ar>
 */

class Down extends Helper {

  /**
   * The version you are going to
   * @var int $version
   */
  protected $version;

  /**
   * This is our start point for migrations
   * @var int $myCurVersion
   */
  protected $myCurVersion;

  public function __construct($db) {
    $this->setDbAdapter($db);
  }

  /**
   * Move the system back in time
   */
  public function migrateDown() {
    $this->validateVersion();
    $db = $this->getDbAdapter();
    $result = $db->fetchAll("SELECT version FROM migration_version WHERE current=1");
    //	This is the first time that the system is working. So just skip all the checks and go to the storage area and retrieve the dump file and just go up to version 1.
    if( count($result) == 0 ) {
      throw new Exception("The system can't go down, there isn't a defined current version yet.");
    }

    $oldversion = array_shift($result);
    $this->myCurVersion = $oldversion['version'];

    if( $this->version > $this->myCurVersion ) {
      throw new Exception("You have something wrong.The version you are going down is higher than the current version.Your system has been compromised");
    }

    if( $this->myCurVersion==1 ) {
      print "WAKE UP, you are at version 1, this means that you will run
        the down file of version 1, and you won't have a database , so
        *don't complain* if your app stops working".PHP_EOL;
    }
    /**
     * Till this point , basically what we do is to get the <strong>
     * current</strong>version and apply the down file of the current
     * migration file.
     */
    $props = new Zend_Config_Ini(WULFMIGRATIONS_PATH. "/configs/application.ini", APPLICATION_ENV);
    $query = "UPDATE migration_version SET current=0";
    $db->query($query);
    $this->downgradeCurrentChanges($props);
    $query = "UPDATE migration_version SET current=1 WHERE version=$this->version";
    $db->query($query);
  }

  /*
   *  Retrieves the specified file
   */
  private function getDumpFile( $params ) {
    $directoryIterator = new DirectoryIterator(WULFMIGRATIONS_PATH."/storage/". $params['version']."/");

    $dumpFile = null;
    //  Yes I know, forcing us to use down for down files it's a pain in the ass , but it's 23:00
    foreach( $directoryIterator as $module ) {
      if ( preg_match('/^[^\.]/',$module->getBaseName() ) and preg_match('/'.$params['matchName'].'/i',$module->getBaseName() )==1 ) {
        $dumpFile = $module->getBaseName();
        break;
      }
    }
    if($dumpFile==null) {
      throw new Exception("You don't have a migration {$params['matchName']} file. I won't continue until you fix this situation");
    }
    return $dumpFile;
  }

  /**
   * Migrate your system up
   * @todo refactor, too big for my taste
   */
  public function migrateUp() {
    $this->validateVersion();

    $db = $this->getDbAdapter();
    $result = $db->fetchAll("SELECT version FROM migration_version WHERE current=1");
    $curVersion = array_shift($result);
    $this->myCurVersion = empty($curVersion['version'])?0:$curVersion['version'];

    $props = new Zend_Config_Ini(WULFMIGRATIONS_PATH. "/configs/application.ini", APPLICATION_ENV);
    $dbUser = $props->resources->db->params->username;
    $dbPass = $props->resources->db->params->password;
    $dbName = $props->resources->db->params->dbname;

    $current = $this->myCurVersion;        
    $target = $this->version;        

    while( $current<$target ) {
      //  Why 0 ?, because if we don't have anyting as the current version, we say that the system is at 0
      $previous = $current;
      $current++;                                

      //  Retrieve the path to the file where the migration resides
      $dumpFile = $this->getDumpFile( array( 'version' => $current, 'matchName'=>'up' ) );
      $databasedump = WULFMIGRATIONS_PATH."/storage/$current/$dumpFile";                        

      if( file_exists($databasedump) == false ) {
        throw new Exception("While going up to $target, the system detected that you don't have an up file.System crashed at version $current");
      }
      print "Appling version $current with file $databasedump".PHP_EOL;
      $output = $this->popenWrapper(MYSQLBINARY." -u$dbUser -p$dbPass $dbName<$databasedump");

      if( !empty($output) ) {
        throw new Exception("While going up to $target, mysql crashed at version $current. This is the error from the command $output");
      }

      $this->addVersionToDatabase( $db, $current );
      $this->setCurrent( $db, $previous, $current );           
    }       
  }

  /**
   *  If the current migration file isn't in the version table, add it  
   */
  private function addVersionToDatabase( $db, $current ){        
    $query = "SELECT version FROM migration_version WHERE version=$current";
    $exists = $db->fetchAll($query);
    if(empty($exists)) {
      $query ="INSERT INTO migration_version(version,current,filePath,dateCreated) VALUES ($current,0,'/storage/$current','".date('Y-m-d H:i:s')."')";
      $db->query($query); 
    }
  }    

  /**
   *  Updates the version in the database
   */
  private function setCurrent( $db, $old, $new ){                
    //  Kill the current
    $query = "UPDATE migration_version SET current=0,dateUpdated='".date('Y-m-d H:i:s')."' WHERE version=$old";
    $db->query($query);      

    $query = "UPDATE migration_version SET current=1,dateUpdated='".date('Y-m-d H:i:s')."' WHERE version=$new";        
    $db->query($query);
  }


  /**
   * Apply the changes from the downfile
   * @param Zend_Config_Ini $props
   * @throws Exception
   * @return boolean
   */
  private function downgradeCurrentChanges($props) {
    //  Read properties
    $dbUser = $props->resources->db->params->username;
    $dbPass = $props->resources->db->params->password;
    $dbName = $props->resources->db->params->dbname;

    //  Now, loop until we match the current version
    $lastVersion = $this->myCurVersion;
    while( $lastVersion>$this->version ) {
      //  Get the next down
      $dumpFile = $this->getDumpFile( array( 'version' => $lastVersion, 'matchName'=>'down' ) );
      if( empty($dumpFile) ) {
        throw new Exception("Your system is compromised.We are in downgradeCurrentChanges, the system did not find a downVersion for migration $lastVersion");
      }
      $databasedump = WULFMIGRATIONS_PATH."/storage/$lastVersion/$dumpFile";
      $cmd = MYSQLBINARY." -u$dbUser -p$dbPass $dbName<$databasedump";
      $output = $this->popenWrapper($cmd);
      if( !empty($output) ) {
        // Needed to keep the correct migration version.  Otherwise it was setting to zero on a crash
        $db = $this->getDbAdapter();
        $query = "UPDATE migration_version SET current=1 WHERE version=$lastVersion";
        $db->query($query);
        throw new Exception("While downgrading db , the system crashed at $lastVersion.This is the output $output");
      }
      $lastVersion--;
    }

  }

  /**
   * Go up to version
   * @param int $version
   */
  public function setVersion($version) {
    $this->version = $version;
  }

  /**
   * Validate that the file we are about to use actually exists
   */
  private function validateVersion() {
    if(is_numeric($this->version)==false) {
      throw new Exception("You need to specify an unsigned int as a version.I refuse to continue");
    }

    if( $this->version<1 ) {
      throw new Exception("You can't specify a version lower than 1 because the system doesn't stores a 0 version");
    }

    if( file_exists(WULFMIGRATIONS_PATH."/storage/$this->version/") == false ) {
      throw new Exception("The system can't find the specified version or the system is corrupted.Aborting the whole process");
    }
  }
}
?>
