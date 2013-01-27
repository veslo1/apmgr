<?php
/**
 * @author Jorge Vazquez <jvazquez@debserverp4.com.ar>
 */
class Applicant_Model_Survey extends ZFModel_ParentModel {

	/**
	 * @var int $applicantId
	 */
	protected $applicantId;

	/**
	 * @var $wereYouReferred;
	 */
	protected $wereYouReferred;

	/**
	 * @var YES $answerId
	 */
	protected $howDidYouFindUs;

	public function __construct(array $options=null) {
		parent::__construct($options);
		$this->setDbTable('Applicant_Model_DbTable_ApplicantSurvey');
	}

	/**
	 * Set applicantId
	 */
	public function setApplicantId($applicantId) {
		$this->applicantId=$applicantId;
		return $this;
	}

	/**
	 * Get applicantId
	 */
	public function getApplicantId() {
		return $this->applicantId;
	}

	/**
	 * Set wereYouReferred
	 * @param string $answer
	 */
	public function setWereYouReferred($answer=null) {
		$this->wereYouReferred = $answer;
		return $this;
	}

	/**
	 * Get wereYouReferred
	 * @return string
	 */
	public function getWereYouReferred() {
		return $this->wereYouReferred;
	}

	/**
	 * Set setHowDidYouFindUs
	 */
	public function setHowDidYouFindUs($answer=null) {
		$this->howDidYouFindUs = $answer;
		return $this;
	}
	/**
	 * Get setHowDidYouFindUs
	 */
	public function getHowDidYouFindUs() {
		return $this->howDidYouFindUs;
	}
}
