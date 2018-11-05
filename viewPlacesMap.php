<?php
session_start();
require_once ("config.php");
	$conn;
	if (!$conn) {
    		die("Connection failed: " . mysqli_connect_error());
	}

	
	$result = mysqli_query($conn,"SELECT lat, lon FROM coordinates");   
	while($row = mysqli_fetch_assoc( $result)){
   	  $json[] = $row;
 	}

 	$json_encoded = json_encode($json);
 	echo $json_encoded;
	//$html = file_get_contents("viewMap.html");
	// print $html;

?>