<?php


        include('../db-connection.php'); 
        
        include("../function.php");
   
        $sql = "SELECT 
                fees.id, 
                students.name, 
                fees.amount, 
                fees.fee_date,
                fees.created_at,
                fees.updated_at

                FROM fees 

                JOIN students 
                ON fees.student_id = students.id";


        $result = $conn->query($sql);

        $fees = array();


        while($row = $result->fetch_assoc()){


            $row["created_at"] = custom_time_convert($row["created_at"]);
            $row["updated_at"] = custom_time_convert($row["updated_at"]);
            $fees[$row["id"]] = $row;

        }


        echo json_encode($fees);

?>