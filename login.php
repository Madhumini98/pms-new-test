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
    header("Location: loginform.php");
} else {
    $passwordValidation = "SELECT `password` FROM `users` WHERE `uname`='$uname'";
    $sqlPass = mysqli_query($link, $passwordValidation);
    $password = mysqli_fetch_assoc($sqlPass);

    if ($password['password'] == $pass) {
        // Get account details
        $sqlGetData = "SELECT `client`, `role` FROM `users` WHERE `uname` = '$uname'";
        $sqlData = mysqli_query($link, $sqlGetData);
        $data = mysqli_fetch_assoc($sqlData);
        $client = $data['client'];
        $name = $uname;
        $role = $data['role'];
        $_SESSION['role'] = $role;
        $_SESSION['client'] = $client;
        $_SESSION['msg'] = "success";
        $_SESSION['login'] = "True";
        if ($role == 'sadmin') {
            header("Location: index.php");
        }
        if ($role == 'admin') {
            header("Location: index.php");
        }
        if ($role == 'og') {
            header("Location: ogate/oGate.php");
        }
        if ($role == 'ig') {
            header("Location: ingate/inGate.php");
        }
        if ($role == 'ssadmin') {
            header("Location: usadmin/index.php");
        }
        if ($role == 'igs') {
            header("Location: ingate/inGate_security.php");
        }
        if ($role == 'ogs') {
            header("Location: ogate/oGate_security.php");
        }
        if ($role == 'manual') {
            header("Location: manual/index.php");
        }
        if ($role == 'sec') {
            header("Location: security/index.php");
        }
        if ($role == 'public') {
            header("Location: public_display/index.php");
        }
    } else {
        $_SESSION['err'] = "pass";
        header("Location: loginform.php");
    }
}
