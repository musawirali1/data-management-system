<?php

include('../db-connection.php');
$search = $_GET['search'];

$sql = "SELECT * FROM users 
WHERE User_Name LIKE '%$search%'";

$result = $conn->query($sql);

$users = array();

while($row = $result->fetch_assoc()){

    $users[] = $row;

}

echo json_encode($users);


$conn->close();

?>