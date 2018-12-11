<?php  
session_start();
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
 $last = DateTime::createFromFormat ( "Y-m-d H:i:s", $row["lastSubmission"]);
        $available = date_add($last, date_interval_create_from_date_string('30 minutes'));
        $nextsubmission =  date_format($available, 'Y-m-d H:i:s');
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
		Your email: <input type='email' name='email'style='margin-right:7px'> 
		<input type='submit' name='change' value = 'Submit' class='btn btn-success'>
	</form>
</html>");
}


print(" 
<html>
<head>
<title>Welcom to your office</title>
<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
  <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
   <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
</head>
<body style='margin:20'>
	<h1> Welcome to your office !!</h1>
	<h2> Username: '$username' Region: '$region' </h2>
<br>
Next Submission available at: $nextsubmission
<p>
<a href='pswd_ch.php'class='btn btn-info' style='margin-top:5'> Change Password </a> <br>
<a href='username_ch.php'class='btn btn-info' style='margin-top:5'>Change Username </a> <br>
<a href='region_ch.php'class='btn btn-info' style='margin-top:5'> Change User Region </a> <br>
");
if ($row['email'] == "") {
	print ("<form action='' method='POST'>
	<button type='submit' class='btn btn-primary' style='margin-top:5' name='submit'  > <i class='glyphicon glyphicon-envelope' style='margin-right:5px'></i> Add email</button>
	");
}
print("</p>
</body>
</html>
");
htmlGetBack("", "index.php", "Go back");
?>
