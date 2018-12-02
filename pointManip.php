<?php 
session_start();
require_once("config.php");
$user = $_GET['username'];
$action = $_GET['action']; // 0 = delete 1 = report
$lat = $_GET['lat'];
$lng = round($_GET['lng'], 6);
$conn;
$user_arr = mysqli_query($conn, "SELECT * from markers where lng = $lng and lat = $lat;");
$row=mysqli_fetch_array($user_arr,MYSQLI_ASSOC);
if (empty($row)) {
	print("point does not exist $lng $lat");
	logError("$user reported an inexistent point");
	exit;
}
$name = $row['name'];
if ($action == 0) {
	if ($name == $_SESSION['username']) {
		mysqli_query($conn, "DELETE from markers where lng = $lng and lat = $lat");
		htmlGetBack("Your point has been successfully deleted","index.php", "Go back");
	}
	else {
		print ("You cannot delete points that you didn't place");
		exit;
	}
}
else if($action == 1) {
	$idreport1 = $row['idreport1'];
	$idreport2 = $row['idreport2'];
	$userId = $_SESSION['id'];
	if ($_SESSION['id'] == $idreport1 or $_SESSION['id'] == $idreport2) {
		htmlGetBack("One person can only report a point once","index.php" , "Go back");
		$today;   
		logError("$username($userId) tried to report for the second time");
	}
	else {
		if ($row['reports'] == 2) {
			mysqli_query($conn, "DELETE FROM markers WHERE lng = $lng and lat = $lat");
			htmlGetBack("Treshold for deletion has been reached, point has been deleted","index.php", "Go back");
		}
		else {
			if ($row['reports'] == 1) {
				mysqli_query($conn, "UPDATE markers SET idreport2 = '$userId', reports = 2 WHERE lng = $lng and lat = $lat");
			}
			else {
				mysqli_query($conn, "UPDATE markers SET idreport1 = $userId, reports = 1 WHERE lng = $lng and lat = $lat");
			}
			htmlGetBack("Your report has been saved", "index.php", "Go back");
		}
	}
}
 

