<?php
    $dbServername = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbName = "loginsystem";
    // Create connection
    $conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    // echo 'Connected successfully';
    // mysqli_close($conn);
?>