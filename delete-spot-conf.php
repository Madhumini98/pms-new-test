<?php
include 'conn.php';
session_start();

if($_SESSION['role'] != 'sadmin'){
    $_SESSION['err-del'] = 'err';
    header("Location: parking_spots.php");
}
else{
    $id = $_GET['id'];

// Prepare and bind parameterized statement
$stmt = $link->prepare("DELETE FROM `spot` WHERE `spot_id` = ?");
$stmt->bind_param("s", $id);

// Execute statement
$stmt->execute();

// Check if row was deleted
if (mysqli_affected_rows($link) > 0) {
    $_SESSION['delete'] = 'delete_success';
    
} else {
    $_SESSION['delete'] = 'delete_error';
   
}
header("Location: parking_spots.php");

// Close statement and database connection
$stmt->close();
$link->close();

}

