<?php
$dbname = 'iPMS-clients';
$link = mysqli_connect('localhost', 'root', '', $dbname);

// Check connection
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}