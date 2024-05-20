<?php
// Connect to the database pms-stats-...
session_start();
$client = $_SESSION['client'];

// Read session and change database name
// Connect to the database pms-stats-....
$dbname_stats = 'pms-stats-' . $client;
$link_stats = mysqli_connect('localhost', 'root', '', $dbname_stats);

// Check connection
if (!$link_stats) {
    die("Connection failed for pms-stats-slt: " . mysqli_connect_error());
}

// SQL queries for pms-stats-....
$queries_stats = [
   "UPDATE `statbyday` SET `AverageIn` = '0', `AverageOut` = '0', `i` = '0', `o` = '0'",
   "UPDATE `revenue` SET `AvRevenue`='0',`total_revenue`='0',`week_count`='0'",
   "UPDATE `totals` SET `revenue`='0',`vehicle`='0',`vehicle_in`='0',`vehicle_out`='0'",
];

// Execute the queries for pms-stats-....
$success_stats = true;

foreach ($queries_stats as $sql) {
    if ($link_stats->query($sql) !== TRUE) {
        $success_stats = false;
        break;
    }
}

// Close the connection to pms-stats-....
$link_stats->close();

// Connect to the database pms-ml-.....
$dbname_ml = 'pms-ml-' . $client;
$link_ml = mysqli_connect('localhost', 'root', '', $dbname_ml);

// Check connection
if (!$link_ml) {
    die("Connection failed for pms-ml-slt: " . mysqli_connect_error());
}

// SQL queries for pms-ml-....
$queries_ml = [
    "UPDATE `vehicle` SET `next_fun`='i' ",
    "UPDATE `spot` SET `availability`='t',`parked_vehicle`='',`parked_time`=''",
];

// Execute the queries for pms-ml-....
$success_ml = true;

foreach ($queries_ml as $sql) {
    if ($link_ml->query($sql) !== TRUE) {
        $success_ml = false;
        break;
    }
}

// Close the connection to pms-ml-....
$link_ml->close();

// Set session variable indicating data has been cleared
$_SESSION['data_cleared'] = true;

// Redirect to test1.php
if ($success_stats || $success_ml) {
    header("Location: index.php");
    exit();
} else {
    // Handle the error here, such as displaying an error message
    echo "Error updating the databases.";
}
?>