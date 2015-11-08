<?php 
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
$count = 1; //For trying more than once.
$failCount = 0; //For stopping when it fails in a row.
$id = 1; // Start id.
$endid = 800; //End id.
//Sets date 2015-01-01-am and puts it in a variable.
date_default_timezone_set("Europe/London");
$date = date("Y-m-d-a");
$file_path = "../json/".$date;
if (!file_exists($file_path)) {
	mkdir($file_path, 0777, true);
}
while ($id <= $endid) {
	usleep(500000);
	$content = file_get_contents('http://fantasy.premierleague.com/web/api/elements/'.$id.'/');
	if($content && $count <= 2) {
		echo $id.' worked<br>';
		file_put_contents($file_path."/".sprintf("%'.03d", $id).'.json',$content); //Puts json contents into a new file in a folder.
		$count = 1;
		$failCount = 0; //Make it 0 every time.
		$id++;
	} else if ($count < 2){
		//Try once more after 2 seconds.
		echo $id. " didn't work once<br>";
		usleep(100000);
		$count++; 
	} else if ($failCount<3){
		echo $failCount;
		//Fails after 2 tries.
		//Prints fail information to file with current date.
		$fail_file = 'error_logs/'.$date.'.txt';
		if (!file_exists($fail_file)) { //Makes error log if it doesn't exist.
			fopen($fail_file, "w"); //Make the file.
		}
		$current = file_get_contents($fail_file);
		$current.= $id.' failed twice.\n';
		file_put_contents($fail_file, $current);
		$count = 1; //Resets count for next id loop.
		$failCount++;
		$id++;
	} else {
		//Delete the last 3 lines in the error log.
		break;
	}
};
//Puts the latest download in a text file in root.
$last_download = '../'.$file_path."/";
$newfile = fopen("latest_path.txt", "w") or die ("Unable to open file!");
fwrite ($newfile, $last_download);
?>