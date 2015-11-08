<?php 
include 'connect.php';
include 'errors.php';
include 'firebase.php';
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

function getTypeId ($typeName) {
	switch ($typeName) {
		case 'Goalkeeper':
		return '1g';
		case 'Defender':
		return '2d';
		case 'Midfielder':
		return '3m';
		case 'Forward':
		return '4f';
		default: 
		echo 'Switch Broken';
		break;
	}
}

$doc = new DOMDocument();
$doc->loadHTMLFile("http://www.premierleague.com/en-gb/matchday/matches/2015-2016/epl.teams.html/sunderland-vs-newcastle");		
$trs = $doc->getElementsByTagName('table');
if (count($trs)) {
	foreach ( $trs as $div ) {

		if ($result=$div->getAttribute('formation')) {
			preg_match_all("/([\d])+/", $result,$matches);
			$lineups [] = $matches[0];
		}
	}
}
foreach ($lineups as $teamKey => $teamLineup) {
	foreach ($teamLineup as $playerKey => $player) {
		$sql = "SELECT id,web_name FROM `fpl`.`player` where code='$player'";
		include 'query.php';
		while ($r = mysqli_fetch_array($result, MYSQLI_NUM)) {
			$whole[$teamKey][] = $r[0];
		}
	}
}

foreach ($whole as $key => $innerArray) {
	foreach ($innerArray as $playerId) {
		$content = json_decode(file_get_contents('http://fantasy.premierleague.com/web/api/elements/'.sprintf("%'.03d", $playerId).'/'),true);
		$fixtureArray = array_pop($content['fixture_history']['all']);
		$playerArray[$playerId]['web_name'] = $content['web_name'];
		$playerArray[$playerId]['points'] = $fixtureArray[19];
		$playerArray[$playerId]['bps'] = $fixtureArray[16];
		$playerArray[$playerId]['bps'] = $fixtureArray[16];
		$playerArray[$playerId]['team_id'] = $content ['team_id'];
		$playerArray[$playerId]['type_name'] = $content ['type_name'];
		$bonusArray [$playerId] = $fixtureArray[16];

		if ($fixtureArray[4] > 0) {
			$playerArray[$playerId]['goals'] = $fixtureArray[4];
			$playerArray[$playerId]['hasInfo'] = 1;

		}
		if ($fixtureArray[5] > 0) {
			$playerArray[$playerId]['assists'] = $fixtureArray[5];
			$playerArray[$playerId]['hasInfo'] = 1;
		}
		if ($fixtureArray[6] === 1) {
			if ($content['type_name'] === 'Goalkeeper' || $content['type_name'] === 'Defender' || $content['type_name'] === 'Midfielder') {
				$playerArray[$playerId]['clean_sheet'] = $fixtureArray[6];
				$playerArray[$playerId]['hasInfo'] = 1;
			}
		}
		if ($fixtureArray[8] > 0) {
			$playerArray[$playerId]['ownGoals'] = $fixtureArray[8];
			$playerArray[$playerId]['hasInfo'] = 1;
		}
		if ($fixtureArray[11] > 0) {
			$playerArray[$playerId]['yc'] = $fixtureArray[11];
		}
		if ($fixtureArray[12] > 0) {
			$playerArray[$playerId]['rc'] = $fixtureArray[12];
		}
		if ($fixtureArray[13] > 0) {
			$playerArray[$playerId]['saves'] = $fixtureArray[13];
			$playerArray[$playerId]['hasInfo'] = 1;
		}
	}
}

arsort($bonusArray);
print_r($bonusArray);
$keys = array_keys($bonusArray);
$bps = 3;

for ($i=0; $i<count($keys); $i++) {
	if ($bps > 0) {

		$cur = $bonusArray[$keys[$i]];
		$next = $bonusArray[$keys[$i+1]];

		if ($cur===$next) {
			$bonus [$bps][$keys[$i]] = $bonusArray[$keys[$i]];
		} else {
			$bonus [$bps][$keys[$i]] = $bonusArray[$keys[$i]];
			$bps--;
		}
	}

}

print_r($bonus);

foreach ($bonus as $bonusKey => $array) {
	foreach ($array as $playerId => $bps) {
		$playerArray [$playerId]['bonus_points'] = $bonusKey;
	}
}

foreach ($playerArray as $playerId => $player) {
	$teamId = $player['team_id'];
	$typeName = $player['type_name'];
	$typeId = getTypeId($typeName); 
	$finalArray[$teamId][$typeId][] = $player;
}
print_r($finalArray);

$firebase->set(DEFAULT_PATH, $finalArray);
?>
