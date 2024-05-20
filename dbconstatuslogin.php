<?php
session_start();
// Connect to the database
$link = mysqli_connect('localhost', 'root', '', 'pms-status-clients');

// Check connection
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}
