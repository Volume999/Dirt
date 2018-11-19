<?php
session_start();

if (isset($_POST['submit']))
{
        // process the form below

        // let's first read the username via POST request

        $lat = number_format((float)$_POST['xCoord'], 2, '.', '');// need to sanitize any USER INPUT

        // Now let's read the password - you can hash or do what's next

        $lon = number_format((float)$_POST['yCoord'], 2, '.', ''); // need to sanitize any USER INPUT
        $level = $_POST['points']; 
        


        $database_servername = "localhost";
        $database_username = "zveri";
        $database_password = "123dastan";

        $conn = mysqli_connect($database_servername, $database_username, $database_password,"zveri");
        

        if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());    
        }
 
 $id = $_SESSION['id'];
        mysqli_query($conn,"INSERT into `coordinates` (lat, lon, level, id) values ('$lat', '$lon', '$level', '$id')");
        print "Latitude $lat, Longitude $lon, level of pollution $level were successfully saved

        <h4><a href='UserChoose.php'> Return back </a></h4>
        ";
        
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

        <tr><td>Latitude</td><td> <input type='number' step=any name='xCoord' required></td> </tr>

        <tr><td>Longitude </td><td> <input type='number' step=any name='yCoord' required> </td></tr>



        <tr><td> Level </td>


        <td> 
        &nbsp;1 &nbsp; &nbsp; &nbsp; 2 &nbsp; &nbsp;&nbsp;&nbsp; 3 &nbsp; &nbsp; &nbsp; 4 &nbsp; &nbsp; &nbsp; 5<br>
        <input type='radio' name='lev' value=''> &nbsp; &nbsp;
        <input type='radio' name='lev' value=''> &nbsp; &nbsp;
        <input type='radio' name='lev' value=''> &nbsp; &nbsp;
        <input type='radio' name='lev' value=''> &nbsp; &nbsp;
        <input type='radio' name='lev' value=''> &nbsp; &nbsp;

        <br>    
        </td></tr>

        <tr><td> Comment </td><td> <textarea name='comment' rows='10' cols='40'> additional descritpions about your trash </textarea> </td></tr>

        <tr><td colspan='2' align='center'> <input type='submit' name='submit' size = '40' value='Submit'> </td></tr>

        </html>
        

        ";

        print $html;
}
?>


