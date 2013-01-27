<?php
/**
 * Created on Dec 5, 2009 by rnelson
 * @name apmgr
 * @package application.modules.unit.controllers
 * <p>
 * Controller for deleting unit
 * </p>
 */

class Unit_DeleteController extends ZFController_Controller {

	public function indexAction() {
		$unit = new Unit_Model_Unit();
		$this->view->record =  $unit->fetchAll();
	}

	public function deleteAction() {
		$result = false;
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		$id = $this->getRequest()->getParam('id');
		$unit = new Unit_Model_Unit();

		$unitExists = $unit->findById($id);

		if( $unitExists ) {
			$result = $unit->delete($id);
		}

		$msg = ($result)? $msg='Deleted' : $msg='Error';
		$this->_helper->redirector('index', 'index', 'unit',array('msg'=> $msg) );
	}

	public function deleteunitmetadataAction()
	{
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		$this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
		$id = $this->getRequest()->getParam('id');
		$unitid = $this->getRequest()->getParam('unitId');
		if( isset($id) )
		{
			$service = new File_Library_Impl_Service();
			$dao = new File_Library_Impl_Dao();
			$dao->setTemplate(new File_Model_DbTable_File());
			$service->setDao($dao);
			if($service->delete($id) == true )
			{
				$this->_flashMessenger->addMessage(array('msg'=>'unitmetadatadeleted','type'=>'success'));
			}
			else
			{
				$this->_flashMessenger->addMessage(array('msg'=>'metadatadeletefail','type'=>'error'));
			}
		}
		else
		{
			$this->_flashMessenger->addMessage(array('msg'=>'unitIdMissing','type'=>'error'));
		}
		$this->_helper->redirector('viewunitgraphics','unit','unit',array('unitId'=>$unitid));
	}
}
?>
