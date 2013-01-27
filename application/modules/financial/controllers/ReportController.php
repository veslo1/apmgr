<?php
class Financial_ReportController extends ZFController_Controller implements ZFReport_Interfaces_IReportable,ZFObserver_ILogeable {

  /* (non-PHPdoc)
   * @see library/ZFReport/Interfaces/ZFReport_Interfaces_IReportable::indexAction()
   */
  public function indexAction() {
    $dbHelper = new ZFReport_Library_DbHelper();
    $this->view->reports = $dbHelper->getReport('financial');
  }

  public function balancesheetAction(){
    // <filter>
    $form = new Default_Form_Report();
    $form->setLegend('balanceSheet');
    $form->setCacheKey('balanceSheet');
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
    // </filter>		

    $reportObj = new Financial_Library_Reports_BalanceSheet($args);
    $reportObj->init();
    $result = $reportObj->runReport(true);

    $this->view->dateFrom = $result['dateFrom'];
    $this->view->dateTo = $result['dateTo'];
    $this->view->assets = $result['assets'];
    $this->view->liabilities = $result['liabilities'];
    $this->view->equity = $result['equity'];
    $this->view->sumAssets = $result['sumAssets'];
    $this->view->sumLiabilities = $result['sumLiabilities'];    
    $this->view->sumEquity = $result['sumEquity'];
    $this->view->sumLiabilityAndEquity= $result['sumLiabilityAndEquity'];
    $this->view->form = $form;
  }

  public function duefeeAction()
  {
    $this->logRun("Due Fee", date(ZFReport_Interfaces_IReportable::TIMEFORMAT), 'Start');
    //	Adding form to search info
    $form = new Default_Form_Report();
    $form->setForm();
    $form->setCacheKey('dueFee');

    if( $this->getRequest()->isPost() and $form->isValid($form->getValues()) )
    {
      $form->populate($this->getRequest()->getParams());
      $result = $form->persistData();
    }
    $persistedContent = $form->getPersistedData();
    $form->populate($persistedContent);
    //	We merge the parameters now
    $args = array_merge($this->getRequest()->getParams(),$persistedContent);

    $report = new Financial_Library_Reports_DueFee($args);
    $report->init();
    $records = $report->runReport(true);
    $this->logRun("Due Fee", date(ZFReport_Interfaces_IReportable::TIMEFORMAT), 'End');
    //	Here we indicate the helper that will be exporting or not, as you can see by the false parameter
    $exporting = $this->getRequest()->getParam('export',false);
    if(1==$exporting)
    {
      //	We are likely to export only if we have records
      if( count($records)>0 )
      {
        $this->logRun("Due Fee Export", date(ZFReport_Interfaces_IReportable::TIMEFORMAT), 'Start');
        //	Do not display the page , you will end up with the html code in the report
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $report->exportReport();
        $this->logRun("Due Fee Export", date(ZFReport_Interfaces_IReportable::TIMEFORMAT), 'End');
      }
      else
      {
        $this->view->msg = 'noInfoToExport';
        $this->view->type = 'warning';
      }
    }
    $this->view->data = $this->paginate($records);
    $this->view->form = $form;
  }

  public function duerentAction()
  {
    $this->logRun("Due Rent", date(ZFReport_Interfaces_IReportable::TIMEFORMAT), 'Start');
    //	Adding form to search info
    $form = new Default_Form_Report();
    $form->setForm();
    $form->setCacheKey('duerent');

    if( $this->getRequest()->isPost() and $form->isValid($form->getValues()) )
    {
      $form->populate($this->getRequest()->getParams());
      $result = $form->persistData();
    }
    $persistedContent = $form->getPersistedData();
    $form->populate($persistedContent);
    //	We merge the parameters now
    $args = array_merge($this->getRequest()->getParams(),$persistedContent);

    $report = new Financial_Library_Reports_DueRent($args);
    $report->init();
    $records = $report->runReport(true);
    $this->logRun("Due Rent", date(ZFReport_Interfaces_IReportable::TIMEFORMAT), 'End');
    //	Here we indicate the helper that will be exporting or not, as you can see by the false parameter
    $exporting = $this->getRequest()->getParam('export',false);
    if(1==$exporting)
    {
      //	We are likely to export only if we have records
      if( count($records)>0 )
      {
        $this->logRun("Due Rent Export", date(ZFReport_Interfaces_IReportable::TIMEFORMAT), 'Start');
        //	Do not display the page , you will end up with the html code in the report
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $report->exportReport();
        $this->logRun("Due Rent Export", date(ZFReport_Interfaces_IReportable::TIMEFORMAT), 'End');
      }
      else
      {
        $this->view->msg = 'noInfoToExport';
        $this->view->type = 'warning';
      }
    }
    $this->view->form = $form;
    $this->view->data = $this->paginate($records);
  }

