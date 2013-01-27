<?php
/**
 * Add Controller for prospects
 * @author Jorge Omar Vazquez<jvazquez@debserverp4.com.ar>
 * @package application.modules.prospects.controllers
 */
class Prospects_AddController extends ZFController_Controller
{
	public function indexAction()
	{
		$service = new Prospects_Library_ServiceImpl();
		$dao = new Prospects_Library_Dao();
		$dao->setTemplate(new Prospects_Model_DbTable_Prospects());
		$service->setDao($dao);
		$daoForm = new Unit_Library_Impl_Dao();
		$daoForm->setTemplate(new Unit_Model_DbTable_UnitModel());
		try{
		    $form = $service->getForm(array('name'=>'Prospects_Form_Add','set'=>true,'dao'=>$daoForm));
		    $this->view->form = $form;
		    if( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams() ) )
		    {
			try {
				if( $service->saveTransaction($this->getRequest()->getParams())==true )
				{
					$this->setFlashMessage(array('msg'=>'prospectSaved','type'=>'success'));
					$this->_redirect('prospects/view/index');
				}
			} catch (Exception $e) {
				$this->assignMessage($service->getMessageState());
			}
		    }
		    $this->assignMessage($service->getMessageState());
		}
		catch (Exception $e) {				
				$this->assignMessage(array('msg'=>'noUnitModels','type'=>'error'));
		}
	}
}