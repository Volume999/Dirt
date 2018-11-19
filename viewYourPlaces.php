<?php
session_start();
require_once ("config.php");
$ip = $_SERVER['REMOTE_ADDR'];
if (empty($_SESSION)) {
htmlGetBack("Anouthorized users cannot view this page","index.php" ,"Go back" );
logError("$ip tried to access this page without authorizing");
exit;
}
try {
        error_reporting(E_ALL);
        $conn;
	$id = $_SESSION['id'];
        if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
        }       
        $result = mysqli_query($conn,"SELECT * FROM coordinates where id = '$id'");   
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
        $id = $result -> id;
        $pid = $result -> pointid;
       $name = mysqli_query($conn, "SELECT * from users where id  = '$id'");
        $nameRow = mysqli_fetch_array($name,MYSQLI_ASSOC);
        echo '<td>'.$nameRow['username'].'</td>';
        echo "<td><a href=details.php?id='$pid'&observer=$nameRow[username]>details</a></td>";
        echo '</tr>';
    }
    echo '</table>';
if (empty($_SESSION['username'])) {
        $link = 'GuestChoose.php';
        $link = 'GuestChoose.php';
         }
         else {
                 $link = "UserChoose.php";
         }
        print("
        <html>  
        <body>
        <a href = $link> Back to login </a>
        </body>
        </html>");      
}
catch(Exception $e) {
        writeException("please");
}           


?>

