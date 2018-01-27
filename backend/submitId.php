<?php
session_start();

$_SESSION['devId'] = "sessionNotLoaded";
if (isset($_GET['id'])) {
    	
	$deviceIdVar= $_GET['id'];
	$_SESSION['devId']=$_GET['id'];
		
	include '../inc/conn_mysqli.php';

	// prepare and bind
	$stmt = $conn->prepare("INSERT INTO b_user (user_id) VALUES (?)");
	$stmt->bind_param("s", $deviceId);
	
	// set parameters and execute
	$deviceId = $deviceIdVar;
	$stmt->execute();
	$stmt->close();
	$conn->close();

}else{
  echo "FAILED - > ERROR LOGGED";
}
?>