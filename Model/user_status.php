<?php

require_once "../Auth/check_login.php";
include("../db-connection.php");

// POST se values lo
$id = $_POST['id'] ?? '';
$status = $_POST['status'] ?? '';

// Check ID
if ($id === '') {
    echo "User ID is missing.";
    exit();
}


// 0 = Inactive
// 1 = Active
// 2 = Pending
if (!in_array((int)$status, [0, 1], true)) {
    echo "Invalid status.";
    exit();
}

// User Status Update
$stmt = $conn->prepare("
    UPDATE users
    SET User_Status = ?, updated_at = NOW()
    WHERE id = ?
");

if ($stmt === false) {
    echo $conn->error;
    exit();
}

// status = integer
// id = integer
$status = (int)$status;
$id = (int)$id;

$stmt->bind_param("ii", $status, $id);

if ($stmt->execute()) {
    echo "success";
} else {
    echo $stmt->error;
}

$stmt->close();

?>