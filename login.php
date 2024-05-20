<?php
#ini_set('display_errors', 1);
include 'dbconlogin.php';
$uname = $_POST['uname'];
$pass = $_POST['password'];

// user name validation
$userNameValidation = "SELECT `uname` FROM `users` WHERE `uname` = '$uname'; ";
$sqlNameValidation = mysqli_query($link, $userNameValidation);

if (mysqli_num_rows($sqlNameValidation) == 0) {
    $_SESSION['err'] = "UserName";
    header("Location