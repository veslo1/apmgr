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
class Country_CreateController extends Zend_Controller_Action {
	 
	public function indexAction() {
		$request = $this->getRequest();
		$form    = new Country_Form_Create();
		if ($this->getRequest()->isPost())
		{
			if ($form->isValid($request->getPost()))
			{
				$model = new Country_Model_Country($form->getValues());
				//if ( $model->countryNameExists($model->getName()) )
				 
				if ( $model->findByKey('name',$model->getName()) )
				{
					//  need to return validation error
				}
				else
				{
					$model->save();
					$this->_helper->redirector('index', 'view', 'country',array('message'=>'Success'));
				}
			}
		}
		$this->view->form = $form;
	}
}
?>
