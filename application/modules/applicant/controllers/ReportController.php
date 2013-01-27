<?php
class Applicant_ReportController extends ZFController_Controller implements ZFReport_Interfaces_IReportable,ZFObserver_ILogeable {

	/* (non-PHPdoc)
	 * @see library/ZFReport/Interfaces/ZFReport_Interfaces_IReportable::indexAction()
	 */
	public function indexAction() {
		$dbHelper = new ZFReport_Library_DbHelper();
		$this->view->reports = $dbHelper->getReport('applicant');
	}

	public function applicantAction() {
		$this->logRun("Applicant Report", date(ZFReport_Interfaces_IReportable::TIMEFORMAT), 'Start');

		$form = new Default_Form_Report();
		$form->setLegend('applicant');
		$form->setCacheKey('applicantFormReport');
		$form->setForm();

		if( $this->getRequest()->isPost() and $form->isValid($form->getValues()) )
		{
			$form->populate($this->getRequest()->getParams());
			$result = $form->persistData();
		}

		$persistedContent = $form->getPersistedData();
		$form->populate($persistedContent);
		//	We merge the parameters now
		$args = array_merge($this->getRequest()->getParams(),$persistedContent);

		$report = new Applicant_Library_Reports_Applicant($args);
		$report->init();
		$records = $report->runReport(true);
		//	Here we indicate the helper that will be exporting or not, as you can see by the false parameter
		$exporting = $this->getRequest()->getParam('export',false);
		if( 1==$exporting )
		{
			//	We are likely to export only if we have records
			if( count($records)>0 )
			{
				$this->logRun("Applicant Report Export", date(ZFReport_Interfaces_IReportable::TIMEFORMAT), 'Start');
				//	Do not display the page , you will end up with the html code in the report
				$this->_helper->layout()->disableLayout();
				$this->_helper->viewRenderer->setNoRender(true);
				$report->exportReport();
				$this->logRun("Applicant Report Export", date(ZFReport_Interfaces_IReportable::TIMEFORMAT), 'End');
			}
			else
			{
				$this->view->msg = 'noInfoToExport';
			}
		}
		$this->view->data = $this->paginate($records);
		$this->view->form = $form;
		$this->logRun("Applicant Report", date(ZFReport_Interfaces_IReportable::TIMEFORMAT), 'End');
	}

	/**
	 * Display the applicants that paid a fee
	 */
	public function paidfeesAction(){
		$this->logRun("Applicant Paid Fees Report", date(ZFReport_Interfaces_IReportable::TIMEFORMAT), 'Start');

		$form = new Default_Form_Report();
		$form->setLegend('applicantpaidFees');
		$form->setCacheKey('paidFeesForm');
		$form->setForm();

		if( $this->getRequest()->isPost() and $form->isValid($form->getValues()) )
		{
			$form->populate($this->getRequest()->getParams());
			$result = $form->persistData();
		}

		$persistedContent = $form->getPersistedData();
		$form->populate($persistedContent);
		//	We merge the parameters now
		$args = array_merge($this->getRequest()->getParams(),$persistedContent);

		$report = new Applicant_Library_Reports_PaidFees($args);
		$report->init();
		$records = $report->runReport(true);
		//	Here we indicate the helper that will be exporting or not, as you can see by the false parameter
		$exporting = $this->getRequest()->getParam('export',false);
		if( 1==$exporting )
		{
			//	We are likely to export only if we have records
			if( $report->hasRecords() )
			{
				$this->logRun("Applicant Paid Fees Report Export", date(ZFReport_Interfaces_IReportable::TIMEFORMAT), 'Start');
				//	Do not display the page , you will end up with the html code in the report
				$this->_helper->layout()->disableLayout();
				$this->_helper->viewRenderer->setNoRender(true);
				$report->exportReport();
				$this->logRun("Applicant Paid Fees Report Export", date(ZFReport_Interfaces_IReportable::TIMEFORMAT), 'End');
			}
			else
			{
				$this->view->msg = 'noInfoToExport';
			}
		}
		$this->view->data = $this->paginate($records);
		$this->view->form = $form;
		$this->logRun("Applicant Paid Fees Report", date(ZFReport_Interfaces_IReportable::TIMEFORMAT), 'End');
	}

	public function nonpaidfeesAction(){
		$this->logRun("Applicant Non Paid Fees Report", date(ZFReport_Interfaces_IReportable::TIMEFORMAT), 'Start');

		$form = new Default_Form_Report();
		$form->setLegend('nonpaidFees');
		$form->setCacheKey('nonPaidFeesForm');
		$form->setForm();

		if( $this->getRequest()->isPost() and $form->isValid($form->getValues()) )
		{
			$form->populate($this->getRequest()->getParams());
			$result = $form->persistData();
		}

		$persistedContent = $form->getPersistedData();
		$form->populate($persistedContent);
		//	We merge the parameters now
		$args = array_merge($this->getRequest()->getParams(),$persistedContent);

		$report = new Applicant_Library_Reports_NonPaidFees($args);
		$report->init();
		$records = $report->runReport(true);
		//	Here we indicate the helper that will be exporting or not, as you can see by the false parameter
		$exporting = $this->getRequest()->getParam('export',false);
		if( 1==$exporting )
		{
			//	We are likely to export only if we have records
			if( $report->hasRecords()===true )
			{
				$this->logRun("Applicant Non Paid Fees Report Export", date(ZFReport_Interfaces_IReportable::TIMEFORMAT), 'Start');
				//	Do not display the page , you will end up with the html code in the report
				$this->_helper->layout()->disableLayout();
				$this->_helper->viewRenderer->setNoRender(true);
				$report->exportReport();
				$this->logRun("Applicant Non Paid Fees Report Export", date(ZFReport_Interfaces_IReportable::TIMEFORMAT), 'End');
			}
			else
			{
				$this->view->msg = 'noInfoToExport';
			}
		}
		$this->view->data = $this->paginate($records);
		$this->view->form = $form;
		$this->logRun("Applicant Non Paid Fees Report", date(ZFReport_Interfaces_IReportable::TIMEFORMAT), 'End');
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
		return "Applicant_Report_Controller";
	}
}