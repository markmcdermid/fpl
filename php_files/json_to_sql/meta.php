<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
date_default_timezone_set("Europe/London");
function gameweekTime() {
	include '../php_templates/connect.php';

	$sql = "SELECT start FROM fpl.meta";

	include '../php_templates/query.php';

	while($r = mysqli_fetch_array($result, MYSQLI_NUM)) {
		$rows[] = $r;
		
	}
	foreach ($rows as $row) {
		foreach ($row as $value) {
			$valueTime = strtotime($value) - (3600*12);
			$newDate = date("Y-m-d-a", $valueTime);
			echo $newDate."<br>";
			$sql = "UPDATE fpl.meta SET `json_date` = '$newDate' where `start`='$value' ";
			include '../php_templates/query.php';
		}
	}
}
gameweekTime();
?>