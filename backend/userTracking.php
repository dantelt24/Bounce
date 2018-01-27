<?php
session_start();

if (isset($_GET['lat'])) {
    	
	$latVar= $_GET['lat'];
	$lonVar= $_GET['lon'];
	$userIdVar = $_SESSION['devId'];
		
	include '../inc/conn_mysqli.php';

	// prepare and bind
	$stmt = $conn->prepare("INSERT INTO b_user_tracking (lat,lon,user_id) VALUES (?,?,?)");
	$stmt->bind_param("sss", $lat, $lon, $userId);
	
	// set parameters and execute
	$lat = $latVar;
	$lon = $lonVar;
	$userId = $userIdVar;
	$stmt->execute();
	$stmt->close();
	$conn->close();

} else {
   echo "FAILED - > ERROR LOGGED";
}
?>