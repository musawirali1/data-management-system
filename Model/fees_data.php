<?php
include('../db-connection.php');

$sql = "SELECT fees.id, students.name, fees.amount, fees.fee_date 
        FROM fees 
        JOIN students ON fees.student_id = students.id";

$result = $conn->query($sql);

$fees = array();

while($row = $result->fetch_assoc()){
    $fees[] = $row;
}

echo json_encode($fees);
?>