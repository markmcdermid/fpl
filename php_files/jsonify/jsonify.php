<?php 

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
include 'php_templates/connect.php';
$whole = [];
for ($i=1; $i <= 20; $i++) { 
	# code...

$sql = "SELECT web_name, total_points, team, type_name, team_name, now_cost FROM `fpl`.`player` WHERE team=$i ORDER BY total_points DESC, type_name DESC LIMIT 11 ";
$sth = mysqli_query($connect, $sql);
$rows = [];

while($r = mysqli_fetch_assoc($sth)) {
	$rows[] = $r;
}

foreach ($rows as $key1 => $value1) {

foreach ($rows[$key1] as $key2 => $value2) {
	switch ($value2) {
		case "Goalkeeper":
			$rows[$key1][$key2]=0;
			break;
		case "Defender":
			$rows[$key1][$key2]=1;
			break;
		case "Midfielder":
			$rows[$key1][$key2]=2;
			break;
		case "Forward":
			$rows[$key1][$key2]=3;
			break;
		default:
			echo '';
	}
}
}

$whole[] = $rows;
}

$whole = json_encode($whole);
print_r($whole);
$file = fopen('jsons/team/teams.json', 'w+');
fwrite ($file, $whole);
fclose($file);
?>