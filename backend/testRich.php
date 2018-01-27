<?php

include '../inc/conn_mysqli.php';

$sql = "SELECT * FROM m_obstruction WHERE confirmed = 1";
$result = $conn->query($sql);

if ($result->num_rows > 0){
    $arr = [];
    $inc = 0;
    while ($row = $result->fetch_assoc()) {
        # add values to rows
        $jsonArrayObject = (array(
            'lat' => $row["lat"],
            'lon' => $row["lon"],
            'priority' => $row["address"],
            'type' => $row["type"],
            'details' => $row["details"],
            'confirmed' => $row["confirmed"]));
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
