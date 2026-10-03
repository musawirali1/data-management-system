<?php
include('../db-connection.php'); 
$sql = "SELECT id, name from teachers";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $teachers = array();
  // Output data of each row
  while($row = $result->fetch_assoc()) {
    $teachers[] = array( "id"=>$row["id"], "name"=>$row["name"], );
  }
} else {
  echo "0 results";
}

$json_string = json_encode($teachers);
echo $json_string;
?>