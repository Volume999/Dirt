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
		echo "<script>location.href='index.php';</script>";
		}
	}   		
  }
print("
<html>
<head>
	<title>Welcome to ZVERI</title>
</head>
<body>
	<form action = '' method='POST'>
	<table align='center' border='1' width='400'>
		<tbody>
			<tr>
				<td>Username</td>
				<td><input type='text' name='username' required></td>
			</tr>
			<tr>
				<td>Password</td>
				<td><input type='Password' name='password' required=></td>
			</tr>

			<tr>
			<td>	<input type='submit' name='submit'> </td>
			</tr>

			<tr>
			<td><a href='index.php'>Proceed as Guest </a></td>
	<td><a href='forgotPass.php'>Reset Password </a>
	</td>
	</tr>
		</tbody>
	</table>
</form>
<br>
<hr>
<center><strong>'Make Bishkek Trashless' project </strong></center>
<p>
	<a href = 'regist.php'>Sign up</a><br><a href= 'AboutUs.php'>About us</a>

</p>
</body>
</html>
");
