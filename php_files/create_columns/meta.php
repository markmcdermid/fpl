<?php 

include 'php_templates/connect.php';
$rows = [];
for ($i=1; $i <= 38; $i++) { 

	$j = sprintf('%02d',$i);

	$sql1 = "SELECT
	`gameweek`,
	`date`

	from fixtures 
	where gameweek = 'Gameweek $j'
	order by date asc
	limit 1";
	$sql2 = "SELECT
	`date`,
	`gameweek`
	from fixtures 
	where gameweek = 'Gameweek $j'
	order by date desc
	limit 1";

	$result = mysqli_query($connect, $sql1);
	if (!$result) {
		printf("Errormessage: %s\n", mysqli_error($connect));
	};

	while($current = mysqli_fetch_array($result,MYSQLI_NUM)) {
		#current[1] is start hour current[2] is deadline.
		
		$date	 = $current[1];
		$newtime = strtotime($date . ' -1 hour');
		$newtime = date('Y-m-d H:i:s', $newtime);
		$current[2] = $newtime;
		$rows[]=$current;
	};

	$gameweek = "Gameweek ".$i;
	$sqlInput = "INSERT INTO `fpl`.`meta` (gameweek, start, deadline) VALUES ('$gameweek', '$date', '$newtime')";
	$result2 = mysqli_query($connect,$sqlInput);
	if (!$result2) {
		printf("Errormessage: %s\n", mysqli_error($connect));
	};

}

print_r($rows);
?>