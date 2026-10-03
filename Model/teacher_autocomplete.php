<?php

include('../db-connection.php');


$search = $_GET['search'];


$sql = "SELECT id,name 
        FROM teachers
        WHERE name LIKE '%$search%'";

$result = $conn->query($sql);
$teachers = array();
while($row = $result->fetch_assoc()){

    $teachers[] = $row;
}
echo json_encode($teachers);


$conn->close();

?>