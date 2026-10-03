<?php

include('../db-connection.php');

// User ki required information lo
$sql = "SELECT
            id,
            User_Name,
            User_Type,
            User_Status
        FROM users";

$result = $conn->query($sql);

$users = array();

if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {

        $users[] = array(
            "id"     => $row["id"],
            "name"   => $row["User_Name"],
            "type"   => $row["User_Type"],
            "status" => $row["User_Status"]
        );
    }
}

// JSON Return
echo json_encode($users);

?>