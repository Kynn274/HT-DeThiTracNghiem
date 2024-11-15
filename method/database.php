<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "MultipleChoiceExamCreationSystem";

    $conn = new mysqli($servername, $username, $password);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "CREATE DATABASE IF NOT EXISTS $dbname CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci";
    if ($conn->query($sql) !== TRUE) {
        die("Error creating database: " . $conn->error);
    }

    $conn->select_db($dbname);
    $conn->set_charset('utf8mb4');

    return $conn;
?>
