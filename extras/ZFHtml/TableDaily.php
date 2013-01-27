<?php
/**
 * This is the implementation for a single day
 *
 * @author jvazquez <jvazquez@debserverp4.com.ar>
 */
class ZFHtml_TableDaily extends ZFDate_Abstract_DateUtils implements ZFHtml_Interface_HtmlInterface,ZFObserver_ILogeable {

	/**
	 * The userId we are fetching info
	 * @var integer
	 */
	protected $userId;

	/**
	 *
	 * @var Zend_Date $date
	 */
	protected $date;

	/**
	 *
	 * Logger for PHPUnit
	 * @var ZFObserver_Forensic
	 */
	protected $log;

	/**
	 * Constructor for the daily view
	 * @param array $options
	 */
	public function __construct(array $options=null) {
		$this->setProperties();

		$this->log = new ZFObserver_Forensic();
		$this->log->attach(new ZFObserver_Observers_Text());
		$this->log->setStatus(ZFObserver_ILogeable::DEBUG);

		if( isset($options['action']) ) {
			$this->setAction($options['action']);
		} else {
			$props = $this->getProperties();
			$action = $props->calendar->tableDaily->default->action;
			$this->setAction($action);
		}

		if( isset($options['userid']) ) {
			$this->userId = (int)$options['userid'];
		}

		if ( !isset($options['date']) ) {
			$props = $this->getProperties();
			$format = $props->date->sqlformat;
			$options['date'] = date($format);
		}

		$date = date_parse($options['date']);

		if( empty($date['errors']) ) {
			Zend_Date::setOptions(array('format_type' => 'php'));
			$this->date = new Zend_Date();
			$this->date->setLocale(Zend_Registry::get('Zend_Locale'));
			$this->date->setTimestamp(mktime(null, null, null, $date['month'], $date['day'],$date['year']));
		}

	}

	/**
	 * Generate the calendar
	 * @return string
	 */
	public function yield() {
		$props = $this->getProperties();
		$format = $props->date->sqlformat;
		$hours = $this->yieldIntervalHours();
		$source = $this->forgeHtml($hours);
		$dom = new DOMDocument();
		$dom->strictErrorChecking = false;
		$dom->loadHTML($source);

		$events = $this->fetchEvents(array($this->date->toString($format)));
		$this->fixTimeAndIntegrate($dom, $events,$hours);
		$s = $dom->saveHTML();
		$s = str_ireplace('<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">', '', $s);
		$s = str_ireplace('<html><body>', '', $s);
		$s = str_ireplace('</body></html>', '', $s);
		return $s;
	}

	/**
	 * Populate the array that we are going to use to view the events
	 * @param array $hours
	 */
	public function fetchEvents($date) {
		$cEvents = new Calendar_Model_EventsTime();

		//  Fetch the ones I'm a owner
		$owner = $cEvents->fetchEvents($this->userId,$date[0],false);
		//  And fetch the ones I'm a guest
		$guest = $cEvents->fetchEvents($this->userId,$date[0],true);
		$result = array_merge($owner, $guest);
		return $result;
	}

	/**
	 * Generate the string that we will feed in a DOMDocument object
	 * @param array $hours
	 * @return string
	 */
	public function forgeHtml($hours) {
		$props = $this->getProperties();
		$format = $props->calendar->week->view;
		$idDom = $props->date->id->dom;
		$dateId = $this->date->toString($idDom);
		$s = "<table id=\"rounded-corner\"><thead><tr><th class=\"rounded-calendar\"></th><th class=\"rounded-q4\"></th></tr></thead><tbody>";
		$count = count($hours)-1;

		foreach($hours as $index=>$hour) {
			$s .="<tr><td>{$hour}</td>";
			$s .="<td id=\"$dateId$hour\"></td>";
			$s."</tr>";
		}
		$s .="</tbody></table>";
		return $s;
	}

	/**
	 * Helper method , we have a recordset and a domdocument object
	 * that we need to push information into. The times have to be fixed
	 * so we can push them inside the domobject.
	 *
	 * @param DOMDocument $dom
	 * @param array $records
	 * @param array $hours
	 */
	public function fixTimeAndIntegrate($dom,$records,$hours) {
		if( count($records)>0 ) {
			//  With the properties we determine the format
			$props = $this->getProperties();
			$timefix = $props->time->interval->mode;

			foreach( $records as $row ) {
				$result = $this->fixTime($row['startTime'], $hours);
				//  This means tha time was fixed and we can place the event
				if( $result!=false ) {
					$eventLink = $this->glueElements($row);
					$parsedId = explode("-",$row['domId']);
					//  Send the new id
					if( isset($parsedId[3]) ) {
						$parsedId[3] = $result;
						$id = join('-', $parsedId);
						$xpath = new DOMXpath($dom);
						$positionInTable = $xpath->query("//*[@id='$id']");
						if( $positionInTable!==null ) {
							$positionInTable->item(0)->appendChild($dom->importNode($eventLink, true));
						} else {
							$this->log->notify($this, "Position not found");
						}
					}
				}
			}
		}
	}

	/**
	 * Here we create the representation of an element inside a link ,
	 * that is contained in a div.
	 * @param array $row
	 * @return DOMElement
	 */
	public function glueElements($row) {
		//  This block creates a an <a href='foo'>Bar</a> node
		$strClass = $row['allDayEvent']==1?'allday':'regular';
		$this->log->notify($this,"Setting class to $strClass");
		$id = "link-".$row['domId'];
		$source = "<span id=\"$id\" class=\"$strClass\">";
		$source .="<a href=\"".$this->getAction().$row['id']."\">".$row['title']."</a></span>";
		$this->log->notify($this, $source);
		$dom = new DOMDocument();
		$dom->strictErrorChecking = false;
		$dom->loadHTML($source);
		$xpath = new DOMXpath($dom);
		$element = $xpath->query("//*[@id='$id']");
		return $element->item(0);
	}

	public function __toString() {
		return "TableDaily";
	}
}
?>
