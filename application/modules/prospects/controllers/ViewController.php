<?php
/**
 * View Controller for prospects
 * @author Jorge Omar Vazquez<jvazquez@debserverp4.com.ar>
 * @package application.modules.prospects.controllers
 */
class Prospects_ViewController extends ZFController_Controller
{
	public function indexAction()
	{
		$service = new Prospects_Library_ServiceImpl();
		$service->setDao(new Prospects_Library_Dao());
		$args = $this->getRequest()->getParams();
		$service->setSortHelper(new ZFDb_SortHelper($args));
		$prospects = $service->viewAllProspects();
		// $this->view->prospects = $prospects;
        $this->view->prospects = $this->paginate($prospects);
	}
	
	public function detailAction()
	{
		$service = new Prospects_Library_ServiceImpl();
		$service->setDao(new Prospects_Library_Dao());
		$service->setProspectAnswersDao(new Prospects_Library_ProspectAnswersDao());
		$service->setUnitModelDao(new Unit_Library_UnitModelDao());
		$id = $this->getRequest()->getParam('id',null);
		try
		{
			$this->view->prospect = $service->viewProspectId($id);
		}
		catch (Exception $e)
		{
			$this->assignMessage($service->getMessageState());
			$log = new ZFObserver_Forensic();
			$log->setStatus(ZFObserver_Forensic::ERR);
			$log->attach(new ZFObserver_Observers_Text());
			$log->notify(__CLASS__,"Exception caught in the code.Reported ".$e->getMessage());
		}
		$this->assignMessage($service->getMessageState());
	}
}
