<?php 
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

function buildFixCode($connect, $team, $fixOpp) {
	//Builds fix code like 0120H
	$homeOrAway = substr($fixOpp, -6,1);
	$oppName = substr($fixOpp, 0, 3);
	$sql = "SELECT id FROM teams where short_name = '$oppName'";
	include '../php_templates/query.php';
	$array = mysqli_fetch_array($result);
	$oppId = $array[0];
	return $fixtureId = $team.$oppId.$homeOrAway;
};

include '../php_templates/connect.php';

$last_download = file_get_contents("../latest_path.txt");
$sql = "TRUNCATE `fpl`.`player_history`";
include '../php_templates/query.php';
$keyArray = ["player_id", "fixture_id", "date", "round", "opponent", "minutes_played", "goals_scored", "assists", "clean_sheets", "goals_conceded", "own_goals", "penalties_saved", "penalties_missed", "yellow_cards", "red_cards", "saves", "bonus_points", "ESP", "bonus_points_score", "net_transfers", "value", "points"];
$columns = "";
foreach ($keyArray as $value) {
	$key = "`".$value."`, ";
	$columns .= $key;
}

$columns = rtrim($columns,', ');

$id = 1;
$endid = 640;	
$thisId=1;
while ($id <= $endid) {
	$jsonArray = json_decode(file_get_contents($last_download.sprintf("%'.03d", $id).'.json'),true);

	$fixture_history = $jsonArray['fixture_history']['all'];

	foreach ($fixture_history as $fixture) {
		$fixOpp = $fixture[2];
		$id = $jsonArray['id'];

		#Get team id and add a leading zero.
		$team = $jsonArray['team'];
		$team = sprintf('%02d',$team);
		#Builds a fixture code dependent on player numbers.
		$fixCode = buildFixCode($connect, $team, $fixOpp);
		#Adds code and player id to the array	
		array_unshift($fixture, $id, $fixCode);
			$valueString = "";
		foreach ($fixture as $fixKey => $fixValue) {
	
			$colName = $keyArray[$fixKey];
			$dataBaseValue = "'".$fixValue."',  ";
			$valueString.= $dataBaseValue;
			
		}

		echo $valueString = rtrim($valueString,", ");
		$sql = "INSERT INTO `fpl`.`player_history` ($columns) VALUES ($valueString)";
		include '../php_templates/query.php';
		echo "<br>";
	}
	
	echo "<br>";
	$id++;
}
echo "<br>".'finished';

?>