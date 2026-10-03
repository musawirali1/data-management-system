<?php

session_start();

if (!isset($_SESSION['is_login']) || $_SESSION['is_login'] !== true) // Agar Login session exit nahi hy 
                                                                    //Ya uski value true hy to user ko lgoin page per bejdo.
    {

    header("Location: Login_page/login.php");
    exit();
}

?>