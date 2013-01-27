<?php
/**
 * Controller to allow the user to add pictures and video into the app
 *
 * @author jorgeomarvazquez
 */
class Unit_AddController extends ZFController_Controller
{

	/**
	 * Add a picture,movie for a unit
	 */
	public function addpictureAction()
	{
        $picHelper = new Unit_Library_PictureHelper();
        $services  = new Unit_Library_Impl_Service();
        $services->prepareUnitFileGraphic();
        $picHelper->setDao( new Unit_Library_Impl_Dao() );
        $id = $this->getRequest()->getParam('unitId',null);
        if( $services->prepareAddPicture($id) === true )
        {
        	$form = $services->getForm();
        	$this->view->form = $form;
        	if( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams() ) )
        	{
        		if( $services->addPicture($this->getRequest()->getParams(), $picHelper) == true )
        		{
        			if( $services->insertPicture( $this->getRequest()->getParams() ) == true )
        			{
        				$this->setFlashMessage(array('msg'=>'fileCreated','type'=>'success'));
        				$this->_redirect("unit/unit/updateunit/unitId/".$id);
        			}
        		}
        	}
        }
        $this->assignMessage($services->getMessageState());
	}
}
?>
