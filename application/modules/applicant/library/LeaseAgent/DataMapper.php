<?php
/**
 * Act as a wrapper for the models in the applicant
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @package applicant.library.leaseagent
 */

class Applicant_Library_LeaseAgent_DataMapper {

	/**
	 * Prefix for the model
	 * @var const
	 */
	const MODELPREFIX = 'Applicant_Model_';

	/**
	 * The key that it's used in the search
	 * @var const
	 */
	const APPLICANTKEY ='applicantId';

	/**
	 * Edge cases that require a special treatment
	 * @var array
	 */
	static $edgeCase = array('caddress','paddress','cwork','pwork');

	/**
	 * Edge cases that needs to be treated properly
	 * @var array
	 */
	static $resultEdgeCases = array('Occupant','Vehicles');

	/**
	 * Retrieve the information for the particular model
	 * @param array $args
	 * @return multitype:
	 */
	public function retrieveModelData(array $args=null){
		$buffer = $this->getApplicantMap();
		//	We retrieve the Model name , an example would Applicant_Model_AboutYou for example
		$modelName = self::MODELPREFIX.$buffer[$args['page']]['mapper'];
		$object = new $modelName();
		$search = $this->createSearch($args['page'], $args['id']);
		$bufferData = $object->findByKey($search);
		$data = $this->cleanUpData($bufferData,$buffer[$args['page']]['mapper']);
		return $data;
	}

	/**
	 * Prepare the search criteria for the model
	 * @param string $page
	 * @param int $id
	 * @return Ambigous <multitype:, multitype:boolean multitype:unknown  >
	 */
	public function createSearch($page,$id){
		$search = array();
		if( in_array($page,self::$edgeCase) ) {
			$search = array('returnClassObject'=>false,'search'=>array(self::APPLICANTKEY=>$id));
			//	For this key cases , we need to differentiate between current and previous
			switch($page) {
				case 'paddress':
					$search['search']['isCurrentResidence']=0;
					break;
				case 'caddress':
					$search['search']['isCurrentResidence']=1;
					break;
				case 'pwork':
					$search['search']['isCurrentEmployer']=0;
					break;
				case 'cwork':
					$search['search']['isCurrentEmployer']=1;
					break;
			}
		} else {
			$search = array('returnClassObject'=>false,'search'=>array(self::APPLICANTKEY=>$id));
		}
		return $search;
	}

	/**
	 * Clean up the information before returning it
	 * @param array $bufferData
	 * @param string $mapper
	 * @return array
	 */
	private function cleanUpData(array $bufferData=null,$mapper){
		$data = array();
		//	If the data is set then unwrap and convert to an array
		if ( $bufferData!==null ) {
			if(in_array($mapper,self::$resultEdgeCases) ){
				foreach($bufferData as $id=>$content){
					$data[]= $content->toArray();
				}
			} else {
				$data = array_shift($bufferData)->toArray();
			}
		}
		return $data;
	}


	/**
	 * We define the relation between the applicant form , icon and link
	 * @return array
	 */
	public function getApplicantMap(){
		$map = array(
								'about'=>array('form'=>'AboutYou','icon'=>'/images/24/onebit_18.gif','mapper'=>'PersonalInfo','token'=>'aboutYou'),
								'caddress'=> array('form'=>'Address','icon'=>'/images/24/box_48.gif','mapper'=>'Address','token'=>'address'),
								'paddress'=> array('form'=>'Address','icon'=>'/images/24/home_48.gif','mapper'=>'Address','token'=>'previousAddress'),
								'cwork'=>array('form'=>'WorkHistory','icon'=>'/images/24/circle_green.gif','mapper'=>'WorkHistory','token'=>'currentWorkHistory'),
								'pwork'=>array('form'=>'WorkHistory','icon'=>'/images/24/circle_orange.gif','mapper'=>'WorkHistory','token'=>'previousWorkHistory'),
								'credit'=> array('form'=>'CreditHistory','icon'=>'/images/24/credit_cards.gif','mapper'=>'CreditHistory','token'=>'applicantCreditHistory'),
								'rental' => array('form'=>'RentalCriminalHistory','icon'=>'/images/24/onebit_26.gif','mapper'=>'RentalCriminalHistory','token'=>'rentalCriminalHistory'),
								'spouse'=> array('form'=>'Spouse','icon'=>'/images/24/001_56.gif','mapper'=>'Spouse','token'=>'spouse'),
								'otherOccupants'=>array('form'=>'Occupants','icon'=>'/images/24/onebit_17.gif','mapper'=>'Occupant','token'=>'otherOccupantsForm'),
								'vehicles'=>array('form'=>'Vehicles','icon'=>'/images/24/car.gif','mapper'=>'Vehicles','token'=>'vehicles'),
								'survey'=>array('form'=>'Survey','icon'=>'/images/24/app_48.gif','mapper'=>'Survey','token'=>'whyYouRentedHere'),
								'ec'=>array('form'=>'EmergencyContact','icon'=>'/images/24/red_cross_24.gif','mapper'=>'EmergencyContact','token'=>'applicantEmergencyContact'),
								'authorization'=>array('form'=>'Authorization','icon'=>'/images/24/handshake.gif','mapper'=>'Authorization','token'=>'authorization')
		);
		return $map;
	}
}