<?php
class Unit_ReportController extends ZFController_Controller implements ZFReport_Interfaces_IReportable,ZFObserver_ILogeable {

	/* (non-PHPdoc)
	 * @see library/ZFReport/Interfaces/ZFReport_Interfaces_IReportable::indexAction()
	 */
	public function indexAction() {
		$dbHelper = new ZFReport_Library_DbHelper();
		$this->view->reports = $dbHelper->getReport('unit');
	}

	public function cancelledleaseAction()
	{
		$this->logRun("Lease Cancellation", date(ZFReport_Interfaces_IReportable::TIMEFORMAT), 'Start');
		//	Adding form to search info
		$form = new Default_Form_Report();
		$form->setLegend('leaseCancellation');
		$form->setCacheKey('cancelledLeaseForm');
		$form->setForm();

		$args = $this->getRequest()->getParams();
		$report = new Unit_Library_Reports_CancelledLease($args);
		$report->init();
		$records = $report->runReport(true);
		$this->logRun("Lease Cancellation", date(ZFReport_Interfaces_IReportable::TIMEFORMAT), 'End');
		//	Here we indicate the helper that will be exporting or not, as you can see by the false parameter
		$exporting = $this->getRequest()->getParam('export',false);
		if(1==$exporting)
		{
			//	We are likely to export only if we have records
			if( count($records)>0 )
			{
				$this->logRun("Lease Cancellation Export", date(ZFReport_Interfaces_IReportable::TIMEFORMAT), 'Start');
				//	Do not display the page , you will end up with the html code in the report
				$this->_helper->layout()->disableLayout();
				$this->_helper->viewRenderer->setNoRender(true);
				$report->exportReport();
				$this->logRun("Lease Cancellation Export", date(ZFReport_Interfaces_IReportable::TIMEFORMAT), 'End');
			}
			else
			{
				$this->view->msg = 'noInfoToExport';
				$this->view->type = 'warning';
			}
		}
		$this->view->data = $this->paginate($records);
	}

	public function incomingtenantsAction()
	{
		$this->logRun("Incoming Tenants", date(ZFReport_Interfaces_IReportable::TIMEFORMAT), 'Start');
		$args = $this->getRequest()->getParams();
		
		$report = new Unit_Library_Reports_IncomingTenants($args);
		$report->init();
		$records = $report->runReport(true);
		$this->logRun("Incoming Tenants", date(ZFReport_Interfaces_IReportable::TIMEFORMAT), 'End');
		//	Here we indicate the helper that will be exporting or not, as you can see by the false parameter
		$exporting = $this->getRequest()->getParam('export',false);
		if(1==$exporting)
		{
			//	We are likely to export only if we have records
			if( count($records)>0 )
			{
				$this->logRun("Incoming Tenants Export", date(ZFReport_Interfaces_IReportable::TIMEFORMAT), 'Start');
				//	Do not display the page , you will end up with the html code in the report
				$this->_helper->layout()->disableLayout();
				$this->_helper->viewRenderer->setNoRender(true);
				$report->exportReport();
				$this->logRun("Incoming Tenants Export", date(ZFReport_Interfaces_IReportable::TIMEFORMAT), 'End');
			}
			else
			{
				$this->view->msg = 'noInfoToExport';
				$this->view->type = 'warning';
			}
		}
		$this->view->data = $this->paginate($records);
	}

	public function outgoingtenantsAction()
	{
		$this->logRun("Outgoing Tenants", date(ZFReport_Interfaces_IReportable::TIMEFORMAT), 'Start');
		$args = $this->getRequest()->getParams();		
		$report = new Unit_Library_Reports_OutgoingTenants($args);
		$report->init();
		$records = $report->runReport(true);
		$this->logRun("Outgoing Tenants", date(ZFReport_Interfaces_IReportable::TIMEFORMAT), 'End');
		//	Here we indicate the helper that will be exporting or not, as you can see by the false parameter
		$exporting = $this->getRequest()->getParam('export',false);
		if(1==$exporting)
		{
			//	We are likely to export only if we have records
			if( count($records)>0 )
			{
				$this->logRun("Outgoing Tenants Export", date(ZFReport_Interfaces_IReportable::TIMEFORMAT), 'Start');
				//	Do not display the page , you will end up with the html code in the report
				$this->_helper->layout()->disableLayout();
				$this->_helper->viewRenderer->setNoRender(true);
				$report->exportReport();
				$this->logRun("Outgoing Tenants Export", date(ZFReport_Interfaces_IReportable::TIMEFORMAT), 'End');
			}
			else
			{
				$this->view->msg = 'noInfoToExport';
				$this->view->type = 'warning';
			}
		}
		$this->view->data = $this->paginate($records);
	}

	public function unoccupiedunitsAction()
	{
		$this->logRun("Unoccupied Units", date(ZFReport_Interfaces_IReportable::TIMEFORMAT), 'Start');
		$args = $this->getRequest()->getParams();
		$reportHelper = new ZFReport_Library_DbHelper();
		$info = $reportHelper->getReportData('unoccupiedUnits');
		$args['cacheIdentifier'] = $info['cacheIdentifier'];
		$report = new Unit_Library_Reports_UnoccupiedUnits($args);
		$report->init();
		$records = $report->runReport(true);
		$this->logRun("Unoccupied Units", date(ZFReport_Interfaces_IReportable::TIMEFORMAT), 'End');
		//	Here we indicate the helper that will be exporting or not, as you can see by the false parameter
		$exporting = $this->getRequest()->getParam('export',false);
		if(1==$exporting)
		{
			//	We are likely to export only if we have records
			if( count($records)>0 )
			{
				$this->logRun("Unoccupied Units Export", date(ZFReport_Interfaces_IReportable::TIMEFORMAT), 'Start');
				//	Do not display the page , you will end up with the html code in the report
				$this->_helper->layout()->disableLayout();
				$this->_helper->viewRenderer->setNoRender(true);
				$report->exportReport();
				$this->logRun("Unoccupied Units Export", date(ZFReport_Interfaces_IReportable::TIMEFORMAT), 'End');
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
		return "Unit_Report_Controller";
	}
}
