<?php
/**
 * Concrete implementation of the Apply Flow DAO
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @package application.modules.applicant.library.implementation
 */
class Applicant_Library_Implementation_FlowApplyDao implements Applicant_Library_Interface_FlowApplyDao
{
	/**
	 * The persistance engine
	 * @var Zend_Session_Namespace::
	 */
	private $dao;

	/* (non-PHPdoc)
	 * @see application/modules/applicant/library/Interface/Applicant_Library_Interface_FlowApplyDao::initPeristanceTemplate()
	 */
	public function initPeristanceTemplate(array $namespace)
	{
		if( !isset($namespace['sessionNamespace']) )
		{
			throw new Exception('Missing the namespace');
		}
		$this->dao = new Zend_Session_Namespace($namespace['sessionNamespace']);
		if( !isset($this->dao->initialized) )
		{
			Zend_Session::regenerateId();
			$this->dao->initialized = true;
			$this->dao->steps = $this->getPersistanceTemplate();
		}
	}

	/* (non-PHPdoc)
	 * @see application/modules/applicant/library/Interface/Applicant_Library_Interface_FlowApplyDao::findByStepName()
	 */
	public function findByStepName($step)
	{
		$result = null;
		if( isset($this->dao->{$step} ) )
		{
			$result =$this->dao->{$step};
		}
		return $result;
	}

	/* (non-PHPdoc)
	 * @see application/modules/applicant/library/Interface/Applicant_Library_Interface_FlowApplyDao::save()
	 */
	public function save(array $args)
	{
		$saved = false;
		if( isset($args['identifier']) )
		{
			$name = $args['identifier'];
			if( $name==='steps' )
			{
				$copy = $this->getPersistanceTemplate();
				foreach($args['data'] as $id=>$payload)
				{
					$copy[$id] = $payload;
				}
				$this->dao->{$name} = $copy;
			}
			else
			{
				$this->dao->{$name} = $args['data'];
			}
			$saved = isset($this->dao->{$name});
		}
		return $saved;
	}

	/* (non-PHPdoc)
	 * @see application/modules/applicant/library/Interface/Applicant_Library_Interface_FlowApplyDao::endSession()
	 */
	public function endSession()
	{
		return $this->dao->unsetAll();
	}

	/* (non-PHPdoc)
	 * @see application/modules/applicant/library/Interface/Applicant_Library_Interface_FlowApplyDao::getPersistanceTemplate()
	 */
	public function getPersistanceTemplate()
	{
		$steps = array(
		0=>array(
									'page' => 'apply',
									'url' => 'applicant/apply/index',
									'complete' => null,
									'payload'  => null,
									'current'  => null,
									'action'   => null,
									'next'     => 'applicant/apply/aboutyou'
									),
									1=>array(
									'page'=>'aboutYou',
									'url' => 'applicant/apply/aboutyou',
									'complete'=>null,
									'payload'=>null,
									'current'=>null,
									'action'=>null,
									'next'=>'applicant/apply/currentaddress',
									'prev' => 'applicant/apply/index'
									),
									2=>array(
									'page'=>'address',
									'url'=>'applicant/apply/currentaddress',
									'complete'=>null,
									'payload'=>null,
									'current'=>null,
									'action'=>null,
									'next'=>'applicant/apply/previousaddress',
									'prev' => 'applicant/apply/aboutyou'
									),
									3=>array(
									'page'=>'previousApplicantAddress',
									'url'=>'applicant/apply/previousaddress',
									'complete'=>null,
									'payload'=>null,
									'current'=>null,
									'action'=>null,
									'next'=>'applicant/apply/currentworkhistory',
									'prev' => 'applicant/apply/currentaddress'
									),
									4=>array(
									'page'=>'currentWorkHistory',
									'url'=>'applicant/apply/currentworkhistory',
									'complete'=>null,
									'payload'=>null,
									'current'=>null,
									'action'=>null,
									'next'=>'applicant/apply/previousworkhistory',
									'prev' => 'applicant/apply/previousaddress'
									),
									5=>array(
									'page'=>'previousWorkHistory',
									'url'=>'applicant/apply/previousworkhistory',
									'complete'=>null,
									'payload'=>null,
									'current'=>null,
									'action'=>null,
									'next'=>'applicant/apply/credithistory',
									'prev' => 'applicant/apply/currentworkhistory'
									),
									6=>array(
									'page'=>'applicantCreditHistory',
									'url'=>'applicant/apply/credithistory',
									'complete'=>null,
									'payload'=>null,
									'current'=>null,
									'action'=>null,
									'next'=>'applicant/apply/rentalcriminalhistory',
									'prev' => 'applicant/apply/previousworkhistory'
									),
									7=>array(
									'page'=>'rentalCriminalHistory',
									'url'=>'applicant/apply/rentalcriminalhistory',
									'complete'=>null,
									'payload'=>null,
									'current'=>null,
									'action'=>null,
									'next'=>'applicant/apply/spouse',
									'prev' => 'applicant/apply/credithistory'
									),
									8=>array(
									'page'=>'spouse',
									'url'=>'applicant/apply/spouse',
									'complete'=>null,
									'payload'=>null,
									'current'=>null,
									'action'=>null,
									'next'=>'applicant/apply/occupants',
									'prev' => 'applicant/apply/rentalcriminalhistory'
									),
									9=>array(
									'page'=>'otherOccupantsForm',
									'url'=>'applicant/apply/occupants',
									'complete'=>null,
									'payload'=>null,
									'current'=>null,
									'action'=>null,
									'next'=>'applicant/apply/vehicles',
									'prev' => 'applicant/apply/spouse'
									),
									10=>array(
									'page'=>'vehicles',
									'url'=>'applicant/apply/vehicles',
									'complete'=>null,
									'payload'=>null,
									'current'=>null,
									'action'=>null,
									'next'=>'applicant/apply/whyyourented',
									'prev' => 'applicant/apply/occupants'
									),
									11=>array(
									'page'=>'whyYouRentedHere',
									'url'=>'applicant/apply/whyyourented',
									'complete'=>null,
									'payload'=>null,
									'current'=>null,
									'action'=>null,
									'next'=>'applicant/apply/emergencycontact',
									'prev' => 'applicant/apply/vehicles'
									),
									12=>array(
									'page'=>'applicantEmergencyContact',
									'url'=>'applicant/apply/emergencycontact',
									'complete'=>null,
									'payload'=>null,
									'current'=>null,
									'action'=>null,
									'next'=>'applicant/apply/authorization',
									'prev' => 'applicant/apply/whyyourented'
									),
									13=>array(
									'page'=>'authorizationLabel',
									'url'=>'applicant/apply/authorization',
									'complete'=> null,
									'payload'=>  null,
									'current'=>  null,
									'action' =>  'applicant/apply/removeinfo',
									'next'	 => 'applicant/apply/end',
									'prev'   => 'applicant/apply/applicantemergencycontact'
									)
									);

									return $steps;
	}

	/**
	 * Determine if the session is initiated
	 * @param string $namespace
	 * @return boolean
	 */
	public static function sessionSet($namespace)
	{
		$initiated = false;
		$step = new Zend_Session_Namespace($namespace);
		$initiated = $step->initialized;
		return $initiated;
	}
}