<?php

// Database Connection
if (!isset($conn)) 
    {
    require_once __DIR__ . "/../db-connection.php";
}
    
// Register Button Check
if (isset($_POST['register'])) {


    // 1. RECEIVE reCAPTCHA TOKEN
    $captcha = $_POST['g-recaptcha-response'] ?? '';

     // 2. CHECK reCAPTCHA EMPTY
     if(empty($captcha)){
        $register_error = "Please complete the reCaptcha.";
     }
     // 3. VERIFY reCAPTCHA WITH GOOGLE
    else {

     // APNI SECRET KEY YAHAN DAALEIN
     $secret_kay = "6LeWSdUtAAAAABjevyJAjSDvWvnbQZm4cXyyOeoG";
     $verify_url = "https://www.google.com/recaptcha/api/siteverify";

    }

    


    // Receive Form Data
    $full_name        = trim($_POST['full_name']);   
    $email            = trim($_POST['email']);
    $user_type        = trim($_POST['user_type']);
    $password         = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Empty Fields Validation
    if (
        empty($full_name) ||
        empty($email) ||
        empty($user_type) ||
        empty($password) ||
        empty($confirm_password)
    ) {

        $register_error = "All fields are required.";

    }
    // Password Match Validation
    elseif ($password != $confirm_password) {

        $register_error = "Password and Confirm Password do not match.";

    }
    else {

        // Check Email Already Exists
        $check_email = mysqli_query( $conn, "SELECT * FROM users WHERE User_Email = '$email'");

        if (mysqli_num_rows($check_email) > 0) {

            $register_error = "Email already registered.";

        }
        else {

            // Encrypt Password
            $encrypt_password = sha1($password);

            // Insert User
            $insert = mysqli_query($conn, " INSERT INTO users ( User_Name, User_Email, user_type,
                            User_Password,
                            Reference_ID,
                            User_Status,
                            created_at,
                            updated_at )
                        VALUES( '$full_name', '$email', '$user_type', '$encrypt_password', 0, 2, NOW(),NOW())");

            if ($insert) {

                $register_success = "Registration Successful. Your account now pending. Please Wait for Admin Approvel for Login.";
                
            } else {

                $register_error = "Something went wrong.";

            }

        }

    }

   

}

?>