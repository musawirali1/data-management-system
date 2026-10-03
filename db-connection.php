<?php

            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "data_managment";
            // Create connection
            $conn = new mysqli("127.0.0.1", "root", "", "data_managment", 3307);

            // Check connection
            if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
            }
            ?>

            