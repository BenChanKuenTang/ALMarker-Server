<?php
	$year = '2018';
	$url = "https://www.gov.hk/en/about/abouthk/holiday/$year.htm";

	$html = file_get_contents($url);
	$dom = new DOMDocument;
	@$dom->loadHTML($html);

	$xpath = new DOMXpath($dom);
	$allDesc = $xpath->query('//td[@class = "desc"]');
	$allDate = $xpath->query('//td[@class = "date"]');
	$allWeekday = $xpath->query('//td[@class = "weekday"]');

	$holidays = array();

	for ($i = 0;$i < count($allDesc);$i++) {
		if ($i == 0) continue;

		$desc = $allDesc[$i]->textContent;
		$date = $allDate[$i]->textContent;
		$date = preg_replace("/\s|&nbsp;/",' ',htmlentities($date));
		$time = strtotime("$date $year");
		$formattedDate = date('d-m-Y', $time);
		$weekday = $allWeekday[$i]->textContent;

		$holidayObj = array(
			'desc' => $desc,
			'date' => $formattedDate,
			'weekday' => $weekday
		);
		array_push($holidays, $holidayObj);
	}

	$everySunday = getDateForSpecificDayBetweenDates("$year-01-01", "$year-12-31", 0);
	foreach ($everySunday as $sunday) {
		$sundayObj = array(
			'desc' => 'Public Holiday',
			'date' => $sunday,
			'weekday' => 'Sunday'
		);
		array_push($holidays, $sundayObj);
	}

	echo json_encode($holidays);

	function getDateForSpecificDayBetweenDates($startDate, $endDate, $weekdayNumber) {
	    $startDate = strtotime($startDate);
	    $endDate = strtotime($endDate);

	    $dateArray = array();

	    do {
	        if(date("w", $startDate) != $weekdayNumber) {
	            $startDate += (24 * 3600); // add 1 day
	        }
	    } while(date("w", $startDate) != $weekdayNumber);


	    while($startDate <= $endDate) {
	        $dateArray[] = date('d-m-Y', $startDate);
	        $startDate += (7 * 24 * 3600); // add 7 days
	    }

	    return($dateArray);
	}

?>