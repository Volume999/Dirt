<?php
// Our first test HTML and PHP page

if (isset($_POST['submit']))
{
	// process the form below

	// let's first read the username via POST request

	$username = $_POST['username']; // need to sanitize any USER INPUT

	// Now let's read the password - you can hash or do what's next

	$password = $_POST['password']; // need to sanitize any USER INPUT

	print "Welcome, $username !

	<h4><a href='powelNahuiAli.php'>Go Back! </a></h4>
	";


	$database_servername = "5.59.11.66";
	$database_username = "zveri";
	$database_password = "123dastan";

	$conn = mysqli_connect($servername, $username, $password);

	if (!$conn) {
    		die("Connection failed: " . mysqli_connect_error());
	}

	echo "Connected successfully";
}

else
{
	

	$html = "

	<html>

	<title> Место загрязненности </title>

	<meta charset='utf-8'>

	<center>


	<h4> Укажите место загрязнености </h4>

	<form action='' method='POST'>

	<table border='1px' cellpadding='5' cellspacing='0'>

	<tr><td> Input x : </td><td> <input type='number' name='xCoord' </td> </tr>

	<tr><td> Input y: </td><td> <input type='number' name='yCoord'> </td></tr>

	<tr><td colspan='2' align='center'> <input type='submit' name='submit' value='LOGIN'> </td></tr>

	</html>
	";

	print $html;
}
?>
