<?php
require_once("config.php");
// Tests
$pointLocation = new pointLocation();
$points = array("42.943716 74.613839
","42.940522 74.634982
","42.904062 74.647146
","42.877919 74.683079
","42.890903 74.665602
","42.872227 74.689873
","42.861375 74.645708
");
$sverdlov;// The last point's coordinates must be the same as the first one's, to "close the loop"
foreach($points as $key => $point) {
    echo "point " . ($key+1) . " ($point): " . $pointLocation->pointInPolygon($point, $sverdlov) . "<br>";
}
// Results 
/*
This will output:
point 1 (50 70): vertex
point 2 (70 40): inside
point 3 (-20 30): inside
point 4 (100 10): outside
point 5 (-10 -10): outside
point 6 (40 -20): inside
point 7 (110 -20): boundary
*/