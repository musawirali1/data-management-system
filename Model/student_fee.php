<?php

require_once "../Auth/check_login.php";
include('../db-connection.php');



$sql = "
SELECT
fees.id,
students.Student_Name AS name,
fees.amount,
fees.fee_date

FROM fees

INNER JOIN students

ON fees.student_id = students.id
";

$result = $conn->query($sql);

$data = [];

while($row = $result->fetch_assoc()){

$data[] = $row;

}

echo json_encode($data);

?>
