<?php
session_start();
if (!isset($_SESSION['login'])) {
  header("Location: ../loginform.php");
} else {
  if ($_SESSION['login'] == 'False') {
    header("Location: ../loginform.php");
  }
  if ($_SESSION['role'] != 'ssadmin') {
    header("Location: ../loginform.php");
  }
}
if (isset($_POST['accInfo']) and isset($_POST['id'])) {

  // Connect database

  $dbname = 'clients-api-keys';
  $link = mysqli_connect('localhost', 'root', '', $dbname);

  // Check connection
  if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
  }


  $info = $_POST['accInfo'];
  $id = $_POST['id'];

  // sanitize input data
  $payment = mysqli_real_escape_string($link, $payment);
  $account = mysqli_real_escape_string($link, $account);
  $id = mysqli_real_escape_string($link, $id);

  // insert data into database
  $query = "UPDATE `api` SET `info`='$info' WHERE `api`='$id'";
  $result = mysqli_query($link, $query);

  // check if data is saved successfully
  if ($result && mysqli_affected_rows($link) > 0) {
    $_SESSION['edit'] = 'success';
  } else {
    $_SESSION['edit'] = 'error';
  }
  mysqli_close($link);
  header("Location: api.php");
}

header("Location: api.php");
