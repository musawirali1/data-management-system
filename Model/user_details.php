<?php

include('../db-connection.php');
include('../function.php');

// Users Table se sari information lo
$sql = "SELECT * FROM users";

$result = $conn->query($sql);

$users = array();

if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {

        $users[$row["id"]] = array(

            // User Name
            "name" => $row["User_Name"],

            // Email
            "email" => $row["User_Email"],

            // Password
            "password" => $row["User_Password"],

            // User Type
            "type" => $row["User_Type"],

            // User Status
            "status" => $row["User_Status"],

            // Created Date
            "created_at" => custom_time_convert($row["created_at"]),

            // Updated Date
            "updated_at" => custom_time_convert($row["updated_at"])
        );
    }
}

// JSON Return
echo json_encode($users);

?>