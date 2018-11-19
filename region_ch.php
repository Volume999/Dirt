
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
	$link = "UserChoose.php";
	$message = "Go back";
	htmlGetBack($prob, $link, $message);
	}
	 else { 

       

  
       $html = "

        <html>

        <title> Location of Pollution </title>

        <meta charset='utf-8'>
                <center>



        <h4> Region Changing </h4>

        <form action='' method='POST'>

        <table border='1px' cellpadding='5' cellspacing='0'>

         <tr><td>new Region</td></tr> <td><select name = 'region'> 
			<option value = 'Sverdlov'>Sverdlov</option>
			<option value ='Oktyabr'> Oktyabr</option>
			<option value = 'Pervomay'> Pervomay</option>
			<option value = 'Lenin'> Lenin</option>
		</select></td>


        <tr><td colspan='2' align='center'> <input type='submit' name='submit' size = '40' value='change'> </td></tr>

        </html>
        

        ";

        print $html;

      }

?>
