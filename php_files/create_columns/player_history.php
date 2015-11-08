<?php  
include 'php_templates/connect.php';
$keyArray = ["player_id" => "int", "fixture_id"=>"varchar", "date" => "datetime", "round" => "int", "opponent" => "text", "minutes_played" => "int", "goals_scored" => "int", "assists" => "int", "clean_sheets" => "int", "goals_conceded" => "int", "own_goals" => "int", "penalties_saved" => "int", "penalties_missed" => "int", "yellow_cards" => "int", "red_cards" => "int", "saves" => "int", "bonus_points" => "int", "ESP" => "int", "bonus_points_score" => "int", "net_transfers" => "int", "value" => "decimal", "points" => "int"];
$key2 = 'id';
foreach ($keyArray as $key => $value) {
$sql = "ALTER TABLE `player_history` ADD `$key` $value NOT NULL AFTER `$key2`";
$sqlDROP = "ALTER TABLE `player` DROP `$key`";
echo $value;
include 'php_templates/query.php';
$key2 = $key;
}




?>