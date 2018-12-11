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
	$password = trim($password);
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
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<style>
#register td, #register th {
  padding: 8px;
}
#Submit{

 	padding: 8px;

}
</style>
</head>
<body>
	<meta charset="utf-8">
     

      <center>

	<h4>Please fill out all the sections </h4>

	<form action="" method="POST">	
	<table id="register">		
		<tr><td> User name </td> <td> <input type="text" class="form-control" name="username" placeholder="name" pattern = "[A-Za-z0-9]{6,}" title = "Логин не может быть короче шести латинских символов." required></td></tr>

		<tr><td> Password</td> <td> <input type="password" pattern="[A-Za-z0-9]{1,20}" class="form-control" title = "Пароль не может быть короче восьми символов и должен содержать хотя бы одну цифру, одну маленькую и одну большую латинскую букву." name="password" placeholder="password" minlength = "6" required></td></tr>

		<tr><td>Region</td><td><select name = "region" class="form-control" > 
			<option value = "Sverdlov">Sverdlov</option>
			<option value = "Oktyabr"> Oktyabr</option>
			<option value = "Pervomay"> Pervomay</option>
			<option value = "Lenin"> Lenin</option>
		</select></td>
		</tr> 
 	</table>

 	<input class = "btn btn-success"type="Submit" name="Submit"id="Submit" color="blue">
	</center>
</body>
</html>';
print $html;
htmlGetBack("", "index.php", "Go Back");

}
?>
