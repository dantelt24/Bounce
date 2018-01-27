<?php

include '../inc/conn_mysqli.php';

$sql = "SELECT * FROM m_safezone WHERE active = 1";
$result = $conn->query($sql);
$x=1;

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
    	${'lat' . $x} = $row["lat"];
		${'lon' . $x} = $row["lon"];
		${'name' . $x} = $row["name"];
		${'count' . $x} = $row["count"];
		${'max' . $x} = $row["max"];
		$x++;		
    }
	
} else {
    echo "0 results";
}
$conn->close();

$totalObs = $x-1;

?>
<head>
	<title>Get Safezones</title>
</head>

<body>
<?php
$y=1;
while($y <= $totalObs) {

	$latVar = ${"lat" . $y};
	$lonVar = ${"lon" . $y};
	$nameVar = ${"name" . $y};
	$countVar = ${"count" . $y};
	$maxVar = ${"max" . $y};
	// $detailEncode = json_encode($detVar);

echo '<script>

 
	var safezone'.$y.', lat'.$y.', lon'.$y.', name'.$y.', count'.$y.';
	safezone'.$y.' = { "lat":'.$latVar.', "lon":'.$lonVar.', "name":'.$nameVar.', "count":'.$countVar.' };
	lat'.$y.' = safezone'.$y.'.lat;
	lon'.$y.' = safezone'.$y.'.lon;
	name'.$y.' = safezone'.$y.'.name;
	count'.$y.' = safezone'.$y.'.count;
	
	</script>';
	$y++;
}
?>

</body>