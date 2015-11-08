<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
	include '../php_templates/connect.php';
date_default_timezone_set("Europe/London");
function get_time($timestamp) {
	$time = date("Y-m-d-a", $timestamp);
	/*echo "On: ".$time;*/
	return $time;
}

function getFolderTitles() {
	include '../php_templates/connect.php';

	for ($i=1; $i<=38; $i++) {
		$sql = "SELECT json_date, start FROM fpl.meta where gameweek_id = '$i'";
		include '../php_templates/query.php';
		while ($r = mysqli_fetch_array($result, MYSQLI_NUM)) {
			$json_dates[$i]['json'] = $r[0];
			$json_dates[$i]['start'] = $r[1];
		}
	}
	foreach ($json_dates as $key => $value) {
		$start = $value['start'];
		$newDate = date("U", strtotime($start));
		$now = time();
		if ($newDate-$now < 0) {
			$folderTitles[$key] = $value['json'];
		}

	}
	array_shift($folderTitles);
	return $folderTitles;
}
function addToDatabase() {
	global $connect, $i, $id, $folderTitle, $jsonArray, $transfers_id;
	$headings = array("player_id", "web_name", "date", "selected_by_percent", "now_cost","transfers_out", "transfers_in", "transfers_out_event", "transfers_in_event", "net_transfers_event");
	$valuesString = '';
	$columnsString ='';
	foreach ($headings as $key => $column) {
		if ($column === "player_id") {
			$inputColumn = $column;
			$inputValue = $id;
		} else if ($column === "date"){
			$inputColumn = $column;
			$inputValue = $folderTitle;
		} else if ($column === "net_transfers_event") {
			$inputColumn = $column;
			$inputValue = $jsonArray['transfers_in_event']-$jsonArray['transfers_out_event'];
		} else {
			$inputColumn=$column;
			$inputValue=$jsonArray[$column];
		};
		$valuesString.='"'.$inputValue.'", ';
		$columnsString.=$inputColumn.",";
	};
	//Remove Commas
	$valuesString = rtrim($valuesString, ", ");
	$columnsString = rtrim($columnsString, ", ");
	$sql = "REPLACE INTO `fpl`.`player_transfers` (transfers_id, $columnsString) VALUES ($transfers_id, $valuesString)";
		//Actual Transfer Query
	include '../php_templates/query.php';
}

$folderTitles = getFolderTitles();
$length = count($folderTitles);
$error=0;
$dateMil = date("U");
$id = 1;

$transfers_id = 1;
while ($id < 700) {
	$i = 1;
	while ($i <= $length) {
		foreach ($folderTitles as $gwkKey => $folderTitle) {
			
			$jsonArray = json_decode(file_get_contents("../../json/".$folderTitle."/".sprintf("%'.03d", $id).'.json'),true);
			if ($jsonArray) {
				addToDatabase();
			} else {
				$error = 1;
			}
			$i++;
			$transfers_id++;
		}
	}
	$error = 0;
	$id++;
}
?>