<?php  
session_start();
ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
require_once("config.php");
$ip = $_SERVER['REMOTE_ADDR'];

if (empty($_SESSION)) {
htmlGetBack("Anouthorized users cannot view this page","index.php" ,"Go back" );
logError("$ip tried to access this page without authorizing");
exit;
}

$conn;
$username = $_SESSION['username'];
$user_arr = mysqli_query($conn, "SELECT * from users where username = '$username'");
$row=mysqli_fetch_array($user_arr,MYSQLI_ASSOC);
$region = $row['region'];
if (isset($_POST['change'])) {
	$email = $_POST['email'];
	$user_arr2 = mysqli_query($conn, "SELECT * from users where email = '$email'");
	$row2=mysqli_fetch_array($user_arr2,MYSQLI_ASSOC);
	if ($row2['id'] != 0) {
		htmlGetBack("Username with this email already exists", "userOffice.php", "Go back");
		exit;
	}
	else {
		mysqli_query($conn, "UPDATE users SET email = '$email' WHERE username = '$username';");
		htmlGetBack("Email Added Successfully $email", "userOffice.php", "Go Back");
		exit;
	} 
}
if (isset($_POST['submit'])) {
	print("<html>
	<form action = '' method= 'POST'>
		Your email: <input type='email' name='email'> <br>
		<input type='submit' name='change' value = 'Add Email'>
	</form>
</html>");
}



print(" 
<html>
<head>
<title>Welcom to your office</title>
</head>
<body>
	<h1> Welcome to your office !!</h1>
	<h2> Username: '$username' Region: '$region' </h2>
<p>
<a href='pswd_ch.php'> Change Password </a> <br>
<a href='username_ch.php'>Change Username </a> <br>
<a href='region_ch.php'> Change User Region </a> <br>
<a href='viewYourPlaces.php'> View your places </a> <br>
");
if ($row['email'] == "") {
	print ("<form action='' method='POST'>
	<input type='submit' name='submit' value = 'Add Email'>
	</form>
	");
}
print("</p>
</body>
</html>
");
htmlGetBack("", "index.php", "Go back");
?>
