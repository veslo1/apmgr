<?php
/**
 * Retrieve the application map
 * @author jvazquez <jvazquez@debserverp4.com.ar>
 */
class Applicant_View_Helper_Apps extends ZFHelper_HelperCrud {

	/**
	 * Build the links of the applications that the applicant filled in
	 * @param array $appArray
	 */
	public function apps(array $appArray=null){
		$link = '';
		if( !empty($appArray) ) {
			$zvhu = new Zend_View_Helper_Url();
			$translator = $this->getTranslator();
			foreach($appArray as $id=>$link){
				echo "<a href=\"".$zvhu->url(array('module'=>'applicant','controller'=>'view','action'=>'completedapps','page'=>$id))."\"><img src=\"".$link['icon']."\" alt=\"".$translator->_($link['token'])."\" title=\"".$translator->_($link['token'])."\"/></a>";
			}
		}
	}
}
?>