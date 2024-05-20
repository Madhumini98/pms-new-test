<?php
session_start();
$client = $_SESSION['client'];
// Connect to the database
$dbname = 'pms-ml-' . $client;
$link = mysqli_connect('localhost', 'root', '', $dbname);

// Check connection
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}
