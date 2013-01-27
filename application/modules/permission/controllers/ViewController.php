<?php
/**
 * Created on Sep 20, 2009 by jvazquez
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 */

class Permission_ViewController extends ZFController_Controller {

	public function indexAction() {
		$permission = new Permission_Model_Permission();
		$column = $this->_getParam('column');
		$sort = $this->_getParam('sort');
		$this->view->records = $this->paginate($permission->fetchAll($column,$sort));
		$this->view->sort = ( $sort=='ASC') ? 'DESC' : 'ASC';
	}

	public function viewAction() {
		$id = $this->getRequest()->getParam('id');
		$permission = new Permission_Model_Permission();
		$exists = $permission->findById($id);
		if( $exists!=null )
		$this->view->record = $exists;
	}
}
?>