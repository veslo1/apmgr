<?php
/**
 * Created on Sep 26, 2009
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @link apmgr.com/user/login
 * @internal Refactored 10/23/2010
 */

class User_LoginController extends ZFController_Controller {

    public function indexAction()
    {
        $form = new User_Form_Login();
        $helper = new User_Library_Helper_Login();
        if ( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams() ) )
        {
            $valid = $helper->authenticateUser($this->getRequest()->getParam('username'), $this->getRequest()->getParam('password'));
            $destination = $helper->getLoginDestination($valid);
            if($valid==true)
            {
                $this->_helper->redirector->gotoUrl($destination);
            }
            $this->view->msg = array('msg'=>$helper->getMessageState(),'type'=>'error');
        }
        $this->view->form = $form;
    }

    /**
     * The logout action. It just clears the session and takes you back to the frontpage
     * @internal adding cache clean for directory structure
     */
    public function logoutAction() {
        $auth = Zend_Auth::getInstance();
        $auth->setStorage(new Zend_Auth_Storage_Session('vazneyStorage'));
        $auth->clearIdentity();
        $docklet = new Zend_Session_Namespace('Docklet');
        $docklet->unsetAll();
        $trace = new Zend_Session_Namespace('vazneyStorageTrace');
        $trace->unsetAll();
        $cache = Zend_Registry::get('cache');
        $cache->clean(Zend_Cache::CLEANING_MODE_ALL);
        $this->_redirector = $this->_helper->getHelper('Redirector');
        $this->_redirector->gotoSimple('index','index','default');
    }
}
?>
