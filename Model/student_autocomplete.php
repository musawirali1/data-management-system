<?php

include('../db-connection.php');


$search = $_GET['search'];


$sql = "SELECT id,name 
        FROM students
        WHERE name LIKE '%$search%'";

$result = $conn->query($sql);
$students = array();
while($row = $result->fetch_assoc()){

    $students[] = $row;
}
echo json_encode($students);


$conn->close();

?>