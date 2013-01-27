<?php
/**
 * List the current changes on the system
 * @author jvazquez <jvazquez@debserverp4.com.ar>
 */

class Lists extends Helper {

    /**
     * Constructor of the list helper
     * @param Zend_Db $db
     */
    public function __construct($db) {
        $this->setDbAdapter($db);
    }

    /**
     * Shows all the versions from the migration system
     * @return array
     */
    public function showVersion() {
        $db = $this->getDbAdapter();
        return $db->fetchAll("SELECT * FROM migration_version");
    }

    public function printMessage($args) {
        if( count($args) == 0 ) {
            print "You are at version 1".PHP_EOL;
        } else {
            print "Current versions.".PHP_EOL;
            print "ID=====Date Created===================Date Updated".PHP_EOL;
            foreach( $args as $id=>$revision ) {
                $current = $revision['current']==1?'*':'';
                print "|$current".$revision['version']."\t".$revision['dateCreated']."\t".$revision['dateUpdated'].PHP_EOL;
            }
            print "==================================================".PHP_EOL;
        }
    }
}
?>
