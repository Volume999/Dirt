<?php
session_start();
require_once ("config.php");
  if($_GET['lg'] == 1) {
      unset($_SESSION['username']);
    unset($_SESSION['id']);
  }
  $conn;
  if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
  }
  if (empty($_POST) or $_POST['region'] != "sverdlov" and $_POST['region'] != "oktyabr" and $_POST['region'] != "lenin" and $_POST['region'] != "pervomay") {
  $result = mysqli_query($conn,"SELECT id, lat, lng,comments,level,name,region FROM markers");   
  }
  else {
    $region = $_POST['region'];
    $result = mysqli_query($conn,"SELECT id, lat, lng,comments,level,name,region FROM markers where region = '$region' "); 
  }
  while($row = mysqli_fetch_assoc( $result)){
      $json[] = $row;
  }

  $json_encoded = json_encode($json,JSON_NUMERIC_CHECK  );



if (empty($_SESSION)) {
  $showreg = $_POST['region'];
  if (strlen($showreg) == 0) {
    $showreg = "All Regions";
  }
print ("<html>
<body>
<div style = 'float:right'>
  <a href='login.php'>   Login</a> 
   &nbsp;
  <a href='regist.php'>   Register   </a>
  &nbsp;
  <a href='AboutUs.php'>About us</a>
</div>
  <form action='' method='POST'>
    <select name = 'region'>
       <option value='' selected disabled hidden>$showreg</option>
      <option value = 'sverdlov'>Sverdlov</option>
      <option value = 'oktyabr'>Oktyabr</option>
      <option value = 'pervomay'>Pervomay</option>
      <option value = 'lenin'>Lenin</option>
    </select>
    <input type='submit' name='submit' value = 'select region'>
  </form>
</body>
</html>
");

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
   
   
    <script>

      var map;
      var marker;
      var infowindow;
      var messagewindow;
      var statewindow = null;
      var labels = '12345';


      function initMap() {

        

        map = new google.maps.Map(document.getElementById('map'), {
           zoom: 12,
            center: {lat: 42.8640117, lng: 74.5460088 }
         });
        initWindows();
        initListeners();
      }
      function initWindows(){
    var formStr = `" . FORM_FOR_INPUT . "`;
        var messageStr = `" . MESSAGE_LOCATION_SAVED . "`
        infowindow = new google.maps.InfoWindow({
          
            content: formStr

        });


        messagewindow = new google.maps.InfoWindow({
          content: document.getElementById('message')
        });

      }

      function initListeners(){
          google.maps.event.addListener(map, 'click', function(event) {
          
             placeMarker(event.latLng);

             google.maps.event.addListener(marker, 'click', function() {
                infowindow.open(map, marker);

            });

        });
        var prevMarker;
        var markers = markersInfo.map(function(location, i) {
           var lab = location.level.toString();
           
           var markerPointed = new google.maps.Marker({
             position: ({lat: location.lat,lng: location.lng}),
             icon: 'red_trash.png'
          });
         
          markerPointed.addListener('click', function(){
             if(statewindow) {
              statewindow.close();
             }
             
              statewindow= new google.maps.InfoWindow({
               content: '<h3> Comment:' + location.comments + 
               '<br>Level of Pollution: ' + location.level.toString()  +
               '<br>User:' + location.name + 
                '<br>Region:' + location.region + '</h3>'
                
                 
               
             })
           
             prevMarker = this;
              statewindow.open(map,markerPointed);
              
          });

          return markerPointed; 
        });

          // Add a marker clusterer to manage the markers.
        var markerCluster = new MarkerClusterer(map, markers,
            {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});


      }
      
       var markersInfo = $json_encoded


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

      }

    
      function doNothing () {
      }

    </script>
     <script src='https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js'>
    </script>
    <script async defer
    src='https://maps.googleapis.com/maps/api/js?key=AIzaSyBlLms-yD7lNgRk3z4LIpv79WvNTP2aY1I&callback=initMap'>
    </script>
}
</body>
</html>";

  echo $html;
}
else {
  $showreg = $_POST['region'];
  if (strlen($showreg) == 0) {
    $showreg = "All Regions";
  }
print ("<html>
<body>
<div style = 'float:right'>
  <a href='userOffice.php'>Your office</a> 
   &nbsp;
  <a href='index.php?lg=1'>  Logout   </a>
  &nbsp;
  <a href='AboutUs.php'>About us</a>
</div>  
  <form action='' method='POST'>
    <select name = 'region'>
       <option value='' selected disabled hidden>$showreg</option>
      <option value = 'sverdlov'>Sverdlov</option>
      <option value = 'oktyabr'>Oktyabr</option>
      <option value = 'pervomay'>Pervomay</option>
      <option value = 'lenin'>Lenin</option>
    </select>
    <input type='submit' name='submit' value = 'select region'>
  </form>



</body>
</html>
");
  
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
   
   
    <script>

      var map;
      var marker;
      var infowindow;
      var messagewindow;
      var statewindow = null;
      var labels = '12345';


      function initMap() {

        

        map = new google.maps.Map(document.getElementById('map'), {
           zoom: 12,
            center: {lat: 42.8640117, lng: 74.5460088 }
         });
        initWindows();
        initListeners();
      }
      function initWindows(){
    var formStr = `" . FORM_FOR_INPUT . "`;
        var messageStr = `" . MESSAGE_LOCATION_SAVED . "`
        infowindow = new google.maps.InfoWindow({
          
            content: formStr

        });


        messagewindow = new google.maps.InfoWindow({
          content: document.getElementById('message')
        });

      }

      function initListeners(){
          google.maps.event.addListener(map, 'click', function(event) {
          
             placeMarker(event.latLng);

             google.maps.event.addListener(marker, 'click', function() {
                infowindow.open(map, marker);

            });

        });
        var prevMarker;
        var markers = markersInfo.map(function(location, i) {
           var lab = location.level.toString();
           
           var markerPointed = new google.maps.Marker({
             position: ({lat: location.lat,lng: location.lng}),
             icon: 'red_trash.png'
          });
         
          markerPointed.addListener('click', function(){
             
             if (statewindow ) {
              if (prevMarker == this) {
              var url = 'http://5.59.11.66/~zveri/details.php?id=' + location.id + '&observer=' + location.name;
              window.location.replace( url );
            }
                statewindow.close();

              }
              if (location.name == ";
                $html .= $_SESSION['username'];
                $html .= "
                 ) {
                  statewindow= new google.maps.InfoWindow({
               content: '<h3> Comment:' + location.comments + 
               '<br>Level of Pollution: ' + location.level.toString()  +
               '<br>User:' + location.name + 
                '<br>Region:' + location.region + '</h3>'
                + '<button onclick = deletePoint()> Delete your point </button>'
               })
                
              } 
              else {
             
              statewindow= new google.maps.InfoWindow({
               content: '<h3> Comment:' + location.comments + 
               '<br>Level of Pollution: ' + location.level.toString()  +
               '<br>User:' + location.name + 
                '<br>Region:' + location.region + '</h3>'
                + '<button onclick = reportPoint()> Mark as cleaned </button>' 
                 
               
             })
           }
             prevMarker = this;
              statewindow.open(map,markerPointed);
              
          });

          return markerPointed; 
        });

          // Add a marker clusterer to manage the markers.
        var markerCluster = new MarkerClusterer(map, markers,
            {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});


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
        if (infowindow && infowindow.close) {
          infowindow.close();
        }
           

        //  infowindow.open(map, marker);
      }
       var markersInfo = $json_encoded

      function saveData() {

        var comment = escape(document.getElementById('comment').value);
        var latlng = marker.getPosition();
        var levels = document.getElementsByName('lev');
        var level = 3;

        for (var i = 0, length = levels.length; i < length; i++)
      {
       if (levels[i].checked)
       {

        level = levels[i].value;
        break;
       }
    }
        
        var url = 'http://5.59.11.66/~zveri/pointPlace.php?comment=' + comment +  '&level=' + level +'&lat=' + latlng.lat() + '&lng=' + latlng.lng();

         messagewindow.open(map, marker);
          marker = new google.maps.Marker({

            position: event.latLng,
            map: map

          });
      window.location.replace( url );      

        downloadUrl(url, function(data, responseCode) {

          if (responseCode == 200 && data.length <= 1) {
            infowindow.close();
                       
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

      }

      function deletePoint() {
        var latlng = statewindow.getPosition();
        statewindow.setContent('Your point has been deleted ');
        var url = 'http://5.59.11.66/~zveri/pointManip.php?&username=";
        $username = $_SESSION['username'];
        $html .= "$username&action=0&lat=' + latlng.lat() + '&lng=' + latlng.lng();
        window.location.replace( url );
      }
      function reportPoint() {
        var latlng = statewindow.getPosition();
        var url = 'http://5.59.11.66/~zveri/pointManip.php?&username=";
        $username = $_SESSION['username'];
        $html .= "$username&action=1&lat=' + latlng.lat() + '&lng=' + latlng.lng();
        window.location.replace( url );
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
}

?>
