<?php

include('../db-connection.php');


$search=$_GET['search'];

$sql="
SELECT id, name FROM students
WHERE name LIKE '%$search%'";

$result=mysqli_query($conn,$sql);
$data=[];

while($row=mysqli_fetch_assoc($result)){

$data[]=$row;

}

echo json_encode($data);

?>