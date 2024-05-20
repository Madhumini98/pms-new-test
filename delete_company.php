<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

$uname = $_GET['uname'];

// Validate username (optional but recommended)
// if (empty($uname)) {
//     $_SESSION['delete'] = 'invalid_username';
//     header("Location: index.php");
//     exit;
// }

// Delete user account
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pms-ml-clients";

// Create a database connection
$link = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($link->connect_error) {
  die("Connection failed: " . $link->connect_error);
}

// **Important:** Do not delete the entire table. Use a DELETE statement with a WHERE clause.
// Prepare and bind parameterized statement to prevent SQL injection
$stmt = $link->prepare("DELETE FROM `users` WHERE `uname` = ?");
$stmt->bind_param("s", $uname); // Bind username as string

// Execute statement
if (!$stmt->execute() || !$link->commit()) {
  $_SESSION['delete'] = 'delete_error'; // Set error message for unsuccessful deletion
}

// Close statement and database connection
$stmt->close();
$link->close();

// Redirect to index.php (regardless of success or failure)
header("Location: index.php");
exit;
