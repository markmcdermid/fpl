<?php 
include '../php_templates/connect.php';
date_default_timezone_set('Europe/London');
$rows = [];
$difficulty = ['-5'=>'vvvh','-4'=> 'vvh','-3'=>'vh', '-2'=>'h', '-1'=>'qh', '0'=>'m', '1'=>'qe', '2'=>'e', '3'=>'ve', '4'=> 'vve', '5'=> 'vvve' ];
for ($i=1; $i <= 20; $i++) { 
	$sql = "SELECT t.short_name, o.short_name, gameweek, t.difficulty, o.difficulty, homeoraway FROM fixtures left join teams t on fixtures.team_id=t.id left join teams o on fixtures.opp_id=o.id where team_id=$i order by date";

	include '../php_templates/query.php';
	while($r = mysqli_fetch_array($result, MYSQLI_NUM)) {
		// Make gameweek a single integer value. 'Gameweek 01' => 1
		$r[2]=(int)substr($r[2], -2);
		$team = array_shift($r);
		if (array_pop($r)==='H') {
			$a = array_pop($r);
			$b = array_pop($r);
			$diff = $b - $a + 1;
			$r [] = $difficulty[$diff];
		} else {
			$r[0]=strtolower($r[0]);
			$a = array_pop($r);
			$b = array_pop($r);
			$diff = $b - $a - 1;
			$r [] = $difficulty[$diff];
 		}
		$rows[$team][] = $r;
	}
echo $i.' done<br/>';
}
print_r($rows);
$rows = json_encode($rows);
$file = fopen('../../jsons/fixturesall.json', 'w+');
fwrite ($file, $rows);
fclose($file);
?>