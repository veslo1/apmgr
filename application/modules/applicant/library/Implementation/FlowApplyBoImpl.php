<?php
/**
 * Implementation of the business object for a work flow
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @package application.modules.library.implementation
 */
class Applicant_Library_Implementation_FlowApplyBoImpl implements Applicant_Library_Interface_FlowApplyBo
{
	/**
	 * Dao used to persist information
	 * @var Applicant_Library_Interface_FlowApplyDao
	 */
	private $dao;

	/**
	 * Array that the user sends to the flow
	 * @var array
	 */
	private $payload;

	/**
	 * Set the dao
	 * @param Applicant_Library_Interface_FlowApplyDao $dao
	 */
	public function setDao(Applicant_Library_Interface_FlowApplyDao $dao)
	{
		$this->dao = $dao;
	}

	/**
	 * Retrieve the dao
	 * @return Applicant_Library_Interface_FlowApplyDao
	 */
	public function getDao()
	{
		return $this->dao;
	}

	/* (non-PHPdoc)
	 * @see application/modules/applicant/library/Interface/Applicant_Library_Interface_Flowbo::setPayload()
	 */
	public function setPayload(array $args)
	{
		$this->payload = $args;
	}

	/* (non-PHPdoc)
	 * @see application/modules/applicant/library/Interface/Applicant_Library_Interface_Flowbo::getPayload()
	 */
	public function getPayload()
	{
		return $this->payload;
	}

	/* (non-PHPdoc)
	 * @see application/modules/applicant/library/Interface/Applicant_Library_Interface_Flowbo::validateWorkflowStep()
	 */
	public function validateWorkflowStep()
	{
		$valid = false;
		if( isset($this->dao) )
		{
			$valid = $this->dao->sessionSet('applicantApply')==true;
		}
		return $valid;
	}

	/* (non-PHPdoc)
	 * @see application/modules/applicant/library/Interface/Applicant_Library_Interface_Flowbo::moveNext()
	 */
	public function moveNext()
	{
		if( isset($this->dao)==false )
		{
			throw new Exception('Session is not set');
		}
		$next = $this->handleMoveOperation('up');
		return $next;
	}

	/* (non-PHPdoc)
	 * @see application/modules/applicant/library/Interface/Applicant_Library_Interface_Flowbo::movePrevious()
	 */
	public function movePrevious()
	{
		if( isset($this->dao)==false )
		{
			throw new Exception('Session is not set');
		}
		$next = $this->handleMoveOperation('down');
		return $next;
	}

	/* (non-PHPdoc)
	 * @see application/modules/applicant/library/Interface/Applicant_Library_Interface_Flowbo::save()
	 */
	public function save(array $args)
	{
		$saved = false;
		if( isset($args['identifier'])===false )
		{
			throw new Exception('Missing session identifier');
		}

		if( isset($args['data'])===false )
		{
			throw new Exception('Missing session data');
		}
		$name = $args['identifier'];
		$saved = $this->dao->save($args);
		return $saved;
	}

	/* (non-PHPdoc)
	 * @see application/modules/applicant/library/Interface/Applicant_Library_Interface_Flowbo::handleError()
	 */
	public function handleError(Zend_Namespace_Session $session)
	{}

	/* (non-PHPdoc)
	 * @see application/modules/applicant/library/Interface/Applicant_Library_Interface_FlowApplyBo::findByStepName()
	 */
	public function findByStepName($name)
	{
		return $this->dao->findByStepName($name);
	}

	/* (non-PHPdoc)
	 * @see application/modules/applicant/library/Interface/Applicant_Library_Interface_FlowApplyBo::endFlow()
	 */
	public function endFlow(array $args)
	{
		return $this->dao->endSession();
	}

