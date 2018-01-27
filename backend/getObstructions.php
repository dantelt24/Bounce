<?php

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

$totalObs = $x-1;

$y=1;
while($y <= $totalObs) {
	
	$latVar = ${"lat" . $y};
	$lonVar = ${"lon" . $y};
	$detVar = ${"details" . $y};
	$priVar = ${"priority" . $y};
	$detailEncode = json_encode($detVar);
	
echo '<script>

 
	var obstruction'.$y.', lat'.$y.', lon'.$y.', priority'.$y.', details'.$y.';
	obstruction'.$y.' = { "lat":'.$latVar.', "lon":'.$lonVar.', "priority":'.$priVar.', "details":'.$detailEncode.' };
	lat'.$y.' = obstruction'.$y.'.lat;
	lon'.$y.' = obstruction'.$y.'.lon;
	priority'.$y.' = obstruction'.$y.'.priority;
	details'.$y.' = obstruction'.$y.'.details;
	
	</script>';
	$y++;
}
?>
