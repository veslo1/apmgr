<?php
/**
 * @author jvazquez <jvazquez@debserverp4.com.ar>
 */


class Append extends Helper {

    /**
     * The filename of the up file
     * @var string $upFile
     */
    protected $upFile;

    /**
     * The filename of the down file.
     * @var string $downFile
     */
    protected $downFile;

    public function __construct($db) {
        $this->setDbAdapter($db);
    }

    /**
     * Prepare the files
     * @param array $filename
     */
    public function setFileName($filename) {
        $this->checkFileName($filename);
        //  Force and forget about this
        $this->upFile = $filename[0];
        $this->downFile = $filename[1];
    }

    private function checkFileName($filename) {

        //  Verify that filename is ok
        if( empty($filename) ) {
            throw new Exception('Filename is missing, we won\'t continue');
        }

        if( count($filename) !=2 ) {
            throw new Exception("We need two files when we append files. One for going up, and one for going down.Else I won't setup stuff for you");
        }

        //  Check that the file exists
        $upExists = file_exists(WULFMIGRATIONS_PATH."/storage/".$filename[0].".sql");
        $downExists = file_exists(WULFMIGRATIONS_PATH."/storage/".$filename[1].".sql");
        if( $upExists==false or $downExists==false ) {
            throw new Exception("Please, verify that both files are on the ".WULFMIGRATIONS_PATH."/storage/ area");
        }
        $validDownName = preg_match('/down/i',$filename[1]);
        if($validDownName==false) {
            throw new Exception("Sorry, but I will have to ask you that you name your downfile with something that indicates that is a down file, like fooDown or foodown");
        }
    }

    /**
     * Retrieve a file and prepare to move it into the migrations folders.
     * We do expect to have up and down files
     * @throws Exception, RunTimeException
     */
    public function appendFile() {
        $db = $this->getDbAdapter();
        $result = $db->fetchAll("SELECT MAX(version) AS version FROM migration_version");
        if( count($result) == 0 ) {
            $this->yieldFirstMigration();
        } else {
            $this->appendMigrationFile($result);
        }
    }

    
    
    /**
     * We are running the first migration in the system
     * @throws Exception
     * @return boolean
     */
    private function yieldFirstMigration() {
        //	That means that the system is clean, and you are going to append
        //	 your first migration into the system.
        $folder = "1";
        $cmd = "mkdir ".WULFMIGRATIONS_PATH."/storage/$folder";
        $output = $this->popenWrapper($cmd);
        if( !empty($output) ) {
            $backupcmd = "rm -Rf".WULFMIGRATIONS_PATH."/storage/$folder";
            $output=$this->popenWrapper($backupcmd);
            throw new Exception("System error detected.Please, verify permissions, and delete the migration folder 1 if it exists, because we won't check if we deleted, your system permissions may be wrong");
        }

        $cmd = "cp ".WULFMIGRATIONS_PATH."/storage/".$this->upFile.".sql". " ".WULFMIGRATIONS_PATH."/storage/$folder/".$this->upFile.".sql";
        $outputUp = $this->popenWrapper($cmd);
        $cmd = "cp ".WULFMIGRATIONS_PATH."/storage/".$this->downFile.".sql". " ".WULFMIGRATIONS_PATH."/storage/$folder/".$this->downFile.".sql";
        $outputDown = $this->popenWrapper($cmd);

        /**
         * If we can't even copy the files , abort
         */
        if( !empty($outputUp) or !empty($outputDown) ) {
            $cmd = "rm -Rf ".WULFMIGRATIONS_PATH."/storage/$folder";
            $this->popenWrapper($cmd);
            throw new Exception("We couldn't move the file.The folder 1 has been deleted.Check permission inside storage");
        }

        //  Now delete the files
        $this->popenWrapper("rm ".WULFMIGRATIONS_PATH."/storage/".$this->upFile.".sql");
        $this->popenWrapper("rm ".WULFMIGRATIONS_PATH."/storage/".$this->downFile.".sql");
    }

    private function appendMigrationFile($args) {
//	Okay, then fetch the <strong>last</strong> version and prepare stuff
        $folder = array_shift($args);
        $newFolder = $folder['version'];
        $newFolder++;
        print "Creating folder $newFolder".PHP_EOL;
        $cmd = "mkdir ".WULFMIGRATIONS_PATH."/storage/$newFolder";
        $output = $this->popenWrapper($cmd);

        if( !empty($output) ) {
            throw new Exception("System error detected.Please, verify permissions.Obtained ${output}");
        }
        $cmd = "mv ".WULFMIGRATIONS_PATH."/storage/".$this->upFile.".sql". " ".WULFMIGRATIONS_PATH."/storage/$newFolder/".$this->upFile.".sql";
        $outputUp = $this->popenWrapper($cmd);
        $cmd = "mv ".WULFMIGRATIONS_PATH."/storage/".$this->downFile.".sql". " ".WULFMIGRATIONS_PATH."/storage/$newFolder/".$this->downFile.".sql";
        $outputDown = $this->popenWrapper($cmd);
        if( !empty($output) or !empty($outputDown) ) {
            $cmd = "rm -Rf ".WULFMIGRATIONS_PATH."/storage/$newFolder";
            $this->popenWrapper($cmd);
            throw new RuntimeException("Delete the ".WULFMIGRATIONS_PATH."/storage/$newFolder if it is there\n");
      }
    }
}
?>
