<?php
/**
 * Display a set of links for the provided unit model.
 * If the given model has units that are available for rent,
 * display an icon to view all the units that are available, or else, display an icon that
 * puts the user in a wait list if the given model does not have any unit for rent.
 *
 * @author Jorge Vazquez<jvazquez@debserverp4.com.ar>
 */
class Unit_View_Helper_UnitModelLinks extends ZFHelper_HelperCrud {
	static public $isAvaiable = 1;

	public function unitModelLinks($id,$link,$caption=null) {

		$units = array();
		$unit = new Unit_Model_Unit();
		$args = array('returnClassObject'=>false, 'search'=> array('unitModelId'=>$id,'isAvailable'=>self::$isAvaiable));
		$units = $unit->findByKey($args);
		//  If we have more than 1 unit for rent, show the green light icon.
		if( count($units)>0 ) {
			$strlink = $this->display(array('link'=>$link[0],'caption'=>$caption,'image'=>'/images/24/onebit_06.gif'));
		} else {
			$strlink = $this->display(array('link'=>$link[1],'caption'=>$caption,'image'=>'/images/24/onebit_15.gif'));
		}
		return $strlink;
	}
}
?>
