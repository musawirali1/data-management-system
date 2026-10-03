<?php

include('../db-connection.php');

$student_id = $_GET['student_id'];

$sql = "
SELECT fees.id,
       students.name,
       fees.amount,
       fees.fee_date
FROM fees
JOIN students
ON fees.student_id = students.id
WHERE students.id = '$student_id'
";

$result = mysqli_query($conn,$sql);

$data = [];

while($row = mysqli_fetch_assoc($result))
{
    $data[] = $row;
}

echo json_encode($data);

?>