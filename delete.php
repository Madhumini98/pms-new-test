<?php
include 'conn.php';
session_start();

if($_SESSION['role'] != 'sadmin'){
    $_SESSION['err-del'] = 'err';
    header("Location: vehicle.php");
}
else{
    $id = $_GET['id'];

// Prepare and bind parameterized statement
$stmt = $link->prepare("DELETE FROM `vehicle` WHERE `vehicle_num` = ?");
$stmt->bind_param("s", $id);

// Execute statement
$stmt->execute();

// Check if row was deleted
if (mysqli_affected_rows($link) > 0) {
    $_SESSION['msg'] = 'delete_success';
    echo 'sdasdasd';

} else {
    $_SESSION['msg'] = 'delete_error';
    echo "error";
}
header("Location: vehicle.php");

// Close statement and database connection
$stmt->close();
$link->close();

}
