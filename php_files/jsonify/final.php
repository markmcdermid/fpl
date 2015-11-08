<?php 

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
include '../php_templates/connect.php';
$final = [];
function addHistory($row)  {
	include '../php_templates/connect.php';
	$id = $row['id'];
	$sql = "SELECT points FROM player_history where player_id=$id";
	include '../php_templates/query.php';
	while ($r = mysqli_fetch_array($result, MYSQLI_NUM)) {
		foreach ($r as $value) {
			$history[] = $value;
		}
		
	}
	$row['history'] =  $history;
	return $row;
}

for ($i=1; $i <=20 ; $i++) { 
	$whole = [];
	$sql = "SELECT id, web_name, total_points, type_name, now_cost, team_id from player where team_id = $i ORDER BY total_points desc ";
	$result = mysqli_query($connect, $sql);
	$rows = [];
	while($r = mysqli_fetch_assoc($result)) {
		#Typesetting	
		foreach(['id','total_points','team_id'] as $value) {
			settype($r[$value], "int");
		}
		$r['type_name'] = strtolower($r['type_name']); 
		$r['now_cost'] /=10;
		$rows[] = $r;
	}
	$j = 0;
	$gk = 0;
	$def = 0;
	$mid = 0;
	$att = 0;
	$gks = [];
	$defs = [];
	$mids = [];
	$atts = [];
//Make sure each position has the required number (To a total of 7 players).
	foreach ($rows as $rowKey => $playerRow) {

		foreach ($playerRow as $playerKey=>$playerInfo) {
			switch ($playerInfo) {
				case "goalkeeper":
				if ($gk<1) {
					/*$playerRow = addHistory($playerRow);*/
					$gks[] = $playerRow;
					unset($rows[$rowKey]);

					$j++;
					$gk++;
				} 
				break;
				case "defender":
				if ($def<3) {
					/*$playerRow = addHistory($playerRow);*/
					$defs[] = $playerRow;
					unset($rows[$rowKey]);
					$j++;
					$def++;
				}
				break;
				case "midfielder":
				if ($mid<3) {
					/*$playerRow = addHistory($playerRow);*/
					$mids[] = $playerRow;
					unset($rows[$rowKey]);
					$j++;
					$mid++;
				}
				break;
				case "forward":
				if ($att<1) {
					/*$playerRow = addHistory($playerRow);*/
					$atts [] = $playerRow;
					unset($rows[$rowKey]);
					$j++;
					$att++;
				}
				break;
				default:
			}
		}
	}

//Run the foreach again without the if statements.
	foreach ($rows as $rowKey => $playerRow) {
		foreach ($playerRow as $playerKey=>$playerInfo) {
			if ($j<11) {
				switch ($playerInfo) {

					case "goalkeeper":
					if ($gk<1) {
						/*$playerRow = addHistory($playerRow);*/
						$gks[] = $playerRow;
						unset($rows[$rowKey]);
						$j++;
						$gk++;
					} else {
						unset($rows[$rowKey]);
					}
					break;

					case "defender":
					if ($def<5) {
						/*$playerRow = addHistory($playerRow);*/
						$defs[] = $playerRow;
						unset($rows[$rowKey]);
						$j++;
						$def++;
					} else {
						unset($rows[$rowKey]);
					}
					break;

					case "midfielder":
					if ($mid<5) {
						/*$playerRow = addHistory($playerRow);*/
						$mids[] = $playerRow;
						unset($rows[$rowKey]);
						$j++;
						$mid++;
					} else {
						unset($rows[$rowKey]);
					}
					break;

					case "forward":
					if ($att<3) {
						/*$playerRow = addHistory($playerRow);*/
						$atts[] = $playerRow;
						unset($rows[$rowKey]);
						$j++;
						$att++;
					} else {
						unset($rows[$rowKey]);
					}
					break;

					default: break;
				}
			}
		}
	}



	$whole[] = $gks; $whole[]= $defs; $whole[]= $mids; $whole[]= $atts;
	$final[] = $whole;
}
$final = json_encode($final);
print_r($final);

$file = fopen('../../jsons/team/teams.json', 'w+');
fwrite ($file, $final);
fclose($file);
?>