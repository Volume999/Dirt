
 <?php

	session_start();
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
 	require_once("config.php");
    	$ip = $_SERVER['REMOTE_ADDR'];
if (empty($_SESSION)) {
htmlGetBack("Anouthorized users cannot view this page","index.php" ,"Go back" );
logError("$ip tried to access this page without authorizing");
exit;
}

        if(isset($_POST['submit']))
        {
	$id = $_SESSION['id'];
	$newreg = $_POST['region'];
        $conn;
        mysqli_query($conn, "UPDATE users SET region = '$newreg' where id = '$id'");         
        $prob = "Changed successfully";
	$link = "userOffice.php";
	$message = "Go back";
	htmlGetBack($prob, $link, $message);
	}
	 else { 

       

  
       $html = "

        <html>
        <head>
        <title> Changing region </title>
         <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
  <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
  <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
        </head>
        <meta charset='utf-8'>
                <center>



        <h2> Region Changing </h2>

        <form action='' method='POST'>
        <div class = 'form-group' style = 'text-alig'>
            <table border='1px' cellpadding='5' cellspacing='0'>
         <select name = 'region' size = 4 class = 'form-control'> 
			<option value = 'Sverdlov' style = 'text-align:center; font-size:150%;' >Sverdlov</option>
			<option value ='Oktyabr'style = 'text-align:center; font-size:150%;'style = 'text-align:center; font-size:150%;'style = 'text-align:center; font-size:150%;'> Oktyabr</option>
			<option value = 'Pervomay'style = 'text-align:center; font-size:150%;'style = 'text-align:center; font-size:150%;'> Pervomay</option>
			<option value = 'Lenin'style = 'text-align:center; font-size:150%;'> Lenin</option>
		</select></td>
        </div>

        <tr><td colspan='2' align='center'> <input type='submit' name='submit' size = '40' value='change' class = 'btn btn-info'> </td></tr>

        </html>
        </table>
	</center>


        ";

        print $html;
	htmlGetBack("", "userOffice.php", "Return");

      }

?>
