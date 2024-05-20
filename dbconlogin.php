<?php
session_start();
// Connect to the database
$link = mysqli_connect('localhost', 'root', '', 'pms-ml-clients');

// Check connection
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}
