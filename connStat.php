<?php
$client = $_SESSION['client'];
// Read session and change database name
// Connect to the database
$dbname = 'pms-stats-' . $client;
$link = mysqli_connect('localhost', 'root', '', $dbname);

// Check connection
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}
