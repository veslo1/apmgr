<?php
/**
 * Created on Sep 13, 2009
 * RoleController.php
 * jvazquez
 * @package modules.role.controllers
 * <p>
 * This controller handles the Roles in the System
 * So far this is the best thing I can achieve to load the module. All the other options are just <strong>lunatic</strong> solutions
 * More than 5 classes loaded to load a file. It may allow you <strong>dynamic</strong> model loading, but the load on the server
 * is just <strong>stupid</strong>.
 * </p>
 */

class Country_UpdateController extends Zend_Controller_Action {
	 
	public function indexAction() {
		$request = $this->getRequest();

		$form = new Country_Form_Update();
			
		$id=$this->_getParam('id');

		$country = new Country_Model_Country();
		// look up country name
		$country = $country->findById( $id );
			
		if(!$country){
			//  TODO error msg if invalid country
			return false;
		}

		$form->populate( array( 'name'=>$country->getName() ) );
			
		if ($this->getRequest()->isPost())
		{
			if ($form->isValid($request->getPost()))
			{
				$input = $form->getValues();
				 
				// gaaaaay....but when I tried Country::findByKey it didn't like that
				$c_country = new Country_Model_Country();
				$check_country = $c_country->findByKey( array('name'=>$input['name']));

				// sets check id to passed in id so that if the name exists returns false above, then the country is saved...prolly a shorter/better way to do this though.
				$check_id = $id;
				 
				if( isset($check_country[0]))
				$check_id = $check_country[0]->getId();
				 
				if ( $check_id == $id)  {
					$country->setName( $input['name'] );
					$country->save();
					$this->_helper->redirector('index', 'view', 'country');
				}
				else
				{
					//  need to return validation error
				}
				 
			}
		}
		$this->view->form = $form;
	}
}
?>
