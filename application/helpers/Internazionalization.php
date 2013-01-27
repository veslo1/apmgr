<?php
/**
 * Display a message in html.
 * The code retrieves a identifier and will call the i18n helper to translate
 * to the corresponding locale
 * @author Jorge Omar Vazquez<jvazquez@debserverp4.com.ar
 *
 */

class Wulf_View_Helper_Internazionalization extends Zend_View_Helper_Abstract
{

	/**
	 * The default identifier for unhandled messages
	 * @var const
	 */
	const DFTMSG='unhandledMsg';

	/**
	 * Constant that defines the messages type error
	 * @var const
	 */
	const ERR='error';

	/**
	 * Constant that defines the message type warning
	 * @var const
	 */
	const WRN='warning';

	/**
	 * Constant that defines the valid category for a msg
	 * @var const
	 */
	const SCS='success';

	/**
	 * Retrieve a i18n string identifier and translate it.
	 * Optionally we can receive an array of identifiers to fetch
	 * @param string|array $token
	 * @param string $messageType SUCCESS,ERROR,WARNING
	 * @example echo $this->i18nmessage('foo','ERROR');
	 * @example echo $this->i18nmessages(array('foo'=>'myi18nmessage'),'ERROR');
	 * @return string
	 */
	public function internazionalization($token=null,$messageType)
	{
		$output = null;
		if( is_array($token) )
		{
			foreach ($token as $id=>$msg)
			{
				$msg = $this->fetchi18nstring($msg);
				if( null!=$msg )
				{
					$output .=$this->buildHtml($msg, $messageType);
				}
			}
		}
		else
		{
			$output = $this->buildHtml($this->fetchi18nstring($token), $messageType);
		}
		return $output;
	}

	/**
	 * Retrieve the i18n translated message
	 * @param string $identifier
	 * @return string
	 */
	private function fetchi18nstring($identifier=null)
	{
		$translator = Zend_Registry::get('Zend_Translate');
		$msg = null;
		if (null!=$identifier)
		{
			$msg = $translator->_($identifier);
		}
		return $msg;
	}

	/**
	 * Build the html for the message
	 * @param string $msg
	 * @param string $messageType
	 * @return string
	 */
	private function buildHtml($msg,$messageType=NULL) {
		$output = null;
		if(null!=$msg) {
			$output .= "<div id='$messageType'>
					<span class='tr$messageType'></span>
                    <span onclick=\"$('#$messageType').fadeOut('slow');\" class='closeMessageNotification'><img src='/images/10/onebit_33.png'/></span>
					<p class='$messageType'>".$msg."</p>
					<span class='bl$messageType'></span>
					<span class='br$messageType'></span>
					</div><br/>";
		}
		return $output;
	}
}