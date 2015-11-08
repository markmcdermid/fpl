<?php 
$fuckArray = [[10,14,"2015-08-08 12:45:00"],[3,2,"2015-08-08 15:00:00"],[6,18,"2015-08-08 15:00:00"],[7,16,"2015-08-08 15:00:00"],[12,5,"2015-08-08 15:00:00"],[4,17,"2015-08-08 17:30:00"],[1,20,"2015-08-09 13:30:00"],[11,13,"2015-08-09 13:30:00"],[15,8,"2015-08-09 16:00:00"],[19,9,"2015-08-10 20:00:00"]];
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
include 'connect.php';
foreach ($fuckArray as $key => $value) {
	$hT = sprintf('%02d',$value[0]);
	$aT = sprintf('%02d',$value[1]);
	$date = $value[2];
	$this_fixture_id = $hT.$aT."H";
	$sql = "REPLACE INTO `fpl`.`fixtures` (`fixture_id`, `team_id`, `opp_id`, `date`, `gameweek`, `homeoraway`) VALUES ('$this_fixture_id', '$hT', '$aT', '$date', 'Gameweek 1', 'H')";
			//Actual Transfer Query
	mysqli_query($connect, $sql);
	if (!mysqli_query($connect, $sql)) {
		printf("Errormessage: %s\n", mysqli_error($connect));
	};
}
?>