<?php
include('../db-connection.php'); 

$sql = "DELETE FROM teachers WHERE id=".$_GET['id'];


if ($conn->query($sql) === TRUE) {
  $result = "Record deleted successfully";
} else {
  $result = "Error deleting record: " . $conn->error;
}
echo $result;
$conn->close();

?>
