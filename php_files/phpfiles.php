<html>
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
	<style>a {text-decoration: none; padding:0; line-height:20px; font-size:18px; font-family:helvetica;}</style>
<body>
	<?php
$dir_open = opendir('.');

while(false !== ($filename = readdir($dir_open))){
	if($filename != "." && $filename != ".."){
		if (strpos($filename,'php') !== false) {
			$link = "<a href='./$filename'> $filename </a><br />";
			echo $link;
		}
	}
}

closedir($dir_open);
?>
</body>
</html>

