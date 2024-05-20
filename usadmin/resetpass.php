<?php
session_start();
if (!isset($_SESSION['login'])){
    header("Location: ../loginform.php");
  }
  else{
    if ($_SESSION['login'] == 'False'){
      header("Location: ../loginform.php");
    }
    if ($_SESSION['role'] != 'ssadmin'){
      header("Location: ../loginform.php");
    }
  }
if (isset($_POST['client'], $_POST['role'], $_POST['pass'])) {
  $client = $_POST['client'];
  $role = $_POST['role'];
  $pass = $_POST['pass'];

  // create a new database connection
  $link = mysqli_connect("localhost", "root", "", "pms-ml-clients");
  if (!$link) {
      die("Connection failed: " . mysqli_connect_error());
  }

  // prepare the SQL statement
  $stmt = mysqli_prepare($link, "UPDATE `users` SET `password`=? WHERE `client`=? AND `role`=?");
  mysqli_stmt_bind_param($stmt, "sss", $pass, $client, $role);

  // execute the SQL statement
  if (mysqli_stmt_execute($stmt)) {
      // check if data is saved successfully
      if (mysqli_affected_rows($link) > 0) {
          $_SESSION['resetpass'] = 'success';
      } else {
          $_SESSION['resetpass'] = 'error';
      }
  } else {
      $_SESSION['resetpass'] = 'error';
  }

  // close the statement and database connection
  mysqli_stmt_close($stmt);
  mysqli_close($link);

  // redirect the user to the index page
  header("Location: index.php");
} else {
  // redirect the user to the index page
  header("Location: index.php");
}
