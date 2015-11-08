<?php 
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

$jsonFile = json_decode(file_get_contents('manutdvsliverpool.json'));
foreach ($jsonFile as $key => $value) {
	echo $key.$value;
}

function printNestedArray($content, $count, $arrayKey) {
	foreach ($content as $key => $value) {
		if (is_array($value)) {
			echo "<li class='array-name array-name-".str_replace("_","-", $key)."'>".$key."";
			echo "<ul class='inner-list inner-list-".str_replace("_","-", $arrayKey)." inner-list-".$count."'>";
			printNestedArray($value, $count+1, $arrayKey.$key);
			echo "<br></ul></li>";
		} else {
			echo "<li class='inner".$count."'>".$key." : ".$value."</li>";
		}
	}
	
}

 ?>