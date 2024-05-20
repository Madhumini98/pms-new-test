<?php

session_start();

$user = $_SESSION['client'];

$database = 'pms-ml-' . $user;

$conn = mysqli_connect("localhost", "root", "", $database);

$sql = "SELECT * FROM `vehicle_logs` WHERE `gate` = 'out' ORDER BY `timestamp` DESC LIMIT 1";

$result = mysqli_query($conn, $sql);

if ($row = mysqli_fetch_array($result)) {
    $basePath = "../images/";

    $vehicleNumber = $row['vehicle_number'];

    $imagePaths = [
        $basePath . "slt/" . $vehicleNumber . ".jpg",
        $basePath . "mobitel/" . $vehicleNumber . ".jpg",
        $basePath . "notRegister/slt/" . $vehicleNumber . ".jpg",
        $basePath . "notRegister/mobitel/" . $vehicleNumber . ".jpg",
    ];

    $imagePath = null;

    foreach ($imagePaths as $path) {
        if (file_exists($path)) {
            $imagePath = $path;
            break;
        }
    }
    echo '<img src="' . $imagePath . '" alt="Exit Vehicle">';
    echo '<h3><strong>Vehicle Number:</strong> ' . $row['vehicle_number'] . '</h3>';
    echo '<h3><strong>Exit Time:</strong> ' . $row['timestamp'] . '</h3>';
}

mysqli_close($conn);
