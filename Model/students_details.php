<?php
require_once "../Auth/check_login.php";
include("../db-connection.php");
include("../function.php");

$sql = "SELECT * FROM students";
$result = $conn->query($sql);

$students = array();

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $students[$row["id"]] = array(
      "name"=>$row["name"],
      "roll"=>$row["roll_no"],
      "father"=>$row["father_name"],
      "address"=>$row["address"],
      "created_at"=>custom_time_convert($row["created_at"]),
      "updated_at"=>custom_time_convert($row["updated_at"])
      );
  }
}

$json_string = json_encode($students);
echo $json_string;
?>
