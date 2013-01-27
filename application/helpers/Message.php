<?php
class Wulf_View_Helper_Message extends Zend_View_Helper_Abstract {
	const SPC=NULL;
	/**
	 * Receive a message object and display the proper message.
	 * @param Message_Model_Message $message An instance of the message system.
	 * @return string
	 */
	public function message($messages) {
		$output = self::SPC;

		if( isset($messages) ) {
			$messages = is_array($messages)?$messages:array($messages);

			foreach( $messages as $id=>$message ) {
				if( $message instanceof Messages_Model_Messages ) {
					$elementId = $message->getCategory();
					$output .= "<div id='$elementId'>
					<span class='tr$elementId'></span>
                    <span onclick=\"$('#$elementId').fadeOut('slow');\" class='closeMessageNotification'><img src='/images/10/onebit_33.png'/></span>
					<p class='$elementId'>".$message->getMessage()."</p>
					<span class='bl$elementId'></span>
					<span class='br$elementId'></span>
					</div><br/>";
				}
			}
		}
		return $output;
	}
}
?>