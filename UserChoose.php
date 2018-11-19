<?php 
        session_start();
        require_once("config.php");
        $ip = $_SERVER['REMOTE_ADDR'];
        if(empty($_SESSION['username'])) {      
                $conn = mysqli_connect("localhost","zveri","123dastan", "zveri");
                if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
                }       
                $username = $_POST['username'];
                $password = $_POST['password'];
                $user_arr = mysqli_query($conn, "SELECT * from users where username = '$username' and pswd = '$password'");
                $row=mysqli_fetch_array($user_arr,MYSQLI_ASSOC);
                if (strlen($username) == 0 or strlen($password) == 0) {
                htmlGetBack("You have not authorized with username / password", "index.php", "Go Back");
                logAction($conn, "empty", "empty");
                exit;
                }
                else {
                        if ($row['id'] == 0 || $row['status'] != 1) {
                                htmlGetBack("Incorrect credentials", "index.php", "Go Back");
                                logAction($conn, $username, "fail");
                                exit;
                                }
                        else {
                                $_SESSION['username'] = $username;
                                $_SESSION['id'] = $row['id'];
                                logAction($conn, $username, "login");
                        }
                }

        }
        print ("
        <html>
        <body>
        <a href='pointPlace.php'>Set the trashy point</a>
        <a href='viewPlaces.php'>View the trashy points</a>
        <a href='regions.php'>View regionally </a><br>
        <a href = 'userOffice.php'> go to Office</a><br>
        <a href = 'index.php'> Logout </a>
        </body>
        </html>
        ");
 ?>

