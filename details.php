<?php  
session_start();
require_once ("config.php");
$conn;
if(!$conn) {
	logError("MySQLI Connect error");
	die("Connection failed: " . mysqli_connect_error());
}
try {
$ip = $_SERVER['REMOTE_ADDR'];
if (empty($_SESSION)) {
	htmlGetBack("Anouthorized users cannot view this page","index.php" ,"Go back" );
	logError("$ip tried to access this page without authorizing");
	exit;
}
$userId = $_SESSION['id'];
$username = $_SESSION['username'];
$id = filterInput($_GET['id']);
$observer = filterInput($_GET['observer']);
$user_arr = mysqli_query($conn, "SELECT * from coordinates where pointid = '$id'");
$row=mysqli_fetch_array($user_arr,MYSQLI_ASSOC);
if(isset($_POST['delete'])) {
	mysqli_query($conn, "DELETE FROM coordinates WHERE pointid = '$id'");
	htmlGetBack("Your point has been successfully deleted","UserChoose.php", "Go back");
}
else if(isset($_POST['submit'])) {
	$idreport1 = $row['idreport1'];
	$idreport2 = $row['idreport2'];
	if ($_SESSION['id'] == $idreport1 or $_SESSION['id'] == $idreport2) {
		htmlGetBack("One person can only report a point once","viewPlaces.php" , "Go back");
		$today;   
		logError("$username($userId) tried to report for the second time");
	}
	else {
		if ($row['reports'] == 2) {
			mysqli_query($conn, "DELETE FROM coordinates WHERE pointid = '$id'");
			htmlGetBack("Treshold for deletion has been reached, point has been deleted","UserChoose.php", "Go back");
		}
		else {
			if ($row['reports'] == 1) {
				mysqli_query($conn, "UPDATE coordinates SET idreport2 = '$userId', reports = 2 WHERE pointid = '$id'");
			}
			else {
				mysqli_query($conn, "UPDATE coordinates SET idreport1 = '$userId', reports = 1 WHERE pointid = '$id'");
			}
			htmlGetBack("Your report has been saved", "UserChoose.php", "Go back");
		}
	}
}

else {
print("
<html>
<meta charset='UTF-8'>
<body>

		X: $row[lat] <br>
		Y: $row[lon] <br>
		level: $row[level] <br>
		observer: $observer <br>
	  <form action = '' method = 'POST'>

");
if (strlen($username) != 0) {
	print("<p><input type='submit' name = 'submit' value = 'Mark as cleaned'></p>");
	if ($observer == $_SESSION['username']) {
		print ("<p><input type='submit' name = 'delete' value = 'Delete your submission'></p>");
	}
}
print ("
</form>
</body>
</html>");
htmlGetBack("", "viewPlaces.php", "Go Back");
}
}
catch(Exception $e) {
logError($e->getMessage());
}


?>
