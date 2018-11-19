<?php
    session_start();
    unset($_SESSION['username']);
    unset($_SESSION['id']);
    if ($_SERVER['PHP_AUTH_USER'] != "Dastan" or $_SERVER['PHP_AUTH_PW'] != "Dog") {
                header('WWW-Authenticate: Basic Realm="Book Projects"');
        header("HTTP/1.1 401 Unauthorized");
                exit ('Incorrect login / password');
        }
?>
<html>
<head>
	<title>Welcome to ZVERI</title>
</head>
<body>
	<form action = "UserChoose.php" method="POST">
	<table align="center" border="1" width="400">
		<tbody>
			<tr>
				<td>Username</td>
				<td><input type="text" name="username" required></td>
			</tr>
			<tr>
				<td>Password</td>
				<td><input type="Password" name="password" required=></td>
			</tr>
			<tr><td><a href="UserChoose.php"align="center" >
	<input type="submit" name="submit"> 
	</tr>
	</a></td>
	<tr>
	<td><a href="GuestChoose.php">Proceed as Guest </a>
	</td>
	<td><a href="forgotPass.php">Reset Password </a>
	</td>
	</tr>
	
			
		</tbody>
	</table>
</form>
<br>
<hr>
<center><strong>'Make Bishkek Trashless' project </strong></center>
<p>
	<a href = "regist.php">Sign up</a><br><a href= "AboutUs.php">About us</a>

</p>
</body>
</html>
