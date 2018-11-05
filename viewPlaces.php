<?php
// Our first test HTML and PHP page

if (isset($_POST['submit']))
{
	// process the form below

	// let's first read the username via POST request

	


	
}else{


	$database_servername = "localhost";
	$database_username = "zveri";
	$database_password = "123dastan";

	$conn = mysqli_connect($database_servername, $database_username, $database_password);
	$result = mysql_query("SELECT lat FROM coordinates");
	$storeArray = Array();
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
   		$storeArray[] =  $row['lat'];  
	}

	if (!$conn) {
    		die("Connection failed: " . mysqli_connect_error());
	}
	mysqli_query($conn,$query);

	echo "Succefull send";


    function build_table($array){
	    // start table
	    $html = '<table>';
	    // header row
	    $html .= '<tr>';
	    foreach($array[0] as $key=>$value){
	            $html .= '<th>' . htmlspecialchars($key) . '</th>';
	        }
	    $html .= '</tr>';

	    // data rows
	    foreach( $array as $key=>$value){
	        $html .= '<tr>';
	        foreach($value as $key2=>$value2){
	            $html .= '<td>' . htmlspecialchars($value2) . '</td>';
	        }
	        $html .= '</tr>';
	    }

	    // finish table and return it

	    $html .= '</table>';
	    return $html;
	}


	echo build_table($storeArray);

	}

?>