	/**
	 * Handle the moveNext operation in details
	 * @param string $mode 'up'|'down'
	 * @throws Exception
	 * @return Ambigous <NULL, string>
	 */
	public function handleMoveOperation($mode)
	{
		//	Prepare the temp variables
		$url = null;
		$pivot = null;
		$currentIndex = null;
		$previous = null;

		//	Fetch the current step we are in
		$currentDao = $this->dao->findByStepName('steps');
		$stepsIterator = new Applicant_Library_Filter_WorkflowCurrentIterator(new ArrayIterator($currentDao));
		//	This retrieves the only record that is considered current
		foreach($stepsIterator as $id=>$value)
		{
			$pivot = $value;
			$currentIndex = $id;
		}
		if($pivot === null)
		{
			throw new ErrorException("There is no current step");
		}
		switch ($mode)
		{
			case 'up':
				$this->shiftUp($currentIndex);
				$url = !empty($pivot['action'])?$pivot['action']:$pivot['next'];
				break;
			case 'down':
				$this->shiftDown($currentDao, $currentIndex, $pivot);
				$url = !empty($pivot['action'])?$pivot['action']:$pivot['prev'];
				break;
			default:
				throw new IllegalArgumentException($mode.' is not a valid mode to shift a work flow');
		}
		return $url;
	}

	/**
	 * Handles a shift up operation in a work flow object.
	 * The set of restrictions that apply to this method
	 * <ul>
	 * 	<li>We can't go further than the value #13 , since it's the last step. Index 13 means the user finished the work flow</li>
	 * </ul>
	 * @param int $currentIndex
	 */
	public function shiftUp($currentIndex)
	{
		$saved = false;
		if( $currentIndex>13 or $currentIndex< 0)
		{
			throw new InvalidArgumentException('Index out of bounds exception');
		}
		$pivot = $this->findByStepName('steps');
		//	Since we are moving next , we need to inform the work flow that we are not longer current
		$pivot[$currentIndex]['current'] = 0;
//		$pivot[$currentIndex]['complete'] = 1;
//		$args = array('identifier'=>'steps','data'=>array($currentIndex=>$pivot[$currentIndex]));
//		$saved = $this->save($args);
//		if($saved==false)
//		{
//			throw new Exception('Unable to update the current step as not current');
//		}
		//	Fetch the next step
		$nextIndex=$currentIndex+1;
		$pivot[$nextIndex]['current'] = true;
		$args = array('identifier'=>'steps','data'=>array($currentIndex=>$pivot[$currentIndex],$nextIndex=>$pivot[$nextIndex]));
		$saved = $this->save($args);
		if($saved==false)
		{
			throw new Exception('Unable to update the current step');
		}
		return $saved;
	}

	/**
	 * Handles a shift down operation in a work flow object.
	 * The set of restrictions that apply to this method
	 * <ul>
	 * 	<li>We can't go further than the value 1 , since it's the last step. Index 1 means the user had an account or he created one. Moving further results in a exception
	 * </ul>
	 * @param array $currentDao
	 * @param int $currentIndex
	 * @param array $pivot
	 */
	public function shiftDown(array $currentDao,$currentIndex,array $pivot)
	{
		$saved = false;
		if( $currentIndex>13 or $currentIndex==1)
		{
			throw new InvalidArgumentException('Index out of bounds exception');
		}

		if( $pivot === null )
		{
			throw new InvalidArgumentException('The pivot step is null.We can not operate with a null step');
		}

		//	Since we are moving next , we need to inform the work flow that we are not longer current
		$pivot['current'] = false;
		$args = array('identifier'=>'steps','data'=>$pivot);
		$saved = $this->save($args);
		if($saved==false)
		{
			throw new Exception('Unable to update the current step as not current');
		}
		//	Update the local copy of the template for the current step in the currentDao that we obtained
		$currentDao[$currentIndex] = $pivot;
		//	Fetch the previous step
		$currentIndex = $currentIndex - 1;
		$currentDao[$currentIndex]['current'] = true;
		$args = array('identifier'=>'steps','data'=>$currentDao);
		$saved = $this->save($args);
		if($saved==false)
		{
			throw new Exception('Unable to update the current step');
		}
		return $saved;
	}
}