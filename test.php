<?php 
	$myfile = fopen("errors.txt", "w");
	fwrite($myfile, "My error");
	fclose($myfile);
	print("Yes");
 ?>
