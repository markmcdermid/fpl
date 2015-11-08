<?php 
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

include '../php_templates/connect.php';
$last_download = file_get_contents("../latest_path.txt");

$headings = "`id`, `photo`, `web_name`, `event_total`, `type_name`, `team_name`, `selected_by`, `total_points`, `current_fixture`, `next_fixture`, `team_code`, `news`, `team_id`, `status`, `code`, `first_name`, `second_name`, `now_cost`, `chance_of_playing_this_round`, `chance_of_playing_next_round`, `value_form`, `value_season`, `cost_change_start`, `cost_change_event`, `cost_change_start_fall`, `cost_change_event_fall`, `in_dreamteam`, `dreamteam_count`, `selected_by_percent`, `form`, `transfers_out`, `transfers_in`, `transfers_out_event`, `transfers_in_event`, `loans_in`, `loans_out`, `loaned_in`, `loaned_out`, `event_points`, `points_per_game`, `ep_this`, `ep_next`, `special`, `minutes`, `goals_scored`, `assists`, `clean_sheets`, `goals_conceded`, `own_goals`, `penalties_saved`, `penalties_missed`, `yellow_cards`, `red_cards`, `saves`, `bonus`, `ea_index`, `bps`, `element_type`, `team`";
$id = 1;
$endid = 640;
while ($id <= $endid) {
	$myarray = json_decode(file_get_contents($last_download.sprintf("%'.03d", $id).'.json'));
	$myarray = json_decode(json_encode($myarray),true);
	$valueString = "";
	foreach ($myarray as $key => $value) {
		if (is_array($value)) {
		} else {
			$valueString .='"'.$value.'", ';
		}
	}
	echo $myarray['web_name'];
	echo $myarray['first_name'];
	echo $myarray['second_name'];
	$valueString = rtrim($valueString, ", "); //Remove Comma
	$sql = "REPLACE INTO `fpl`.`player` ($headings) VALUES ($valueString)";
	include '../php_templates/query.php';
	$id++;
}

echo 'complete';
echo $headings."<br><br>";
echo $valueString;

?>