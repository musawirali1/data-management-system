<?php
require_once "../Auth/check_login.php";
include('../db-connection.php');

$id = $_GET['id'];
$setting_name = $_GET['setting_name'];
$setting_value = $_GET['setting_value'];

$stmt = $conn->prepare("UPDATE settings SET setting_name = ?, setting_value = ? WHERE id = ?");
$stmt->bind_param("ssi", $setting_name, $setting_value, $id);

if ($stmt->execute() === TRUE) {
     header("Location: " . $_SERVER['HTTP_REFERER']);
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
