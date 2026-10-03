<?php

include("../db-connection.php");

// ==============================
// Receive Form Data
// ==============================

$id       = $_POST['id'];
$name     = $_POST['name'];
$email    = $_POST['email'];
$password = trim($_POST['password']);
$type     = $_POST['type'];

// ==============================
// Check Password
// ==============================

if(!empty($password)){

    // Encrypt New Password
    $password = sha1($password);

    // Update with Password
    $sql = "
    UPDATE users SET

        User_Name='$name',
        User_Email='$email',
        User_Password='$password',
        User_Type='$type',
        updated_at=NOW()

        WHERE id='$id'";

}else{

    // Update without Password
    $sql = "
    UPDATE users SET

        User_Name='$name',
        User_Email='$email',
        User_Type='$type',
        updated_at=NOW()

        WHERE id='$id'";

}

// ==============================
// Execute Query
// ==============================

if($conn->query($sql)){

    echo "success";

}else{

    echo "error";

}

?>