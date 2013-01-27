<?php
/**
 * Gateway to the applicant transaction table.
 * Record each step the user takes in our application
 *
 * @author Jorge Vazquez<jvazquez@debserverp4.com.ar>
 */
class Applicant_Model_DbTable_ApplicantTransaction extends Zend_Db_Table_Abstract {
	protected $_name = 'applicantTransactions';
}