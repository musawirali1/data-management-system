<?php
include('../db-connection.php'); 
include('../function.php');
$sql = "SELECT * FROM teachers";
// Execute the SQL query
$result = $conn->query($sql);

// Process the result set
if ($result->num_rows > 0) {
  $teachers = array();
  // Output data of each row
  while($row = $result->fetch_assoc()) {
    $teachers[$row["id"]] = array(
      "name"=>$row["name"],
      "subject"=>$row["subject"],
      "email"=>$row["email"],
      "phone"=>$row["phone"],
      "created_at"=>custom_time_convert($row["created_at"]),
      "updated_at"=>custom_time_convert($row["updated_at"]) 
      );
  }
} else {
  echo "0 results";
}


$json_string = json_encode($teachers);
echo $json_string;