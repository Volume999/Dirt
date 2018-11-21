<?php
session_start();
require_once ("config.php");
  $conn;
  if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
  }

  	$name = $_GET['name'];
	$address = $_GET['address'];
	$lat = $_GET['lat'];
	$lng = $_GET['lng'];
	$type = $_GET['type'];

  $query = sprintf("INSERT INTO markers " .
         " (id, name, address, lat, lng, type ) " .
         " VALUES (NULL, '%s', '%s', '%s', '%s', '%s');",
         mysqli_escape_string($conn,$name),
         mysqli_escape_string($conn,$address),
         mysqli_escape_string($conn,$lat),
         mysqli_escape_string($conn,$lng),
         mysqli_escape_string($conn,$type));

  $result = mysqli_query($conn,$query);

  if (!$result) {
    die('Invalid query: ' . mysqli_error());
  }
  
  $result = mysqli_query($conn,"SELECT lat, lng FROM markers");   
  while($row = mysqli_fetch_assoc( $result)){
      $json[] = $row;
  }

  $json_encoded = json_encode($json,JSON_NUMERIC_CHECK  );
  $html = "<!DOCTYPE html>
  <head>
    <meta name='viewport' content='initial-scale=1.0, user-scalable=no' />
    <meta http-equiv='content-type' content='text/html; charset=UTF-8'/>
    <title>From Info Windows to a Database: Saving User-Added Form Data</title>
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
    <div id='map' height='460px' width='100%' ></div>
    <div id='form'>
      <table>
       <tr><td>Name:</td> <td><input type='text' id='name'/> </td> </tr>
      <tr><td>Address:</td> <td><input type='text' id='address'/> </td> </tr>
      <tr><td>Type:</td> <td><select id='type'> +
                 <option value='bar' SELECTED>bar</option>
                 <option value='restaurant'>restaurant</option>
                 </select> </td></tr>
                 <tr><td></td><td><input type='button' value='Save' onclick='saveData()'/></td></tr>
      </table>
    </div>
    <div id='message'>Location saved</div>
    <script>
      var map;
      var marker;
      var infowindow;
      var messagewindow;

      function initMap() {
       
        map = new google.maps.Map(document.getElementById('map'), {
           zoom: 12,
            center: {lat: 42.8640117, lng: 74.5460088 }
        });
          var labels = 'DASTAN';

      
        var markers = locations.map(function(location, i) {
          return new google.maps.Marker({
            position: location,
          });
        });

        // Add a marker clusterer to manage the markers.
        var markerCluster = new MarkerClusterer(map, markers,
            {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});


        infowindow = new google.maps.InfoWindow({
          content: document.getElementById('form')
        });

        messagewindow = new google.maps.InfoWindow({
          content: document.getElementById('message')
        });

        google.maps.event.addListener(map, 'click', function(event) {
           placeMarker(event.latLng);


          google.maps.event.addListener(marker, 'click', function() {
            infowindow.open(map, marker);
          });
        });
      }
      function placeMarker(location) {
		  if (!marker || !marker.setPosition) {
		    marker = new google.maps.Marker({
		      position: location,
		      map: map,
		    });
		  } else {
		    marker.setPosition(location);
		  }
		  if (!!infowindow && !!infowindow.close) {
		    infowindow.close();
		  }
		 
		  infowindow.open(map, marker);
	}
       var locations = $json_encoded

      function saveData() {

        var name = escape(document.getElementById('name').value);
        var address = escape(document.getElementById('address').value);
        var type = document.getElementById('type').value;
        var latlng = marker.getPosition();
        var url = 'phpsqlinfo_addrow.php?name=' + name + '&address=' + address +
                  '&type=' + type + '&lat=' + latlng.lat() + '&lng=' + latlng.lng();

         infowindow.close();
		messagewindow.open(map, marker);
		marker = new google.maps.Marker({

            position: event.latLng,
            map: map

          });
 		
   		

        downloadUrl(url, function(data, responseCode) {

          if (responseCode == 200 && data.length <= 1) {
           
            
          }
        });
        
      }

      function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;

        request.onreadystatechange = function() {
          if (request.readyState == 4) {
            request.onreadystatechange = doNothing;
            callback(request.responseText, request.status);
          }
        };

        request.open('GET', url, true);
        request.send(null);
      }

      function doNothing () {
      }

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
