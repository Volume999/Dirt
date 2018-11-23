<?php
	require_once ("config.php");
	$conn;
	if (!$conn) {
    		die("Connection failed: " . mysqli_connect_error());
	}	
 if (isset($_POST['Submit']))  {
	$ip = $_SERVER['REMOTE_ADDR'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$region = $_POST['region'];
	$result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
        $row = mysqli_fetch_assoc($result);
	$message = "Go back";
	$link = 'index.php';
	if (strlen($username) == 0) {
	$prob = "You didn't input your username";
	logError("$ip bypassed HTML and submitted empty username");
	}
	else if (strlen($password) < 6) {
	$prob = "Password must be not less than 6 symbols";
	logError("$ip bypassed HTML and submitted password less than 6 symbols");
	}
	else if ($row['id'] != 0) {
	$prob = "Username already exists";
	logError("$ip tried to register under an existing username");
	}
	else if (ipVerification($ip) != 0) {
	$prob = "There is already an account tied to this IP adress";
	logError("$ip tried to register for the second time");
	}
	else {
	$prob = "Registration completed";
	$message = "Back to login"; 
	$username = mysqli_escape_string($conn, $username);
	$password = mysqli_escape_string($conn, $password);
	$region = mysqli_escape_string($conn, $region);
	mysqli_query($conn, "INSERT into users (username, pswd, region, ip) values ('$username', '$password', '$region', '$ip');");
	mysqli_query($conn, "UPDATE users set lastSubmission = '1970-1-1 11:11:11' where username = '$username'");
	logAction($conn, $username, "created");	
	}
	htmlGetBack($prob, $link, $message);	
	exit;
}
else {
$html = '<html>
<head>
<title>Registration</title>
</head>
<body>
	<meta charset="utf-8">
     

      <center>

	<h4>Please fill out all the sections </h4>

	<form action="" method="POST">	
	<table >		
		<tr><td> User name </td> <td> <input type="text" name="username" placeholder="name" required></td></tr>

		<tr><td> Password</td> <td> <input type="password" name="password" placeholder="password" minlength = "6" required></td></tr>

		<tr><td>Region</td></tr> <td><select name = "region"> 
			<option value = "Sverdlov">Sverdlov</option>
			<option value = "Oktyabr"> Oktyabr</option>
			<option value = "Pervomay"> Pervomay</option>
			<option value = "Lenin"> Lenin</option>
		</select></td>
 	</table>

 	<input type="Submit" name="Submit" color="blue">
	</center>
</body>
</html>';
print $html;

}
?>
