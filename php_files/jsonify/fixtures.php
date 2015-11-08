<?php 
include '../php_templates/connect.php';
date_default_timezone_set('Europe/London');
if (!file_exists('../../jsons/fixtures')) {
	mkdir('../../jsons/fixtures', 0777, true);
}
 #Only doing once at the moment.
for ($i=1; $i <= 38; $i++) { 
	$rows = [];
	echo $j = sprintf('%02d',$i);
	echo $b = "Gameweek ".$j;

	$sql = "SELECT
	fixtures.`date`, #0
	t.`team_name`, #1
	o.`team_name`, #2
	t.`short_name`, #3
	o.`short_name`, #4
	t.id, #5
	o.id, #6
	t.difficulty, #7
	o.difficulty #8
	
	from fixtures 
	left join 
	teams t  
	on fixtures.`team_id`=t.`id`
	left join teams o 
	on fixtures.opp_id = o.id
	where 
	fixtures.team_id = t.`id` 
	and 
	fixtures.homeoraway = 'H' 
	and 
	fixtures.gameweek = '$b'
	order by
	fixtures.date,
	t.team_name asc";

	include '../php_templates/query.php';
	while($r = mysqli_fetch_array($result, MYSQLI_NUM)) {
		$time =  DateTime::createFromFormat('Y-m-d H:i:s',$r[0]);
		$r[0]= (date_format($time, 'U'))*1000;
		$r[5]= $r[5]-1;
		$r[6]= $r[6]-1;
		$rows[] = $r;
	}

	$rows = json_encode($rows);

	$file = fopen('../../jsons/fixtures/fixtures'.$j.'.json', 'w+');
	fwrite ($file, $rows);
	fclose($file);

}

?>