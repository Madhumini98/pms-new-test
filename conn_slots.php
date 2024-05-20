<?php
include 'sesion_start.php';
$dbname = 'parking_locations';
$link = mysqli_connect('localhost', 'root', '', $dbname);

if(!$link){
    die("connection failed: ".mysqli_connect_error());
}

?>