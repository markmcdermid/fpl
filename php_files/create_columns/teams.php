<?php 

include 'php_templates/connect.php';

$keyArray = [
"team_name" => "TEXT",
"short_name" => "VARCHAR (3)",
"difficulty" => "DECIMAL (11,1)",
"home_form" => "DECIMAL (11,1)",
 "away_form" => "DECIMAL (11,1)",
 "current_form" => "DECIMAL (11,1)"];
$key2 = 'id';
foreach ($keyArray as $key => $value) {
$sql = "ALTER TABLE `teams` ADD `$key` $value AFTER `$key2`";
$sqlDROP = "ALTER TABLE `player` DROP `$key`";
echo $value;
include 'php_templates/query.php';
$key2 = $key;
}

?>