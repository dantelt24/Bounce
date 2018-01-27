<?php

include '../inc/conn_mysqli.php';

$sql = "SELECT * FROM m_safezone WHERE active = 1";
$result = $conn->query($sql);

if ($result->num_rows > 0){
    $arr = [];
    $inc = 0;
    while ($row = $result->fetch_assoc()) {
        # add values to rows
        $jsonArrayObject = (array(
            'lat' => $row["lat"],
            'lon' => $row["lon"],
            'name' => $row["name"],
            'count' => $row["count"],
            'max' => $row["max"],
            'en_route' => $row["en_route"]));
        $arr[$inc] = $jsonArrayObject;
        $inc++;
    }
    $json_array = json_encode($arr);
    echo $json_array;
}
else{
    echo "0 results";
}

?>