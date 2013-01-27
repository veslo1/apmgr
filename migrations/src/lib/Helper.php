<?php
/**
 * This abstract class acts as a container for the database connection and the
 * popen wrapper
 * @author jvazquez <jvazquez@debserverp4.com.ar>
 */
abstract class Helper {

    protected $dbAdapter;

    protected function setDbAdapter($db) {
        $this->dbAdapter = $db;
    }

    /**
     * Retrieve the connection
     */
    protected function getDbAdapter() {
        return $this->dbAdapter;
    }

    /**
     * Wrapper for popen , do not send nothing silly here...
     * Returns the output from a command.
     * @param string $cmd
     * @return string
     */
    protected function popenWrapper($cmd) {
        $handle = popen($cmd.' 2>&1', 'r');
        $output = null;
        while( !feof($handle) ) {
            $output .=fread($handle,4096);
        }
        return $output;
    }
}
?>
