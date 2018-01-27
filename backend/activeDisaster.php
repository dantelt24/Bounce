<?php

	include '../inc/conn_mysqli.php';

$sql = "SELECT * FROM b_disaster";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		$active = $row["active"];
    }
} else {
    echo "0 results";
}
$conn->close();


    echo "<script type='text/javascript'>var active = $active;</script>";  
?>