<?php
session_start();

$user = $_SESSION['client'];

$database = 'pms-ml-' . $user;

$conn = mysqli_connect("localhost", "root", "", $database);

$sql = "SELECT * FROM `realtimeo` WHERE 1";

$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_array($result)) {
    echo '<img src="../images/' . $user . '/' . $row['img'] . '" alt="Exit Vehicle">';

    echo '<h3><strong>Vehicle Number:</strong> ' . $row['vehicle_num'] . '</h3>';

    echo '<h3><strong>Enter Time:</strong> ' . $row['parked'] . '</h3>';
    // Convert parked time to a timestamp
    $parked_time = strtotime($row['parked']);
    $total_hour = $row['hour'];

    // Calculate exit time by adding total_hour to parked_time
    $exit_time_timestamp = $parked_time + ($total_hour * 3600); // 3600 seconds in an hour

    // Format exit time as per the given format
    $exit_time = date('m/d/Y H:i:s', $exit_time_timestamp);
    echo '<h3><strong>Exit Time:</strong> ' . $exit_time . '</h3>';
}

mysqli_close($conn);