  public function duerefundsAction()
  {
    $this->logRun("Due Refunds", date(ZFReport_Interfaces_IReportable::TIMEFORMAT), 'Start');
    //	Adding form to search info
    $form = new Default_Form_Report();
    $form->setForm();
    $form->setCacheKey('duerefunds');

    if( $this->getRequest()->isPost() and $form->isValid($form->getValues()) )
    {
      $form->populate($this->getRequest()->getParams());
      $result = $form->persistData();
    }
    $persistedContent = $form->getPersistedData();
    $form->populate($persistedContent);
    //	We merge the parameters now
    $args = array_merge($this->getRequest()->getParams(),$persistedContent);
    $report = new Financial_Library_Reports_DueRefunds($args);
    $report->init();
    $records = $report->runReport(true);
    $this->logRun("Due Refunds", date(ZFReport_Interfaces_IReportable::TIMEFORMAT), 'End');
    //	Here we indicate the helper that will be exporting or not, as you can see by the false parameter
    $exporting = $this->getRequest()->getParam('export',false);
    if(1==$exporting)
    {
      //	We are likely to export only if we have records
      if( count($records)>0 )
      {
        $this->logRun("Due Refunds Export", date(ZFReport_Interfaces_IReportable::TIMEFORMAT), 'Start');
        //	Do not display the page , you will end up with the html code in the report
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $report->exportReport();
        $this->logRun("Due Refunds Export", date(ZFReport_Interfaces_IReportable::TIMEFORMAT), 'End');
      }
      else
      {
        $this->view->msg = 'noInfoToExport';
        $this->view->type = 'warning';
      }
    }
    $this->view->form = $form;
    $this->view->data = $this->paginate($records);
  }

  public function incomestatementAction(){
    // <filter>
    $form = new Default_Form_Report();
    $form->setLegend('incomeStatement');
    $form->setCacheKey('incomeStatement');
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
    // </filter>		

    $reportObj = new Financial_Library_Reports_IncomeStatement($args);
    $reportObj->init();
    $result = $reportObj->runReport(true);   
        
    $this->view->dateFrom = $result['dateFrom'];
    $this->view->dateTo = $result['dateTo'];
    
    $this->view->revenue = $result['revenue'];
    $this->view->expense = $result['expense'];
    $this->view->sumRevenue = $result['sumRevenue'];
    $this->view->sumExpense = $result['sumExpense'];
    $this->view->balance = $result['balance'];    
        
    $this->view->form = $form;
  }

  public function lateduerentAction()
  {
    $this->logRun("Late Due Rent", date(ZFReport_Interfaces_IReportable::TIMEFORMAT), 'Start');
    //	Adding form to search info
    $form = new Default_Form_Report();
    $form->setForm();
    $form->setCacheKey('lateduerent');

    if( $this->getRequest()->isPost() and $form->isValid($form->getValues()) )
    {
      $form->populate($this->getRequest()->getParams());
      $result = $form->persistData();
    }
    $persistedContent = $form->getPersistedData();
    $form->populate($persistedContent);
    //	We merge the parameters now
    $args = array_merge($this->getRequest()->getParams(),$persistedContent);
    $report = new Financial_Library_Reports_LateDueRent($args);
    $report->init();
    $records = $report->runReport(true);
    $this->logRun("Late Due Rent", date(ZFReport_Interfaces_IReportable::TIMEFORMAT), 'End');
    //	Here we indicate the helper that will be exporting or not, as you can see by the false parameter
    $exporting = $this->getRequest()->getParam('export',false);
    if(1==$exporting)
    {
      //	We are likely to export only if we have records
      if( count($records)>0 )
      {
        $this->logRun("Late Due Rent Export", date(ZFReport_Interfaces_IReportable::TIMEFORMAT), 'Start');
        //	Do not display the page , you will end up with the html code in the report
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $report->exportReport();
        $this->logRun("Late Due Rent Export", date(ZFReport_Interfaces_IReportable::TIMEFORMAT), 'End');
      }
      else
      {
        $this->view->msg = 'noInfoToExport';
      }
    }
    $this->view->form = $form;
    $this->view->data = $this->paginate($records);
  }

