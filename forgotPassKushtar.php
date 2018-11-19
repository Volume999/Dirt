

<?php

if(isset($_POST["submit"])){


	$db_host = "localhost";
    $db_name = "zveri";
    $db_user = "zveri";
    $db_pass = "123dastan";

    $conn = mysqli_connect($db_host, $db_user, $db_pass,$db_name);

	$email = $conn-> real_escape_string($_POST["email"]);

	$data = "SELECT email FROM users WHERE email = '$email'";
	$result = mysqli_query($conn, $data);
	$row = mysqli_fetch_array($result,MYSQLI_ASSOC);


	if($email ==  $row['email']){
		$str = "0123456789abcdsfgijklmnopqrstuvwxyz";
		$str = str_shuffle($str);
		$str = substr($str, 0, 5);	

		//works only with real paid server;
		//mail($email , "your new password : $pswd", "From : Kushtar.com\r\n");

         $change = "UPDATE users SET pswd='$str' WHERE email = '$email'";
  
         if(mysqli_query($conn, $change)){

		 echo " your password has been reset! <br>";
         die (" your new password is : $str");

         }

	}else{
		echo " please check your inputs ";
	}

} else {

   $html = "

        <html>

        <form action='' method='POST'>

        <tr><td> Email <input type='text' name='email' ></td> </tr> <br>

      	<tr><td> <input type='submit' name = 'submit' value = 'request password''> </td></tr>

        </html>

        ";

        print $html;
}
?>
