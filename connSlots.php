<?php

function connectToDatabase($databaseName) {
    $host = 'localhost';
    $user = 'root';
    $password = ''; // Replace with your database password

    $connection = mysqli_connect($host, $user, $password, $databaseName);

    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    return $connection;
}

?>