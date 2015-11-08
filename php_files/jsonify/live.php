<?php 
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
include 'connect.php';
$newArray = [42899, 106760, 40002, 55909, 58877, 106824, 154976, 15208, 42774, 43670, 13017];
$subsArray = [2404, 160817, 18892, 20695, 43020, 59846, 101982];

$row = [];
foreach ($newArray as $value) {

	$sql = "SELECT id FROM `fpl`.`player` WHERE code=$value";
	$query = mysqli_query($connect, $sql);
		if (!mysqli_query($connect, $sql)) {
			printf("Errormessage: %s\n", mysqli_error($connect)."<br>");
		};

	$rowGet= mysqli_fetch_row($query);	
	$row []=$rowGet[0];
}

print_r($row);
$file_path = "jsons/live/".$date;
 if (!file_exists($file_path)) {
    mkdir($file_path, 0777, true);
}
$count = 1;
foreach ($row as $id) {
	usleep(500000);
	$content = file_get_contents('http://fantasy.premierleague.com/web/api/elements/'.$id.'/');
	if($content && $count <= 2) {
		echo $id.' worked<br>';
		file_put_contents($file_path."/".sprintf("%'.03d", $id).'.json',$content); //Puts json contents into a new file in a folder.
		$count = 1;
	} else if ($count < 2){
		//Try once more after 2 seconds.
		echo $id. " didn't work once<br>";
		usleep(500000);
		$count++;
	} else {
		//Fails after 2 tries.
		//Prints fail information to file with current date.
		$fail_file = 'error_logs/'.$date.'.txt';
		if (!file_exists($fail_file)) { //Makes fail file if it doesn't exist.
			fopen($fail_file, "w");
		}
		$current = file_get_contents($fail_file);
		$current.= $id.' failed twice.' ."\n";
    	file_put_contents($fail_file, $current);
		$count = 1; //Resets count for next id loop.
};
}
?>