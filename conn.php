<?php
include 'sesion_start.php';
$client = $_SESSION['client'];
// Read session and change database nameu
// Connect to the database
$dbname = 'pms-ml-' . $client;
$link = mysqli_connect('localhost', 'root', '', $dbname);

// Check connection
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}