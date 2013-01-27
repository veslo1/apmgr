<?php
class Maintenance_ReportController extends ZFController_Controller implements ZFReport_Interfaces_IReportable,ZFObserver_ILogeable {

	/* (non-PHPdoc)
	 * @see library/ZFReport/Interfaces/ZFReport_Interfaces_IReportable::indexAction()
	 */
	public function indexAction() {
		$dbHelper = new ZFReport_Library_DbHelper();
		$this->view->reports = $dbHelper->getReport('maintenance');
	}

	public function servicerequestsAction()
	{
		$this->logRun("Service Requests", date(ZFReport_Interfaces_IReportable::TIMEFORMAT), 'Start');
		$args = $this->getRequest()->getParams();
		$reportHelper = new ZFReport_Library_DbHelper();
		$info = $reportHelper->getReportData('serviceRequests');
		$args['cacheIdentifier'] = $info['cacheIdentifier'];
		$report = new Maintenance_Library_Reports_ServiceRequests($args);
		$report->init();
		$records = $report->runReport(true);
		$this->logRun("Service Requests", date(ZFReport_Interfaces_IReportable::TIMEFORMAT), 'End');
		//	Here we indicate the helper that will be exporting or not, as you can see by the false parameter
		$exporting = $this->getRequest()->getParam('export',false);
		if(1==$exporting)
		{
			//	We are likely to export only if we have records
			if( count($records)>0 )
			{
				$this->logRun("Service Requests Export", date(ZFReport_Interfaces_IReportable::TIMEFORMAT), 'Start');
				//	Do not display the page , you will end up with the html code in the report
				$this->_helper->layout()->disableLayout();
				$this->_helper->viewRenderer->setNoRender(true);
				$report->exportReport();
				$this->logRun("Service Requests Export", date(ZFReport_Interfaces_IReportable::TIMEFORMAT), 'End');
			}
			else
			{
				$this->view->msg = 'noInfoToExport';
				$this->view->type = 'warning';
			}
		}
		$this->view->data = $this->paginate($records);
	}	
	
	/* (non-PHPdoc)
	 * @see library/ZFReport/Interfaces/ZFReport_Interfaces_IReportable::logRun()
	 */
	public function logRun($report,$time,$type) {
		$log = new ZFObserver_Forensic();
		$log->attach( new ZFObserver_Observers_Text() );
		$log->setStatus(ZFObserver_ILogeable::INFO);
		$logline = "$type for $report , $time";
		$log->notify($this,$logline);
	}

	/**
	 * Retrieve a string for logging
	 * @return string
	 */
	public function __toString() {
		return "Maintenance_Report_Controller";	
	}
}
