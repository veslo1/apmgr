<?php
/**
 * Behaviour that all controllers that provide reporting should use
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 */
interface ZFReport_Interfaces_IReportable {
	/**
	 * The operation start for loging
	 * @var const
	 */
	const OPERATIONSTART='start';

	/**
	 * The operations end used for loging
	 * @var const
	 */
	const OPERATIONEND='end';

	/**
	 * The default format used
	 * @var string
	 */
	const TIMEFORMAT='H:i:s:u';
	
	/**
	 * Index action must display all the available reports
	 */
	public function indexAction();

	/**
	 * Collect stats on the reports that are run
	 * @param string $report The report that we are executing
	 * @param DateTime $time The time this operation starts
	 * @param string $type We are starting or finishing the retrieval
	 */
	public function logRun($report,$time,$type);
}