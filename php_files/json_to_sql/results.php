<?php 
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
include 'php_templates/connect.php';
include 'php_templates/teamplayerarray.php';
//Include self made array teamsindex. e.g. 1 => Arsenal, Ars
include 'php_templates/teamsindex.php';

function get_time($timestamp) {
	$time = date("Y-m-d-a", $timestamp);
	return $time;
}
$today = date("U");
$time = get_time($today); 

# Week index starts at 0.
for ($week=0; $week <4; $week++) { 
	foreach ($teamPlayerArray as $teamPlayer) {

		$jsonArray = json_decode(file_get_contents("json/".$time."/".sprintf("%'.03d", $teamPlayer).'.json'),true); 

		$thisTeam = sprintf('%02d',$jsonArray ['team']);
		# fixturesArray is 
		$fixturesArray = $jsonArray ['fixture_history']['all'][$week];
		# $fixtureOpponent example ARS(A) 2-0
		$fixtureOpponent = $fixturesArray[2];
		# $fixtureOpponentShort example ARS
		$fixtureOpponentShort = substr($fixtureOpponent,0,3);
		# $homeOrAway example A
		$homeOrAway = substr($fixtureOpponent,-6,1);
		# $thisTeamScore example 2
		$thisTeamScore = substr($fixtureOpponent, -3,1);
		# $opponentScore example 0
		$opponentScore = substr($fixtureOpponent, -1,1);

		# Gets the team code (e.g. 01) from teamsIndex array.
		# And creates a home fixture and away fixture code from the information found.
		if ($homeOrAway === 'H') {
		foreach ($teamsIndex as $team => $teamName) {
			if ($teamName[1] === $fixtureOpponentShort) {
				$fixtureOpponentNum = $team;
				$homeFixtureCode = $thisTeam.$fixtureOpponentNum."H";
				$awayFixtureCode = $fixtureOpponentNum.$thisTeam."A";
				$sql = "INSERT INTO `fpl`.`team_results` (`home_fixture_id`, `away_fixture_id`, `home_score`, `away_score`) VALUES ('$homeFixtureCode', '$awayFixtureCode', '$thisTeamScore', '$opponentScore')";
				include 'php_templates/query.php';
			}
		}
	}
	}
}
?>
