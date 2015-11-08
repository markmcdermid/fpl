<?php 

include 'php_templates/connect.php';
include 'php_templates/teamsindex.php';

foreach ($teamsIndex as $arrayKey => $array) {
	echo $arrayKey;
	$team_name = $array[0];
	$short_name = $array[1];
		$sql = "INSERT INTO fpl.teams (id, team_name, short_name) VALUES ('$arrayKey', '$team_name', '$short_name')";

		include 'php_templates/query.php';
	echo "<br>";
};

 ?>