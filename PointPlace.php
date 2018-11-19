<?php
session_start();
require_once ("config.php");
$ip = $_SERVER['REMOTE_ADDR'];
if (empty($_SESSION)) {
htmlGetBack("Anouthorized users cannot view this page","index.php" ,"Go back" );
logError("$ip tried to access this page without authorizing");
exit;
}
if (isset($_POST['submit']))
{
    $lat = number_format((float)$_POST['xCoord'], 6, '.', '');// need to sanitize any USER INPUT
    $lon = number_format((float)$_POST['yCoord'], 6, '.', ''); // need to sanitize any USER INPUT
    $level = $_POST['lev']; 
    $trash_com = $_POST['comment'];
    $db_host = "localhost";
    $db_name = "zveri";
    $db_user = "zveri";
    $db_pass = "123dastan";
    $conn = mysqli_connect($db_host, $db_name,  $db_pass,$db_user);
    if (!$conn) {
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }
    $id = $_SESSION['id'];
    $user_arr = mysqli_query($conn, "SELECT * from users where id = '$id'");
    $row=mysqli_fetch_array($user_arr,MYSQLI_ASSOC);
    $username = $row['username'];
    $pointLocation = new pointLocation();
    $points = array("$lat $lon");
    $bishkek;
    $inBish = "inside";
    foreach($points as $key => $point) {
        $inBish = $pointLocation->pointInPolygon($point, $bishkek);
    }
    if($inBish == "outside") {
        $message = "Your point placed does not belong to Bishkek";
	logError("$username ($id) tried to submit a point outside of Bishkek: $lat $lon");
        $link = "pointPlace.php";
        $message2 = "Try again";
        htmlGetBack($message, $link, $message2);
    }
    else {
        $sverdlov; $oktyabr; $lenin; $pervomay;
        foreach($points as $key => $point) {
        $region = $pointLocation->pointInPolygon($point, $sverdlov);
        }
        if($region == "inside") {
            $region = "sverdlov";
        }
        else {
            foreach($points as $key => $point) {
            $region = $pointLocation->pointInPolygon($point, $lenin);
        }
            if ($region == "inside") {
                $region = "lenin";
            }
            else {
                foreach($points as $key => $point) {
                $region = $pointLocation->pointInPolygon($point, $oktyabr);
            }
                if ($region == "inside") {
                $region = "oktyabr";
                }
                else {
                    foreach($points as $key => $point) {
                    $region = $pointLocation->pointInPolygon($point, $pervomay);
                    }
                    if ($region == "inside") {
                    $region = "pervomay";
                    }
                    else {
                        $region = "undefined";
                        $today;
                        logError("Point belongs to bishkek, but not to any region: $lat $lon");
                    }
                }
            }
        }
        $last = DateTime::createFromFormat ( "Y-m-d H:i:s", $row["lastSubmission"]);
        $available = date_add($last, date_interval_create_from_date_string('1 day'));
	$now = new Datetime();
        if ($available > $now) {
        $link = 'UserChoose.php';
        $message = "Go back";
        print("You cannot submit now, your next submission is available on ");
	echo date_format($available, 'Y-m-d H:i:s');
	logError("$username($id) tried to submit before his allowance");
        htmlGetBack("", $link, $message);
        }
        else {
            $sql = "INSERT INTO coordinates (lat, lng, level, id , comments, region) VALUES ('$lat', '$lon','$level' , '$id', '$trash_com', '$region')";
            mysqli_query($conn, "UPDATE users set lastSubmission = now() where id = '$id'");
            if (mysqli_query($conn, $sql)) {
            echo "Latitude " . $lat . ", Longitude " . $lon . " , level of pollution " . $level . " and comment about trash " . $trash_com . " were successfully saved";
            echo '<h4><a href="UserChoose.php"> Return back </a></h4>';
            } 
            else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            logError(mysqli_error($conn));
            }
        }


        function filterInput($input)
        {
            $text = strip_tags($text);
            $text = trim($text);
            $text = htmlspecialchars($text);
            return $text;
        }
    }
}

else
{


        $html = "

        <html>

        <title> Location of Pollution </title>

        <meta charset='utf-8'>
                <center>



        <h4> Insert the location of Pollution </h4>

        <form action='' method='POST'>

        <table border='1px' cellpadding='5' cellspacing='0'>

        <tr><td>Latitude </td><td> <input type='nxumber' step=any name='xCoord' required></td> </tr>

        <tr><td>Longitude </td><td> <input type='number' step=any name='yCoord' required> </td></tr>



        <tr><td> Level </td>


        <td> 
        
        <input type='radio' name='lev' value='1'> 1 &nbsp; &nbsp;
        <input type='radio' name='lev' value='2'> 2 &nbsp; &nbsp;
        <input type='radio' name='lev' value='3'> 3 &nbsp; &nbsp;
        <input type='radio' name='lev' value='4'> 4 &nbsp; &nbsp;
        <input type='radio' name='lev' value='5'> 5 &nbsp; &nbsp;

        <br>    
        </td></tr>

        <tr><td> Comment </td><td> <textarea id='comment' name='comment' rows='10' cols='40'> </textarea> </td></tr>

        <tr><td colspan='2' align='center'> <input type='submit' name='submit' size = '40' value='Submit'> </td></tr>

        </html>
        

        ";

        print $html;
}
?>



