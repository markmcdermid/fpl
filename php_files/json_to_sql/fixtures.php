<?php 
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
include '../php_templates/connect.php';
$teamPlayerArray = [1, 30, 55, 77, 102, 127, 152, 175, 205, 226, 252, 275, 298, 323, 353, 375, 395, 421, 445, 465];
foreach ($teamPlayerArray as $teamValue) {
	$jsonarray = json_decode(file_get_contents("../../json/2015-08-14-am/".sprintf('%03d',$teamValue).".json"),true);
	$teamarray = ["Arsenal", "Aston Villa", "Bournemouth", "Chelsea", "Crystal Palace", "Everton", "Leicester", "Liverpool", "Man City", "Man Utd", "Newcastle", "Norwich", "Southampton", "Spurs", "Stoke", "Sunderland", "Swansea", "Watford", "West Brom", "West Ham"];
	$thisYear = 2015;
	$nextYear = 2016;
	$monthArray = ["Jul" => $thisYear, "Aug" => $thisYear, "Sep" => $thisYear, "Oct" => $thisYear, "Nov" => $thisYear, "Dec" => $thisYear, "Jan" => $nextYear, "Feb" => $nextYear, "Mar" => $nextYear, "Apr" => $nextYear, "May" => $nextYear];

//Gets team from each 
	$thisTeam = sprintf('%02d',$jsonarray['team']);
//Gets fixtures from array.
	$fixturesarray = $jsonarray['fixtures']['all'];
	foreach ($fixturesarray as $key => $value) {

		$dateString = $value[0];
		$myDateTime = DateTime::createFromFormat('d M H:i', $dateString);
		$myDay = $myDateTime->format('d H:i');
		$myTime = $myDateTime->format('H:i');
		$newDateString = $myDateTime->format('M');
		$year = $monthArray[$newDateString];
		$fullDateString = $year."-".$newDateString."-".$myDay;
		$nearlyDate = DateTime::createFromFormat('Y-M-d H:i', $fullDateString);
		$finishedDate = $nearlyDate->format('Y-m-d-H:i');
		# Add leading zero to gameweek.
		$gameweek = ltrim($value[1],'Gameweek ');
		$gameweek = sprintf('%02d',$gameweek);
		echo $gameweek = "Gameweek ".$gameweek;
		$opponent = $value[2];
		$oppName = substr($opponent, 0, -4);
		$homeOrAway = substr($opponent, -2, 1);

		foreach ($teamarray as $tkey => $tvalue) {
			if ($tvalue === $oppName) {
				$tkey++;
				$tkey = sprintf("%02d",$tkey);
				echo /*$thisTeam.$tkey.$homeOrAway." ".$thisTeam." ".$tkey." ".$finishedDate." ".$gameweek." ".$homeOrAway.*/"<br>";
				$this_fixture_id = $thisTeam.$tkey.$homeOrAway;
				$sql = "REPLACE INTO `fpl`.`fixtures` (`fixture_id`, `team_id`, `opp_id`, `date`, `gameweek`, `homeoraway`) VALUES ('$this_fixture_id', '$thisTeam', '$tkey', '$finishedDate', '$gameweek', '$homeOrAway')";
			//Actual Transfer Query
				include '../php_templates/query.php';
			}
		}
	}
}
?>