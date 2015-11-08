<?php 

include 'php_templates/connect.php';

/*function printNotArray() {
	$myarray = json_decode(file_get_contents('assets/rooney.json'));
$myarray = json_decode(json_encode($myarray),true);
	foreach ($myarray as $key => $value) {
		if (is_array($value)) {
		} else {
			echo "<li>".$key."</li>";
		}
	}
};



	echo "<ul>";
	printNotArray();
	echo "</ul>";


*/

// Selects and echos from SQL Database
/*	 $sql = "SELECT web_name FROM `fpl`.`player`";
	 $result = mysqli_query($connect, $sql);
	 if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        echo "id: " . $row["id"]. " - Name: " . $row["web_name"]. "<br>";
    }
} else {
    echo "0 results";
}*/



/*
$sql = "INSERT INTO `fpl`.`player` (`id`, `player_name`) VALUES ('5', 'Kevin')";
mysqli_query($connect, $sql);*/

$keyArray = array("photo" => "TEXT", "web_name" => "TEXT", "event_total" => "INT", "type_name" => "TEXT", "team_name" => "TEXT", "selected_by" => "DECIMAL(11,1)", "total_points" => "INT", "current_fixture" => "TEXT", "next_fixture" => "TEXT", "team_code" => "INT", "news" => "TEXT", "team_id" => "INT", "status" => "TEXT", "code" => "INT", "first_name" => "TEXT", "second_name" => "TEXT", "now_cost" => "INT", "chance_of_playing_this_round" => "INT", "chance_of_playing_next_round" => "INT", "value_form" => "DECIMAL(11,1)", "value_season" => "DECIMAL(11,1)", "cost_change_start" => "INT", "cost_change_event" => "INT", "cost_change_start_fall" => "INT", "cost_change_event_fall" => "INT", "in_dreamteam" => "BOOLEAN", "dreamteam_count" => "INT", "selected_by_percent" => "DECIMAL(11,1)", "form" => "DECIMAL(11,1)", "transfers_out" => "INT", "transfers_in" => "INT", "transfers_out_event" => "INT", "transfers_in_event" => "INT", "loans_in" => "INT", "loans_out" => "INT", "loaned_in" => "INT", "loaned_out" => "INT", "event_points" => "INT", "points_per_game" => "DECIMAL(11,1)", "ep_this" => "DECIMAL(11,1)", "ep_next" => "DECIMAL(11,1)", "special" => "BOOLEAN", "minutes" => "INT", "goals_scored" => "INT", "assists" => "INT", "clean_sheets" => "INT", "goals_conceded" => "INT", "own_goals" => "INT", "penalties_saved" => "INT", "penalties_missed" => "INT", "yellow_cards" => "INT", "red_cards" => "INT", "saves" => "INT", "bonus" => "INT", "ea_index" => "INT", "bps" => "INT", "element_type" => "INT", "team" => "INT");
$key2 = 'id';
foreach ($keyArray as $key => $value) {
$sql = "ALTER TABLE `player` ADD `$key` $value NOT NULL AFTER `$key2`";
$sqlDROP = "ALTER TABLE `player` DROP `$key`";
echo $value;
include 'php_templates/query.php';
$key2 = $key;
}

?>