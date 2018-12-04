<!DOCTYPE html>
<html>
<body>
	<div id="demo">
<button type="button" onclick="loadXMLDoc()">Change Content</button>
</div>
<script>
function loadXMLDoc() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4) {
    	if (this.status == 200) {
      document.write(10);
  }

  else {
    	document.write(20);
    }
    }
    
  };
  xhttp.open("GET", "testhttp2.php", true);
  xhttp.send();
}
</script>
</body>
</html>