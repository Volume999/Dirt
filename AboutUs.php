<?php  
session_start();
require_once ("config.php");
print("
<html>
<head>
<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
  <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
  <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
 </head>
<div class = 'container'>
<h1> Clean Bishkek </h1><br>

<h2> What does this site do? </h2><br>

This site helps people to keep Bishkek clean.
This site shows all the locations of collected and unnoticed trash in Bishkek city and helps people 
to easily find it. It helps the government to see the specific location to efficiently clean areas.
Whenever people see uncollected trash on subways or in the corners of the building or broken
trees, with the help of this site people can easily set the location of the trash. After, all the people 
of Bishkek who are using this site can see the location of this trash.<br>

<h2> How to use this site? </h2><br>
<h3>1. How to set a location? <small>In order to use this site a citizen has to to go through several steps.
</small></h3><br>


 <p class='bg-primary' style='font-size:160%; text-align:center;'>First: Register on the site</p> 
<p class='bg-primary' style='font-size:160%; text-align:center;'>Second: Login using your credentials</p>
<strong style='font-size:160%;'><center>Unauthorized users can only view the points.</center> </strong>
<p class='bg-primary' style='font-size:160%; text-align:center;'>Third: Set a point using markers on the map</p>
<h3><small>Level indicates degree of pollution, from 1 point up to 5. </small></h3>

<h3>2. Reporting points as cleaned </h3><br>
<h3><small>After the trash was found and cleaned, three or more users have to prove and only after that the trash location will be deleted
from the map.</small> </h3>

<br>
<hr>
</div>
<a href = 'index.php'> Back to Login </a>
</html>
");
?>