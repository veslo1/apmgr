<?php
/**
 * Provides the Html for week elements
 *
 * @author jvazquez
 */
class ZFHtml_WeekTable extends ZFDate_Abstract_DateUtils implements ZFHtml_Interface_HtmlInterface,ZFObserver_ILogeable {

	/**
	 * The userId we are fetching info
	 * @var integer
	 */
	protected $userId;

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
		$this->log = new ZFObserver_Forensic();
		$this->log->attach(new ZFObserver_Observers_Text());
		$level = !isset($options['level']) ? ZFObserver_ILogeable :: DEBUG:$options['level'];
		$this->log->setStatus($level);

		$this->setProperties();

		if( isset($options['action']) ) {
			$this->setAction($options['action']);
		} else {
			$this->setAction('calendar/view/viewevent/id/');
		}

		if( isset($options['userid']) ) {
			$this->userId = (int)$options['userid'];
		}

	}

	/**
	 * Return the days of the week depending on user configuration
	 * @return string
	 */
	public function yield() {
		$days = $this->fetchWeekDays();
		$hours = $this->yieldIntervalHours();
		$firstDate = $days[0]->toString('Y-m-d');
		$data = array('days'=>$days,'hours'=>$hours);
		$source = $this->forgeHtml($data);

		$dom = new DOMDocument();
		$dom->loadHTML($source);
		$this->log->notify($this,"Inside yield, calling fetchEvents");
		$events = $this->fetchEvents(array($firstDate));
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

		//  Fetch properties
		$props = $this->getProperties();
		$period = $props->calendar->week->long;
		//  Fetch the ones I'm a owner
		$owner = $cEvents->fetchEventsForWeek( $date[0], $period, $this->userId);
		//  And fetch the ones I'm a guest
		$guest = $cEvents->fetchEventsForWeekGuest( $date[0], $period, $this->userId);
		$result = array_merge($owner, $guest);
		return $result;
	}

	/**
	 * Generate the string that we will feed in a DOMDocument object
	 * @param array $data
	 * @return string
	 */
	public function forgeHtml($source) {
		$days = $source['days'];
		$hours = $source['hours'];

		$props = $this->getProperties();
		$format = $props->calendar->week->view;
		$idDom = $props->date->id->dom;
		$s = "<table id=\"rounded-corner\"><thead><tr><th class=\"rounded-calendar\"></th>";
		$count = count($days)-1;
		foreach( $days as $id=>$dteObject ) {
			if($id==$count) {
				$s .="<th class=\"rounded-q4\">".$dteObject->toString($format)."</th>";
			} else {
				$s .="<th>".$dteObject->toString($format)."</th>";
			}
		}
		$s .="</tr></thead><tbody>";

		$cells = count($days)-1;

		foreach($hours as $index=>$hour) {
			$s .="<tr><td>{$hour}</td>";
			foreach( $days as $id=>$dteObject ) {
				$s .="<td id=\"".$dteObject->toString($idDom)."$hour\"></td>";
			}
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
			$this->log->notify($this,'Inside fixTimeAndIntegrate');
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
						$element = $positionInTable->item(0);
						if( !empty($element) ) {
							$element->appendChild($dom->importNode($eventLink, true));
						} else {
							$this->log->notify($this, "THe position was not found");
						}
					}
				}
			}
		} else {
			$this->log->notify($this,"Not records for this week");
		}
	}

	/**
	 * Here we create the representation of an element inside a link ,
	 * that is contained in a div.
	 * @param array $row
	 * @return DOMElement
	 */
	public function glueElements($row) {
		$strClass = $row['allDayEvent']==1?'allday':'regular';
		$this->log->notify($this,"Setting class to $strClass");
		$id = "link-".$row['domId'];
		$source = "<span id=\"$id\" class=\"$strClass\">";
		$source .='<a href="'.$this->getAction().$row['id'].'">'.$row['title'].'</a></span>';
		$this->log->notify($this, $source);
		$dom = new DOMDocument();
		$dom->strictErrorChecking = false;
		$dom->loadHTML($source);
		$xpath = new DOMXpath($dom);
		$element = $xpath->query("//*[@id='$id']");
		return $element->item(0);
	}

	public function __toString() {
		return "WeekTable";
	}
}
?>