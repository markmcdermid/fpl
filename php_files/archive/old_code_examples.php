<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
$myarray = json_decode(file_get_contents('assets/rooney.json'));
$myarray = json_decode(json_encode($myarray),true);
echo '<pre>'; print_r($myarray); echo '</pre>';

//In to the rabbit hole.
function printDirtyArray() {
	global $myarray;
	foreach ($myarray as $key => $value) {
		if (is_array($value)) {
			echo "<ul class='inner'><li>".$key."</li></ul>";
		//Further In.
			foreach ($value as $key => $innervalue) {
				echo "<li class='inner2'>".$key."</li>";
				if (is_array($innervalue)) {
				//Further In.
					foreach ($innervalue as $key => $inner2value) {
						echo "<li class='inner3'>".$key."</li>";
						if (is_array($inner2value)) {
						//Last Stop.
							echo "<div>";
							foreach ($inner2value as $key => $inner3value) {
								echo "<li class='inner4'>".$inner3value."</li>";
							}
							echo "</div>";
						}
					}
				}
			}
		} else {
			echo "<li>".$key." : ".$value."</li>";
		};
	};
};
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
echo "<ul>";
printNestedArray($myarray, 1,'outer');
echo "</ul>";
/*echo is_array($value) ? "<li>Array</li>" : "<li>".$key." : ".$value."</li>";
};
echo "</ul>";*/
/*echo $array['fixture_history']['all'][0][2];*/
echo $myarray['fixture_history']['all'][0][1];
echo '<pre>'; print_r($myarray); echo '</pre>';
?>
