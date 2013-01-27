<?php
/**
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * Example on how to consume a web service (soap)
 * We just deploy this as a regular controller inside apmgr the only thing we need to know is where is the web service wsdl
 */
class User_SoapController extends ZFController_Controller {
	/**
	 * @var string $_WSDL_URI
	 */
	private $_WSDL_URI="http://soapServ.com/?wsdl";

	public function clientAction() {
		$client = new Zend_Soap_Client($this->_WSDL_URI);
		$this->view->result = $client->mathAdd(11, 55);
		$this->view->greet = $client->sayHello('Jorge');
	}
}