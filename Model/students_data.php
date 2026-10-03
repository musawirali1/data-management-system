<?php
include('../db-connection.php');


$sql = "SELECT id, name from students";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $students = array();
  // Output data of each row
  while($row = $result->fetch_assoc()) {
    $students[] = array( "id"=>$row["id"], "name"=>$row["name"], );
  }
} else {
  echo "0 results";
}

$json_string = json_encode($students);
echo $json_string;
?>