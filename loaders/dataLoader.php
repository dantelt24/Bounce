<?php
session_start();
$user_Id = $_SESSION['devId'];
// get user info
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


// get safezone
include '../inc/conn_mysqli.php';

$sql = "SELECT * FROM `m_safezone` WHERE `active` = 1";
$result = $conn->query($sql);
$x = 1;
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
    	${'id' . $x } = $row["id"];
		${'sz_lat' . $x } = $row["lat"];
		${'sz_lon' . $x } = $row["lon"];
		${'name' .$x } = $row["name"];
		${'count' .$x } = $row["count"];
		${'sz_max' .$x }  = $row["max"];
		${'en_route' .$x }= $row["en_route"];
		$x++;
    }
} else {
    echo "0 results";
}
$conn->close();
//https://maps.googleapis.com/maps/api/directions/json?origin=Toronto&destination=Montreal&key=AIzaSyDZzWdPfvDGrYEnEla1G5MYEz5fDiMs0RI



echo "<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>";



echo "<script async defer
        src='https://maps.googleapis.com/maps/api/js?key=AIzaSyDZzWdPfvDGrYEnEla1G5MYEz5fDiMs0RI&callback=initMap'>
</script>";



// echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
// 	<script>
// 		for(var i = 1; i <=' .$x.'; i++){
// 			var origin = new google.maps.LatLng(sz_lat+ i, sz_lon+i)
// 			console.log(origin);
// 		}
// 	</script>';
?>