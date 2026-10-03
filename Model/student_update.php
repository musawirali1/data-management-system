<?php

include('../db-connection.php');


        $id = $_POST['id'];
        $name = $_POST['name'];
        $roll = $_POST['roll'];
        $father = $_POST['father'];
        $address = $_POST['address'];

        $sql = "
        UPDATE students SET
        name='$name',
        roll_no='$roll',
        father_name='$father',
        address='$address',
        updated_at=NOW()

        WHERE id='$id'";

        if($conn->query($sql)){
        echo "success";
        }
        else{
        echo "error";

        }



?>