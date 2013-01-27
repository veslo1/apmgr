<?php
/**
 * Link helper for calendar module
 * @author jvazquez
 */
class Calendar_View_Helper_Edit extends Zend_View_Helper_Abstract {

	/**
	 * Create an edit button
	 * @param integer $recordId
	 * @param Zend_View_Url $link
	 * @param string $caption
	 * @return string
	 */
	public function edit($recordId,$link,$caption=null) {
		$userHelper = new User_Library_Helper_Utils();
		$userId = User_Library_Helper_Utils::currentUserId();
		$isAdmin = $userHelper->isRole('admin');
		if( $isAdmin==true or isset($userId) ) {
			$event = new Calendar_Model_Events();
			$event = $event->findById($recordId);
			if( !empty($event) ) {
				$owner = $event->getOwner();
				if( $isAdmin==true or $userId==$owner) {
					$translator = Zend_Registry::get('Zend_Translate');
					$link = "<a href=\"".$link."\"><img src=\"/images/24/onebit_20.gif\" alt=\"".
					$translator->translate($caption)."\" title=\"".
					$translator->translate($caption)."\"/></a>";
				}
			}
		}
		return $link;
	}
}