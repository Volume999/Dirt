<?php
    session_start();
    require_once("config.php");
    $ip = $_SERVER['REMOTE_ADDR'];
    unset($_SESSION['username']);
    unset($_SESSION['id']);
   	if (isset($_POST['submit'])) {
		$conn;
		$username = $_POST['username'];
		$password = $_POST['password'];
		$user_arr = mysqli_query($conn, "SELECT * from users where username = '$username' and pswd = '$password'");
		$row=mysqli_fetch_array($user_arr,MYSQLI_ASSOC);
		if (strlen($username) == 0 or strlen($password) == 0) {
		htmlGetBack("You have not authorized with username / password", "index.php", "Go Back");
		logAction($conn, "empty", "empty");
		exit;
		}
		else {
		if ($row['id'] == 0 || $row['status'] != 1) {
		htmlGetBack("Incorrect credentials", "index.php", "Go Back");
		logAction($conn, $username, "fail");
		exit;
		}
		else {	
		$_SESSION['username'] = $username;
		$_SESSION['id'] = $row['id'];
		logAction($conn, $username, "login");
		echo "<script>window.location = 'index.php';</script>";
		}
	}   		
  }
print("
<html>
<head>
	<title>Welcome to ZVERI</title>
	<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' integrity='sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u' crossorigin='anonymous'>
	<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
  <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
</head>
<body>
<div class='container'>
<h2>Login</h2>
<form action = '' method='POST'>
<div class='form-group'>
	
			<label>Email:</label>
    		<input type='text' class='form-control' placeholder='Enter username' name='username' required>
			</div>
		<div class='form-group'>
        <label>Password:</label>
        <input type='password' class='form-control' id='pwd' placeholder='Enter password' name='password' required>
        </div>
		<input type='submit' name='submit' class='btn btn-default' value = 'Login'>
		<br>
		<a href='index.php'>Proceed as Guest </a>
		<br>
<a href='forgotPass.php'>Reset Password </a>

</form>
<br>
<hr>
<center>
<h1>'Make Bishkek Trashless' project <h1>
</center>
<p>
	<a href = 'regist.php'>Sign up</a><br><a href= 'AboutUs.php'>About us</a><br>
	<a href= 'index.php'>Go back</a>


</p>
</body>
</html>
");
