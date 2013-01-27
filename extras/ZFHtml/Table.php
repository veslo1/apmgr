<?php
/**
 * Concrete implementation of a table that acts as a container
 *
 * @author jvazquez <jvazquez@debserverp4.com.ar>
 */
class ZFHtml_Table extends ZFDate_Abstract_DateUtils implements ZFHtml_Interface_HtmlInterface {

	/**
	 * Create the structure
	 * @param array $options
	 */
	public function __construct(array $options=null) {
		$this->setProperties();
		$this->setMonthNames();
		$this->setDayNames();
		$this->setStartDay();
		$this->setStartMonth();

		if(!isset($options['month'])) {
			$options['month'] = date('n');
		}

		if(!isset($options['year'])) {
			$options['year'] = date('Y');
		}

		if( isset($options['action']) ) {
			$this->setAction($options['action']);
		}
		$this->setMonth($options['month']);
		$this->setYear( $options['year']);
		$this->setDaysInMonth();
	}

	/**
	 * Generate the calendar
	 * @return string
	 */
	public function yield() {
		$s = "";
		$properties = $this->getProperties();

		$a = $this->adjustDate();
		$month = $a[0];
		$year = $a[1];

		$daysInMonth = $this->getDaysInMonth();
		$date = getdate(mktime(12, 0, 0, $month, 1, $year));

		$first = $date["wday"];
		$monthnames = $this->getMonthNames();
		$monthName = $monthnames[$month];

		$prev = $this->adjustDate($month - 1, $year);
		$next = $this->adjustDate($month + 1, $year);
		$prevMonth = "";
		$nextMonth = "";

		if ( $properties->calendar->showyear ) {
			$prevMonth = $this->getCalendarLink($prev[0], $prev[1],$this->action);
			$nextMonth = $this->getCalendarLink($next[0], $next[1],$this->action);
		}

		$header = $monthName . (($properties->calendar->showyear ) ? " " . $year : "");
		$daynames = $this->getDayNames();
		$startDay = $this->getStartDay();
		$s .= "<table id=\"rounded-corner\">";
		$s .= "<thead><tr>";
		$s .= "<th class=\"rounded-calendar\">" . (($prevMonth == "") ? "&nbsp;" : "<a class=\"highlight\" href=\"$prevMonth\">&lt;&lt;</a>")  . "</th>";
		$s .= "<th colspan=\"5\"><p class=\"monthtitle\">$header</p></th>";
		$s .= "<th class=\"rounded-q4\">" . (($nextMonth == "") ? "&nbsp;" : "<a class=\"highlight\" href=\"$nextMonth\">&gt;&gt;</a>")  . "</th>";
		$s .= "</tr></thead>";

		$s .= "<tr><tbody>";
		$s .= "<td>" . $daynames[($startDay)%7] . "</td>";
		$s .= "<td>" . $daynames[($startDay+1)%7] . "</td>";
		$s .= "<td>" . $daynames[($startDay+2)%7] . "</td>";
		$s .= "<td>" . $daynames[($startDay+3)%7] . "</td>";
		$s .= "<td>" . $daynames[($startDay+4)%7] . "</td>";
		$s .= "<td>" . $daynames[($startDay+5)%7] . "</td>";
		$s .= "<td>" . $daynames[($startDay+6)%7] . "</td>";
		$s .= "</tr>";

		// We need to work out what date to start at so that the first appears in the correct column
		$d = $startDay + 1 - $first;
		while ( $d > 1 ) {
			$d -= 7;
		}

		// Make sure we know when today is, so that we can use a different CSS style
		$today = getdate(time());

		while ($d <= $daysInMonth) {
			$s .= "<tr>";

			for ($i = 0; $i < 7; $i++) {
				$class = ($year == $today["year"] && $month == $today["mon"] && $d == $today["mday"]) ? "calendarToday" : "calendarRow";
				$s .= "<td align=\"right\" >";
				if ($d > 0 && $d <= $daysInMonth) {
					$link = $this->getDateLink($d, $month, $year);
					$s .= (($link == "") ? $d : "<span><a href=\"$link\">$d</a></span>");
				} else {
					$s .= "&nbsp;";
				}
				$s .= "</td>";
				$d++;
			}
			$s .= "</tbody></tr>";
		}

		$s .= "</table>";

		return $s;
	}

	public function fetchEvents($days) {

	}

	public function forgeHtml($source) {}

	public function glueElements($recordset){}

	public function fixTimeAndIntegrate($dom,$records,$constrains){}
}
?>