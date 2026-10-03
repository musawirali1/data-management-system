<?php

require_once "../db-connection.php";

// Check karo Login button press hua hai ya nahi
if (isset($_POST['login'])) {

    // Form se Email aur Password lo
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Check karo koi field khali to nahi
    if (empty($email) || empty($password)) {

        $error = "Please enter Email and Password.";

    } else {

        // Password ko SHA1 se encrypt karo
        $encrypt_password = sha1($password);

        // Database me Email aur Password check karo
        $query = mysqli_query($conn, "
            SELECT * FROM users
            WHERE User_Email = '$email'
            AND User_Password = '$encrypt_password'
            LIMIT 1
        ");

        // Agar user mil gaya
        if (mysqli_num_rows($query) == 1) {

            // User ki information nikalo
            $user = mysqli_fetch_assoc($query);


               // ==========================================
                // USER STATUS CHECK
                // ==========================================

                if ($user['User_Status'] == 2) {

                    // Pending
                    $error = "Your account is pending. Please wait for admin approval.";

                } elseif ($user['User_Status'] == 0) {

                    // Inactive
                    $error = "Your account is inactive. Please contact the administrator.";

                } elseif ($user['User_Status'] == 1) {

                    // Active - Login Allow

                    $_SESSION['is_login'] = true;
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['User_Name'];
                    $_SESSION['email'] = $user['User_Email'];
                    $_SESSION['user_type'] = $user['User_Type'];
                    $_SESSION['reference_id'] = $user['Reference_ID'];

                    // Remember Me
                    if (isset($_POST['remember_me'])) {

                        setcookie(
                            "remember_email",
                            $user['User_Email'],
                            time() + (60 * 60 * 24 * 30),
                            "/"
                        );

                    } else {

                        setcookie(
                            "remember_email",
                            "",
                            time() - 3600,
                            "/"
                        );
                    }

                    // Dashboard
                    header("Location: ../index.php");
                    exit();

                } else {

                    // Unknown status
                    $error = "Your account status is invalid. Please contact the administrator.";
                }

        } else {

            // Agar Email ya Password ghalat ho
            $error = "Invalid Email or Password.";
        }
    }
}

?>