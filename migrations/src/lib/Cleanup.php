<?php
/**
 * Run administrative tasks
 *
 * @author jvazquez <jvazquez@debserverp4.com.ar>
 */
include 'Filters/FilterSqlIterator.php';

class Cleanup extends Helper {
    /**
     * Construct
     */
    public function __construct($db) {
        $this->setDbAdapter($db);
    }

    /**
     *
     * Retrieve the latest version
     * @return int
     */
    public function sweep() {
        $filtered = new FilterSqlIterator(WULFMIGRATIONS_PATH."/storage/");
        $max = 0;
        foreach( $filtered as $module ) {
            if( $max < $module->getBaseName() ) {
                $max = $module->getBaseName();
            }
        }
        return $max;
    }
}
?>