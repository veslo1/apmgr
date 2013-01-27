<?php
/**
 * Created on Sep 5, 2009 by jvazquez
 * datesite
 * classes.controllers.country
 * The country controller object.
 * <p>
 * This object represents the country controller object. It should be used for adding, editing, and viewing countries.  Please make sure to check data before deleting countries.  Users could be tied and that would leave orphan data.
 * </p>
 */

class City_CreateController extends Zend_Controller_Action {

	public function indexAction() {
		$request = $this->getRequest();
		$form    = new City_Form_Create();

		if ($this->getRequest()->isPost())
		{
			if ($form->isValid($request->getPost()))
			{
				$model = new City_Model_City($form->getValues());
				if ( $model->findByKey('name',$model->getName()) )
				{
					//  need to return validation error
				}
				else
				{
					$model->save();
					$this->_helper->redirector('view', 'index', 'city');
				}
			}
		}
		$this->view->form = $form;
	}

	public function getregionsAction() {
		//	This tells the application that we do not want to render the page
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		$region = new Province_Model_Province();
		$cid = $this->getRequest()->getParam('countryId');
		 
		$results=array();

		$selRegion = $region->findByKey( 'countryId', $cid );

		foreach ( $selRegion as $id=>$object ) {
			$results[]= array( 'value'=>$object->getId(),'name'=>$object->getName() );
		}

		echo Zend_Json::encode( $results );

	}

}
?>