  public function lateduefeeAction()
  {
    $this->logRun("Late Due Fee", date(ZFReport_Interfaces_IReportable::TIMEFORMAT), 'Start');
    //	Adding form to search info
    $form = new Default_Form_Report();
    $form->setForm();
    $form->setCacheKey('lateduefee');

    if( $this->getRequest()->isPost() and $form->isValid($form->getValues()) )
    {
      $form->populate($this->getRequest()->getParams());
      $result = $form->persistData();
    }
    $persistedContent = $form->getPersistedData();
    $form->populate($persistedContent);
    $args = array_merge($this->getRequest()->getParams(),$persistedContent);

    $report = new Financial_Library_Reports_LateDueFee($args);
    $report->init();
    $records = $report->runReport(true);
    $this->logRun("Late Due Fee", date(ZFReport_Interfaces_IReportable::TIMEFORMAT), 'End');
    //	Here we indicate the helper that will be exporting or not, as you can see by the false parameter
    $exporting = $this->getRequest()->getParam('export',false);
    if(1==$exporting)
    {
      //	We are likely to export only if we have records
      if( count($records)>0 )
      {
        $this->logRun("Late Due Fee Export", date(ZFReport_Interfaces_IReportable::TIMEFORMAT), 'Start');
        //	Do not display the page , you will end up with the html code in the report
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $report->exportReport();
        $this->logRun("Late Due Fee Export", date(ZFReport_Interfaces_IReportable::TIMEFORMAT), 'End');
      }
      else
      {
        $this->view->msg = 'noInfoToExport';
      }
    }
    $this->view->form = $form;
    $this->view->data = $this->paginate($records);
  }

  public function rentrollAction()
  {
    $this->logRun("Rent Roll", date(ZFReport_Interfaces_IReportable::TIMEFORMAT), 'Start');
    //	Adding form to search info
    $form = new Default_Form_Report();
    $form->setLegend('rentRoll');
    $form->setForm();
    $form->setCacheKey('lateduefee');

    if( $this->getRequest()->isPost() and $form->isValid($form->getValues()) )
    {
      $form->populate($this->getRequest()->getParams());
      $result = $form->persistData();
    }
    $persistedContent = $form->getPersistedData();
    $form->populate($persistedContent);
    $args = array_merge($this->getRequest()->getParams(),$persistedContent);
    $report = new Financial_Library_Reports_RentRoll($args);
    $report->init();
    $records = $report->runReport(true);
    $this->logRun("Rent Roll", date(ZFReport_Interfaces_IReportable::TIMEFORMAT), 'End');
    //	Here we indicate the helper that will be exporting or not, as you can see by the false parameter
    $exporting = $this->getRequest()->getParam('export',false);
    if(1==$exporting)
    {
      //	We are likely to export only if we have records
      if( count($records)>0 )
      {
        $this->logRun("Rent Roll Export", date(ZFReport_Interfaces_IReportable::TIMEFORMAT), 'Start');
        //	Do not display the page , you will end up with the html code in the report
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $report->exportReport();
        $this->logRun("Rent Roll Export", date(ZFReport_Interfaces_IReportable::TIMEFORMAT), 'End');
      }
      else
      {
        $this->view->msg = 'noInfoToExport';
      }
    }
    $this->view->form = $form;
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
    return "Financial_Report_Controller";
  }
}
