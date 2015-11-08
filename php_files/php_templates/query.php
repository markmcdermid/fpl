<?php 
$result = mysqli_query($connect, $sql);
if (!$result) {
	printf("Errormessage: %s\n", mysqli_error($connect));
};
?>