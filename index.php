<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
require_once ("config.php");
header("Content-Type: text/html; Charset=UTF-8");
if($_GET['lg'] == 1) {
   unset($_SESSION['username']);
   unset($_SESSION['id']);
   session_destroy();
}
$conn;
$userid = $_SESSION['id'];
$sesusername = $_SESSION['username'];
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
if (empty($_POST) or 
$_POST['region'] != "sverdlov" and $_POST['region'] != "oktyabr"
and $_POST['region'] != "lenin" and $_POST['region'] != "pervomay") {
  if ($_GET['mypoints'] == 1) {
  $result = mysqli_query($conn,"SELECT id, lat, lng,comments,level,name,region FROM markers where 
        userID = '$userid' "); 
  }
  else {
  $result = mysqli_query($conn,"SELECT id, lat, lng,comments,level,name,region FROM markers");   
  }
} 
else {
  $region = $_POST['region'];
  if ($_GET['mypoints'] == 1) {
    $result = mysqli_query($conn,"SELECT id, lat, lng,comments,level,name,region FROM markers where region = 
    '$region' and userID = '$userid' "); 
  }
  else {
    $result = mysqli_query($conn,"SELECT id, lat, lng,comments,level,name,region FROM markers where region = 
    '$region'");
  }
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
  <head>
  <title>Welcome to ZVERI</title>
  <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
  <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
  <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
</head>
<body>
<div style = 'float:right' class='btn-group'>
  <a href='login.php' class='btn btn-info' role='button'>   Login</a> 
   &nbsp;
  <a href='regist.php' class='btn btn-info' role='button'>   Register   </a>
  &nbsp;
  <a href='AboutUs.php' class='btn btn-warning' role='button'>About us</a>
</div>

  <form action='' method='POST'>

    <select class='col-lg-1' name = 'region' id = 'select'>
       <option value='' selected disabled hidden>$showreg</option>
       <option value = 'all'> All regions </option>
      <option value = 'sverdlov'>Sverdlov</option>
      <option value = 'oktyabr'>Oktyabr</option>
      <option value = 'pervomay'>Pervomay</option>
      <option value = 'lenin'>Lenin</option>
      <input type='submit' name='submit' value = 'select region' class='btn btn-default'>
    </select>

    
  </form>

</body>
</html>
");
  $html = "<!DOCTYPE html>
    <head>
    <meta name='viewport' content='initial-scale=1.0, user-scalable=no' />
    <meta http-equiv='content-type' content='text/html; charset=utf-8'/>
    <title>From Info Windows to a Database: Saving User-Added Form Data</title>
    <style>
      #map {
        height: 100%;
      }
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
  &nbsp;
  ");
if ($_GET['mypoints'] == 1) {
  print("<a href = 'index.php?mypoints=0'> View All Points </a>");
}
else {
  print ("<a href = 'index.php?mypoints=1'> View Your Points </a>");
}
print("
</div>  
<div class='col-xs-1'>
  <form action='' method='POST'>
    <select name = 'region' class='form-control'>
       <option value='' selected disabled hidden>$showreg</option>
       <option value = 'all'> All regions </option>
      <option value = 'sverdlov'>Sverdlov</option>
      <option value = 'oktyabr'>Oktyabr</option>
      <option value = 'pervomay'>Pervomay</option>
      <option value = 'lenin'>Lenin</option>
    </select>
    <input type='submit' name='submit' value = 'select region'>
  </form>
</body>
</div>
</html>
");
    $html = "<!DOCTYPE html>
    <head>
    <meta name='viewport' content='initial-scale=1.0, user-scalable=no' />
    <meta http-equiv='content-type' content='text/html; charset=UTF-8'/>
    <title>Dastan, you suck</title>
    <style>
      #map {
        height: 100%;
      }
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
          content: messageStr
        });
      }
      function initListeners(){
          google.maps.event.addListener(map, 'click', function(event) {
          
             placeMarker(event.latLng);
             google.maps.event.addListener(marker, 'click', function() {
                infowindow.open(map, marker);
            });
        });
        var markers = markersInfo.map(function(location, i) {
           var lab = location.level.toString();
           
           var markerPointed = new google.maps.Marker({
             position: ({lat: location.lat,lng: location.lng}),
             icon: 'red_trash.png'
          });
         
          markerPointed.addListener('click', function(){
             
             if (statewindow ) {
              
                statewindow.close();
              }
              if (location.name == '$sesusername') {
                  statewindow= new google.maps.InfoWindow({
               content: 
               '<h3> Comment:' + location.comments + 
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
        var comment = document.getElementById('comment').value;
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
            
          var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4) {
      if (xhttp.status == 205) {
      messagewindow.setContent('Successfully saved');
      setTimeout(function(){
   window.location.reload(1);
}, 2500);
  }
  else if (xhttp.status == 201) {
      messagewindow.setContent('Your point placed does not belong to Bishkek');
      setTimeout(function(){
   window.location.reload(1);
}, 2500);
  }
  if (xhttp.status == 202) {
      messagewindow.setContent('You cannot submit now, you are on cooldown, check your office');
    
      setTimeout(function(){
   window.location.reload(1);
}, 2500);
  }
    }
    
  };
  xhttp.open('GET', url, true);
  xhttp.send();
  infowindow.close();
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
        
        var url = 'http://5.59.11.66/~zveri/pointManip.php?&username=$sesusername&action=0&lat=' + latlng.lat() + '&lng=' + latlng.lng();
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
         if (xhttp.readyState == 4) {
        if (xhttp.status == 200) {
        statewindow.setContent('Your point has been deleted ');
        setTimeout(function(){
   window.location.reload(1);
}, 2500);
       }
        else {
      statewindow.setContent('There was some problem ' + url);
    }
    }
    
  };
  xhttp.open('GET', url, true);
  xhttp.send();
      }
      function reportPoint() {
        var latlng = statewindow.getPosition();
        var url = 'http://5.59.11.66/~zveri/pointManip.php?&username=$sesusername&action=1&lat=' + latlng.lat() + '&lng=' + latlng.lng();
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
         if (xhttp.readyState == 4) {
        if (xhttp.status == 200) {
        statewindow.setContent('Your point has been deleted ');
        setTimeout(function(){
   window.location.reload(1);
}, 2500);
       }
        else if (xhttp.status == 201) {
      statewindow.setContent('One person can only report a point once');
    }
      else if (xhttp.status == 202) {
        statewindow.setContent('Treshold for deletion has been reached, point has been deleted');
      }
      else if (xhttp.status == 203) {
        statewindow.setContent('Your report has been saved');
      }
    }
    
  };
  xhttp.open('GET', url, true);
  xhttp.send();
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
