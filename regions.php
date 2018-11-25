<?php 
	session_start();
	require_once("config.php");
	if(isset($_POST['submit'])) {
		$region = $_POST['region'];
		$conn;
	$result = mysqli_query($conn, "SELECT * from markers where region = '$region'");
    while($row = mysqli_fetch_assoc( $result)){
   	$json[] = $row;
 	}
 	$json_encoded = json_encode($json);
 	$json_decoded = json_decode($json_encoded);
 	
   	 echo "<table border='1px' cellpadding='5' cellspacing='0'>";
   	   echo '<tr>';
        echo '<td> Latitude </td>';
        echo '<td> Longitude </td>';
        echo '<td> Dirt level </td>';
         echo '<td> Observer  </td>';
      echo '</tr>';
    foreach($json_decoded as $result){
        echo '<tr>';
        echo '<td>'.$result->lat.'</td>';
        echo '<td>'.$result->lng.'</td>';
        echo "<td> <font color='red'>".$result->level."</font></td>";
	$id = $result -> userID;
	$pid = $result -> id;
       $name = mysqli_query($conn, "SELECT * from users where id  = '$id'");
	$nameRow = mysqli_fetch_array($name,MYSQLI_ASSOC);
	echo '<td>'.$nameRow['username'].'</td>';
	echo "<td><a href=details.php?id='$pid'&observer=$nameRow[username]>details</a></td>";
        echo '</tr>';
    }
    echo '</table>';
	if (empty($_SESSION['username'])) {
    	$link = 'GuestChoose.php';
	 }
	 else {
		 $link = "UserChoose.php";
	 }
	 $message = "";
	 $message2 = "Go back";
	htmlGetBack($message, $link, $message2);

}

	else {
		$html = "
		<html>
		<body>
			<form action = '' method='POST'>
				<table>
					<tr>
						<td>Select Region <select name = 'region'>
							<option value = 'Sverdlov'>Sverdlov</option>
							<option value ='Oktyabr'> Oktyabr</option>
							<option value = 'Pervomay'> Pervomay</option>
							<option value = 'Lenin'> Lenin</option>
						</select>
						</td>
					</tr>
					<tr>
						<td><input type='submit' name='submit'></td>
					</tr>
				</table>
			</form>
		</body>
		</html>
		";
		print ($html);
	}

