<?php 
 include 'php_templates/connect.php';
 $rows = [];
for ($i=1; $i < 4; $i++) { 
	$b = "Gameweek ".sprintf('%02d',$i);

$sql = "SELECT
	fixtures.`date`,
	t.`team_name`,
	o.`team_name`,
	tr.`home_score`,
	tr.`away_score`
	
from fixtures 
left join 
	teams t  
	on fixtures.`team_id`=t.`team_id`
left join teams o 
	on fixtures.opp_id = o.team_id
left join team_results tr
	on fixtures.`fixture_id` = tr.`home_fixture_id` 
where 
fixtures.team_id = t.`team_id` 
and 
fixtures.homeoraway = 'H' 
and 
fixtures.gameweek = '$b'
order by
 fixtures.date,
 t.team_name asc";

 include 'php_templates/query.php';
 while($r = mysqli_fetch_array($result, MYSQLI_NUM)) {
	$rows[] = $r;
}

}
$rows = json_encode($rows);
print_r($rows);
$file = fopen('jsons/team/results.json', 'w+');
fwrite ($file, $rows);
fclose($file);
 ?>