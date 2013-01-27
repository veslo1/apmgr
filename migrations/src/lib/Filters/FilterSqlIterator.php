<?php
/**
 * Implementation of FilterIterator
 *
 * @author jvazquez <jvazquez@debserverp4.com.ar>
 */
class FilterSqlIterator extends FilterIterator {
    
    public function  __construct($path) {
        parent::__construct(new DirectoryIterator($path));
    }

    /**
     * see the spl
     */
    public function accept() {
        return !$this->getInnerIterator()->isDot();
    }
}
?>
