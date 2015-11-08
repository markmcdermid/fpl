<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
include 'connect.php';
$headings = array("player_id", "web_name", "date", "selected_by_percent", "now_cost","transfers_out", "transfers_in", "transfers_out_event", "transfers_in_event");
date_default_timezone_set("Europe/London");
$date = date("Y-m-d-a");
$dateMil = date("U");
function get_time($timestamp) {
	$time = date("Y-m-d-a", $timestamp);
	echo "On: ".$time;
	return $time;
}
$id = 1;
$endid = 570;
$inputArray = [];
$numberOf = 16;
while ($id <= $endid) {
	for ($i=0; $i < $numberOf; $i++) {
	$time = get_time($dateMil-3600*12*$i);
	$jsonarray = json_decode(file_get_contents("json/".$time."/".sprintf("%'.03d", $id).'.json'),true);
	$valuesString = '';
	$columnsString ='';
	foreach ($headings as $key => $column) {
		if ($column === "player_id") {
			$inputColumn = "player_id";
			$inputValue = $id;
		} else if ($column === "date"){
			$inputColumn = "date";
			$inputValue = $time;
		} else {
			$inputColumn=$column;
			$inputValue=$jsonarray[$column];
		};
		echo $inputColumn.": ";
		echo $inputValue."<br>";
		$valuesString.="'".$inputValue."', ";
		$columnsString.=$inputColumn.",";
	};
	//Remove Comma
	$valuesString = rtrim($valuesString, ", ");
	//Remove Comma
	$columnsString = rtrim($columnsString, ", ");
		$transfers_id = ($id-1)*$numberOf + $i;
		echo $transfers_id."<br>";
		$sql = "REPLACE INTO `fpl`.`player_transfers` (transfers_id, $columnsString) VALUES ($transfers_id, $valuesString)";
		//Actual Transfer Query
		include 'php_templates/query.php';
		
	};
	$id++;
};
?>