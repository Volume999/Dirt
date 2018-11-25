<?php 
session_start();
require_once("config.php");
$conn;
if (isset($_POST['submit'])) {
	$username = $_POST['username'];
	$email = $_POST['email'];
	$result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    $row = mysqli_fetch_assoc($result);
    if (strlen($username) == 0 or strlen($email) == 0) {
    	htmlGetBack("You have not filled all areas", "index.php", "Go Back");
    	exit;
    }
    if ($row['id'] == 0) {
    	htmlGetBack("Username does not exist", "index.php", "Go Back");
    	exit;
    }
    if ($row['email'] != $email) {
    	htmlGetBack("This Username is on another email address", "index.php", "Go Back");
    	exit;
    }
	$str = "0123456789abcdefgijklmnopqrstuvwxyz";
	$str = str_shuffle($str);
	$str = substr($str, 0, 10);
	mysqli_query($conn, "UPDATE users SET pswd = '$str' WHERE username = '$username'");
	htmlGetBack("Your new password is $str", "index.php", "Go Back");
	
}
else {
	print ("
<html>
<body>
	<form action='' method='POST'>
		<input type='text' name='username' placeholder='Username' required>
		<input type='email' name='email' placeholder='email@email.email' required>
		<input type='submit' name='submit' value='Submit'>
	</form>
</body>
</html>
		");
htmlGetBack("", "index.php", "Go Back");
}


 ?>
	


