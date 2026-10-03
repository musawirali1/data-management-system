<?php

        include('../db-connection.php');


        $id = $_POST['id'];
        $amount = $_POST['amount'];
        $date = $_POST['date'];



        $sql = "
        UPDATE fees SET
        amount='$amount',
        fee_date='$date',
        updated_at=NOW()

        WHERE id='$id'";

        if($conn->query($sql) === TRUE){

            echo "success";
        }
        else{

            echo "error";
        }
        $conn->close();

?>