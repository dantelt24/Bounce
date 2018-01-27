<?php
$time = array(17, 13, 11, 27, 33);


function average($time) {
    return ceil(array_sum($time) / count($time));
}

function Template($people, $shelter, $Ttime,$shelter_id) {
    $shelter_capacity = $people/$shelter;
    $shelter_time_eff = $shelter_capacity/ ($Ttime * $Ttime);
    $shelter_capacity_eff = ($people * $shelter_time_eff)/$shelter;
    if($shelter_capacity > .9)
    {
        return-1;
    }
   return $array = array (
        $shelter_time_eff,
        $shelter_capacity_eff,
        $shelter_capacity,
        $shelter_id
        );
    
}
function Best_shelter($time,$shelter_id)
{
    for($ii = 0;$ii<=5;$ii++)
    {
    	$shelter_id = rand(1,5);
        $temp= Template(rand(80,1000),
                    rand(200,3000),
                    $time,
                    $shelter_id);
    if($temp==-1)
     {}
      
    else 
        {
    $data[] = $temp;
        }
    
    }
    
foreach ($data as $temp)
{
  $s[] = $temp['x'];
}
array_multisort($s, SORT_NUMERIC, $data);
return end($data[3]);

}


//class heaps extends SplHeap {}

?>

<html><body>
<?php
// foreach(Best_shelter() as $value)
// {
//     echo $value;
// }
for($ii=0;$ii<12;$ii++)
{
    $temp = rand(1,5);
    $time[] = $temp;
    
}
echo Best_shelter(average($time), $shelter_id);
?>
</body>
</html>