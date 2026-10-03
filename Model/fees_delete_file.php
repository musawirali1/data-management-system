<?php
include('../db-connection.php');

$sql = "DELETE FROM fees WHERE id=".$_GET['id'];

if($conn->query($sql) === TRUE){
    echo "success";
}
else{
    echo "error";
}

$conn->close();
?>