<?php
session_start();
require_once("config.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$ip = $_SERVER['REMOTE_ADDR'];
if (empty($_SESSION)) {
htmlGetBack("Anouthorized users cannot view this page","index.php" ,"Go back" );
logError("$ip tried to access this page without authorizing");
exit;
}
$username = $_SESSION['username'];
$sesid = $_SESSION['id'];

   
if(isset($_POST['submit'])) {
	if (empty($_POST['oldpas']) or empty($_POST['newpas']) or empty($_POST['connewpas'])) {
		logError("$username ($sesid) bypassed HTML and submitted empty input");
		htmlGetBack("You did not fill all areas","index.php" ,"Go back" );
	}
	else {
    		$password = $_POST['oldpas'];
    		$newpas = $_POST['newpas'];
		$conpas = $_POST['connewpas'];
        	$conn;
		if ($newpas != $conpas) {
			htmlGetBack("Passwords don't match","userOffice.php" ,"Go back");
			logError("$username ($sesid) submitted unmatched passwords while changing password: $newpas $conpas");
		}
		else {
        		$result = mysqli_query($conn, "SELECT * FROM users WHERE pswd = '$password' AND username = '$username'");
        		$row = mysqli_fetch_assoc($result);
			if ($row['id'] != $_SESSION['id']) {
        		htmlGetBack("incorrect credentials","userOffice.php" ,"Go back");
				logError("$username ($sesid) submitted wrong credentials while changing password");
        	}
			else {
        		mysqli_query($conn, "UPDATE users SET pswd = '$newpas' where username = '$username'");         
				htmlGetBack("Changed successfully","userOffice.php" ,"Go back" );
			}
		}
	}
} 
else { 
      $html = "
        <html>
        <head>
        <title> Changing Password </title>
         <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
  <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
  <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
        </head>
        <meta charset='utf-8'>
         <center>
        <h2> Password Changing </h2>
        <form action='' method='POST'>
        <table border='1px' cellpadding='5' cellspacing='0'>
        <tr><td><strong>Password</strong></td><td> <input type='password' step=any name='oldpas' required></td> </tr>
        <tr><td><strong> New Password</strong></td><td> <input type='password' step=any name='newpas' minlength = '6' required> </td></tr>
        <tr><td><strong> Confirm New Password</strong></td><td> <input type='password' step=any name='connewpas' required> </td></tr>
        <tr><td colspan='2' align='center'> <input type='submit' name='submit' size = '40' value='change' class = 'btn btn-info'> </td></tr>
	</table>
	</center>
        </html>       
        ";
        print $html;
	htmlGetBack("", "userOffice.php", "Return");
      }
