<?php
include('connect.php');

header('Content-Type: application/json');

$sql = "SELECT * FROM `employee`";
$result = mysqli_query($con, $sql);

$json_array = array();
while ($row = $result->fetch_assoc()) {
   $json_array[] = $row;
}

echo json_encode($json_array);

// print_r( json_encode($row));

?>
