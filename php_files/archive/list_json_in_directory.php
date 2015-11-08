<?php 
$id = 1;
$last_download = "../".file_get_contents("../latest_path.txt");
echo $last_download."<br>";

// List of players and IDs with teams.
while ($id <= 600) {
	//Gets json from file.
	$mytest = json_decode(file_get_contents($last_download.sprintf("%'.03d", $id).'.json'));

	$mytest = json_decode(json_encode($mytest),true);
	// Makes json an array.
	echo $mytest["id"]." : ".$mytest['web_name']." : ".$mytest['team_name']."<br>";
	$id++;
}
 ?>