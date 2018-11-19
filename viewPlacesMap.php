<?php
session_start();
require_once ("config.php");
	$conn;
	if (!$conn) {
    		die("Connection failed: " . mysqli_connect_error());
	}
	
	
	$result = mysqli_query($conn,"SELECT lat, lng FROM coordinates");   
	while($row = mysqli_fetch_assoc( $result)){
   	  $json[] = $row;
 	}

 	$json_encoded = json_encode($json,JSON_NUMERIC_CHECK	);
 	
 	$html = "<!DOCTYPE html>
<html>
  <head>
    <meta name='viewport' content='initial-scale=1.0, user-scalable=no'>
    <meta charset='utf-8'>
    <title>Marker Clustering</title>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
  </head>
  <body>
    <div id='map'></div>
    <script  type='text/javascript'>

      function initMap() {

        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 12,
          center: {lat: 42.8640117, lng: 74.5460088	}
        });

        // Create an array of alphabetical characters used to label the markers.
        var labels = 'DASTAN';

      
        var markers = locations.map(function(location, i) {
          return new google.maps.Marker({
            position: location,
            label: labels[i % labels.length]
          });
        });

        // Add a marker clusterer to manage the markers.
        var markerCluster = new MarkerClusterer(map, markers,
            {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
      }
    
      var locations = $json_encoded
      
	
		
		

		
    </script>
    <script src='https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js'>
    </script>
    <script async defer
    src='https://maps.googleapis.com/maps/api/js?key=AIzaSyBlLms-yD7lNgRk3z4LIpv79WvNTP2aY1I&callback=initMap'>
    </script>
  </body>
</html>";
	echo $html;



?>

