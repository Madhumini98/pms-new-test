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
$dbname = 'clients-api-keys';
$link = mysqli_connect('localhost', 'root', '', $dbname);
  
// Check connection
if (!$link) {
  die("Connection failed: " . mysqli_connect_error());
}
$client = $_POST['client'];
$api = $_POST['api'];


// Prepare statement 
$stmt = $link->prepare("UPDATE api SET api = ? WHERE client = ?");

// Bind parameters
$api = hash('sha256', $api); 
$stmt->bind_param('ss', $api, $client);

// Execute statement 
$stmt->execute();

// Check rows affected 
if($stmt->affected_rows > 0){
  $_SESSION['add'] = 'success';
} else {
  $_SESSION['add'] = 'error'; 
}

// Close connection
$stmt->close();
$link->close();

// Redirect
header("Location: index.php");