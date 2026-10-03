<?php

session_start();

include_once(__DIR__ . "/../../db-connection.php");


// CHECK LOGIN
if (!isset($_SESSION['user_id'])) {

    header("Location: ../Auth/login.php");
    exit;
}


// GET LOGGED-IN USER ID

$user_id = $_SESSION['user_id'];

// CHECK FORM SUBMISSION
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    header("Location: ../../profile.php");
    exit;
}


// GET FORM DATA

$user_name = trim($_POST['user_name'] ?? '');

$user_email = trim($_POST['user_email'] ?? '');

$user_password = trim($_POST['user_password'] ?? '');


// VALIDATION

// Check name
if ($user_name === '') {

    $_SESSION['error_message'] = "Name is required.";

    header("Location: ../../profile.php");

    exit;
}


// Check email

if ($user_email === '') {

    $_SESSION['error_message'] = "Email is required.";

    header("Location: ../../profile.php");

    exit;
}


// Check valid email
if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {

    $_SESSION['error_message'] = "Please enter a valid email address.";

    header("Location: ../../profile.php");

    exit;
}


// Check password length (only if user is changing it)

if ($user_password !== '' && strlen($user_password) < 6) {

    $_SESSION['error_message'] = "Password must be at least 6 characters.";

    header("Location: ../../profile.php");

    exit;
}

// CHECK EMAIL ALREADY EXISTS
$stmt = $conn->prepare("
    SELECT id
    FROM users
    WHERE User_Email = ?
    AND id != ?
    LIMIT 1
");

$stmt->bind_param(
    "si",
    $user_email,
    $user_id
);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {

    $_SESSION['error_message'] =
        "This email address is already being used by another user.";

    header("Location: ../../profile.php");
    exit;
}


// UPDATE USER (with or without password)

if ($user_password !== '') {

    // Password bhi change ho rahi hai
    $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("
        UPDATE users
        SET
            User_Name = ?,
            User_Email = ?,
            User_Password = ?
        WHERE id = ?
    ");

    $stmt->bind_param(
        "sssi",
        $user_name,
        $user_email,
        $hashed_password,
        $user_id
    );

} else {

    // Sirf name/email update ho rahe hain

    $stmt = $conn->prepare("
        UPDATE users
        SET
            User_Name = ?,
            User_Email = ?
        WHERE id = ?
    ");

    $stmt->bind_param(
        "ssi",
        $user_name,
        $user_email,
        $user_id
    );

}


// EXECUTE UPDATE
if ($stmt->execute()) {

    // Update session name if your dashboard
    // displays name from session.

    $_SESSION['user_name'] = $user_name;

    $_SESSION['success_message'] =
        "Your profile has been updated successfully.";

} else {

    $_SESSION['error_message'] =
        "Unable to update your profile. Please try again.";
}


// BACK TO EDIT PROFILE
header("Location: ../../profile.php");

exit;