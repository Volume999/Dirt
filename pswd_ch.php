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
$sesusername = $_SESSION['username'];
$sesid = $_SESSION['id'];

   
if(isset($_POST['submit'])) {
	if (empty($_POST['username']) or empty($_POST['oldpas']) or empty($_POST['newpas']) or empty($_POST['connewpas'])) {
		logError("$sesusername ($sesid) bypassed HTML and submitted empty input");
		htmlGetBack("You did not fill all areas","userOffice.php" ,"Go back" );
	}
	else {
		$username = $_POST['username'];
    		$password = $_POST['oldpas'];
    		$newpas = $_POST['newpas'];
		$conpas = $_POST['connewpas'];
        	$conn;
		if ($newpas != $conpas) {
			htmlGetBack("Passwords don't match","userOffice.php" ,"Go back");
			logError("$sesusername ($sesid) submitted unmatched passwords while changing password: $newpas $conpas");
		}
		else {
        		$result = mysqli_query($conn, "SELECT * FROM users WHERE pswd = '$password' AND username = '$username'");
        		$row = mysqli_fetch_assoc($result);
			if ($row['id'] != $_SESSION['id']) {
        		htmlGetBack("incorrect credentials","userOffice.php" ,"Go back");
				logError("$sesusername ($sesid) submitted wrong credentials while changing password");
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
        <title> Location of Pollution </title>
        <meta charset='utf-8'>
                <center>
        <h4> Password Changing </h4>
        <form action='' method='POST'>
        <table border='1px' cellpadding='5' cellspacing='0'>
        <tr><td>User Name :</td><td> <input type='text' step=any name='username' required></td> </tr>
        <tr><td>Password :</td><td> <input type='password' step=any name='oldpas' required></td> </tr>
        <tr><td> New Password :</td><td> <input type='password' step=any name='newpas' minlength = '6' required> </td></tr>
        <tr><td> Confirm New Password :</td><td> <input type='password' step=any name='connewpas' required> </td></tr>
        <tr><td colspan='2' align='center'> <input type='submit' name='submit' size = '40' value='change'> </td></tr>
        </html>       
        ";
        print $html;
      }
