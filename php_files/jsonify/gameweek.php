<?php 
date_default_timezone_set('Europe/London');
include '../php_templates/connect.php';
$sql = "SELECT * FROM fpl.meta";
include '../php_templates/query.php';

while($r = mysqli_fetch_assoc($result)) {
	$time =  DateTime::createFromFormat('Y-m-d H:i:s',$r['start']);
	$r['start']= (date_format($time, 'U'))*1000;
	$rows[] = $r;
}
$rows = json_encode($rows);
echo $rows;


$file = fopen('../../jsons/gameweeks.json', 'w+');
fwrite($file,$rows);
fclose($file);


 ?>