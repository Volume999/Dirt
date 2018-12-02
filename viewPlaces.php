<?php
session_start();
require_once ("config.php");
try {
	error_reporting(E_ALL);
	$conn;
	if (!$conn) {
    		die("Connection failed: " . mysqli_connect_error());
	}	
	$result = mysqli_query($conn,"SELECT * FROM markers");   
	while($row = mysqli_fetch_assoc( $result)){
   	  $json[] = $row;
 	}
 	$json_encoded = json_encode($json);
 	$json_decoded = json_decode($json_encoded);
 	
   	 echo "<table border='1px' cellpadding='5' cellspacing='0'>";
   	   echo '<tr>';
        echo '<td> Latitude </td>';
        echo '<td> Longitude </td>';
        echo '<td> Dirt level </td>';
         echo '<td> Observer  </td>';
      echo '</tr>';
    foreach($json_decoded as $result){
        echo '<tr>';
        echo '<td>'.$result->lat.'</td>';
        echo '<td>'.$result->lng.'</td>';
        echo "<td> <font color='red'>".$result->level."</font></td>";
	$id = $result -> userID;
	$pid = $result -> id;
       $name = mysqli_query($conn, "SELECT * from users where id  = '$id'");
	$nameRow = mysqli_fetch_array($name,MYSQLI_ASSOC);
	echo '<td>'.$nameRow['username'].'</td>';
	echo "<td><a href=details.php?id='$pid'&observer=$nameRow[username]>details</a></td>";
        echo '</tr>';
    }
    echo '</table>';
	 $message = "";
	 $message2 = "Go back";
	htmlGetBack($message, "index.php", $message2);
}catch(Exception $e) {
	writeException("please");
}	    






?>

