<?php
session_start();
$client = $_SESSION['client'];
include 'conn.php';
if (isset($_POST['spotid'])) {
    // get form data
    $spotid = $_POST["spotid"];
    $type = $_POST["type"];
    $class = $_POST["class"];
    $info = $_POST["info"];

    // sanitize input data
    $spotid = mysqli_real_escape_string($link, $spotid);
    $type = mysqli_real_escape_string($link, $type);
    $class = mysqli_real_escape_string($link, $class);
    $info = mysqli_real_escape_string($link, $info);

    // insert data into database
    $query = "UPDATE `spot` SET `type`='$type',`class`='$class', `info`='$info' WHERE `spot_id`='$spotid'";
    echo $query;
    $result = mysqli_query($link, $query);

    // check if data is saved successfully
    if ($result && mysqli_affected_rows($link) > 0) {
        $_SESSION['edit'] = 'success';
    } else {
        $_SESSION['edit'] = 'error';
    }
    mysqli_close($link);
    header("Location: parking_spots.php");
}
if (isset($_POST['fee'])) {
    $fee = $_POST['fee'];
    $feeid = $_POST['feeid'];
    $updateFee = "UPDATE `tolls` SET `toll_per_hour`= $fee WHERE `feeid`='$feeid'";
    mysqli_query($link, $updateFee);

    if (mysqli_affected_rows($link) > 0) {
        $_SESSION['edit'] = 'success';
    } else {
        $_SESSION['edit'] = 'error';
    }
    header("Location: fee.php");
}


if (isset($_POST['uname'])) {
    $uname = $_POST['uname'];
    $pass = $_POST['pass'];

    $link2 = mysqli_connect('localhost', 'root', '', 'pms-ml-clients');

    // Check connection
    if (!$link2) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $reset_pass = "UPDATE `users` SET `password` = ? WHERE `client` = ? AND `uname` = ?";

    // Using prepared statement to prevent SQL injection
    $stmt = mysqli_prepare($link2, $reset_pass);
    mysqli_stmt_bind_param($stmt, 'sss', $pass, $client, $uname);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['reset_user_pass'] = 'success';
    } else {
        $_SESSION['reset_user_pass'] = 'error';
    }

    mysqli_stmt_close($stmt);
    mysqli_close($link2);
    header("Location: index.php");
}
