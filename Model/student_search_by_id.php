<?php

include('../db-connection.php');



$id = $_GET['id'];
$sql = "SELECT * FROM students WHERE id='$id'";

$result = $conn->query($sql);
$row = $result->fetch_assoc();
echo json_encode($row);
$conn->close();

?>