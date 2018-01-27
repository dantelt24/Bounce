<?php
session_start();
$user_Id = $_SESSION['devId'];

include '../inc/conn_mysqli.php';

$sql = "SELECT * FROM `b_user_tracking` WHERE `user_id` = '$user_Id' ORDER BY time DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		$lat = $row["lat"];
		$lon = $row["lon"];
		$timeS = $row["time"];
    }
} else {
    echo "0 results";
}
$conn->close();

// get obstructions
include '../inc/conn_mysqli.php';
$sql = "SELECT * FROM m_obstruction WHERE confirmed = 1";
$result = $conn->query($sql);
$x=1;
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
    	${'lat' . $x} = $row["lat"];
		${'lon' . $x} = $row["lon"];
		${'priority' . $x} = $row["priority"];
		${'details' . $x} = $row["details"];
		$x++;		
    }
	
} else {
    echo "0 results";
}
$conn->close();


// get safezones
include '../inc/conn_mysqli.php';
$sql = "SELECT * FROM m_safezone WHERE active = 1";
$result = $conn->query($sql);
$a=1;
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
    	${'sz_lat' . $a} = $row["lat"];
		${'sz_lon' . $a} = $row["lon"];
		${'sz_name' . $a} = $row["name"];
		$a++;		
    }
	
} else {
    echo "0 results";
}
$conn->close();
?>

<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Directions service</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
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
      #floating-panel {
        position: absolute;
        top: 10px;
        left: 25%;
        z-index: 5;
        background-color: #fff;
        padding: 5px;
        border: 1px solid #999;
        text-align: center;
        font-family: 'Roboto','sans-serif';
        line-height: 30px;
        padding-left: 10px;
      }
    </style>
    

  </head>
  <body>



    <div id="floating-panel">
    <b>Start: </b>
    <select id="start">
      <option value="36.6522956,-121.7969917">Current Location</option>
    </select>
    <b>End: </b>
    <select id="end">
      <option value="36.6520632,121.7874075">American Medical Response</option>
      <option value="36.6080988,-121.8455698">Seaside Immediate Medical Care</option>
    </select>
    </div>
    <div id="map"></div>
    <div id="scriptEcho"></div>	
    <?php echo "
    <script>
      function initMap() {
        var directionsService = new google.maps.DirectionsService;
        var directionsDisplay = new google.maps.DirectionsRenderer;
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 7,
          center: {lat: ".$lat.", lng: ".$lon."}
        });
        directionsDisplay.setMap(map);
        

        var onChangeHandler = function() {
          calculateAndDisplayRoute(directionsService, directionsDisplay);
        };
        document.getElementById('start').addEventListener('change', onChangeHandler);
        document.getElementById('end').addEventListener('change', onChangeHandler);
        var pinColor = 'FE7569';
        ";
		
	$totalObs = $x-1;	
	    $y=1;
		while($y <= $totalObs) {
				$latVar = ${"lat" . $y};
				$lonVar = ${"lon" . $y};	
          		echo "var obst".$y." = {lat: ".$latVar.", lng: ".$lonVar."};
          		var marker".$y." = new google.maps.Marker({
         		 position: obst".$y.",
          		map: map,
          		title: 'Hello World!'
          		});";
          		echo "console.log(".$y++.");";
          		
          		
          	}
          	
          	
	$totalSz = $a-1;	
	    $b=1;
		while($b <= $totalSz) {
				$sz_latVar = ${"sz_lat" . $b};
				$sz_lonVar = ${"sz_lon" . $b};	
          		echo "var safe".$b." = {lat: ".$sz_latVar.", lng: ".$sz_lonVar."};
          		var marker".$b." = new google.maps.Marker({
         		 position: safe".$b.",
          		map: map,
          		title: 'Hello World!'
          		});";
          		echo "console.log(".$b++.");";
          		
          		
          	}          	
          
     echo "}

      function calculateAndDisplayRoute(directionsService, directionsDisplay) {
        directionsService.route({
          origin: document.getElementById('start').value,
          destination: document.getElementById('end').value,
          travelMode: 'DRIVING'
        }, function(response, status) {
          if (status === 'OK') {
            directionsDisplay.setDirections(response);
          } else {
            window.alert('Directions request failed due to ' + status);
          }
        });
      }
      
    </script>"
    ?>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDZzWdPfvDGrYEnEla1G5MYEz5fDiMs0RI&callback=initMap">
    </script>
  </body>
</html>