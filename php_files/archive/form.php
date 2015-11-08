<?php 

/*Difficulty Multiplier : Start at 1 go up to 2

Win: 3	*	diffMult
Draw: 1 * diffMult
Loss: -3 * diffMult

Difficulty

Difficulty Multiplier = 1 + (5-diff) / 10
*/

// For example Southampton vs Chelsea 
// Southampton's Overall Difficulty : 4
// Chelsea Overall Difficulty : 5
// Because Southampton At Home
// Southampton: 0
// Chelsea: 0
// 
// Difficulty multiplier for both is 1+(5-0)/10 = 1.5
// 
// If Southampton win they get + 4.5 (3*1.5)
// If Chelsea lose they get -4.5 (3*1.5)

// Next example Man City vs Bournemouth
// Man City difficulty : 5
// Bournemouth difficulty: 1
// Because man city at home:
// Man City: 5
// Bournemouth: -5
// 
// If Man City win we want them to get 3 points.
// If Bournemouth lose we want them to get -3 points.
// 
// If Bournemouth Won we would want them to get 6 points
// If Man City lose we want them to get -6 points.
// 
// If they draw we want Man City to get -1 points.
// If bournemouth draw we want them to get 1 point.

// Taking Chelsea's start to the season as an example: 
//
// Chelsea's starting value is 5
//
// SWA  3	H	draw 	2-2		-2	
// mci -1	A	loss 	0-3 	-4	
// wba  2	A	win 	3-2 	l
// CRY  3	H 	loss 	1-2 	l
// eve  0	A 	loss 	1-3 	l

$chelseaDifficulty = 5;
$chelseaData = [
["SWA",3,'H',2,2],
["mci",5,'A',0,3],
["wba",3,'A',0,3],	
["CRY",3,'H',1,2],	
["eve",4,'A',1,3]];

foreach ($chelseaData as $key => $value) {
		if ($value[3]=="H")
		{
			echo $home =$chelseaDifficulty-$value[2]+1;
		} else {
			echo $away =$chelseaDifficulty-$value[2]-1;
		}
	echo "<br>";
}


 ?>