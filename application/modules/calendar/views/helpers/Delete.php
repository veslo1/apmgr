<?php
/**
 * Link helper for calendar module
 * @author jvazquez
 */
class Calendar_View_Helper_Delete extends Zend_View_Helper_Abstract {

	/**
	 * Show the proper edit button if the user is the owner
	 * @param int $recordId
	 */
	public function delete($recordId,$link,$caption,$deleteText=false) {
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
					$link = '<span onclick="confirmDelete(\''.$link.'\',\''.$translator->translate($deleteText).'\')">
                       <img src="/images/24/cancel_16.gif"
                   alt="'.$translator->translate($caption).'"
                   title="'.$translator->translate($caption).'"/></span>';
				}
			}
		}
		return $link;
	}
}