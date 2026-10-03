<?php

       session_start();

        // Remove all Session Data
        session_unset();

        // Destroy Session
        session_destroy();

        // Delete Cookies
        setcookie("is_login", "", time() - 3600, "/");
        setcookie("username", "", time() - 3600, "/");
        setcookie("email", "", time() - 3600, "/");

        // Redirect to Login Page
        header("Location: ../Login_page/login.php");
        exit();

?>