<?php
session_start();

$user = $_SESSION['client'];

$database = 'pms-ml-' . $user;

$conn = mysqli_connect("localhost", "root", "", $database);

$sql = "SELECT * FROM `realtime` WHERE `register`='t'";

$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_array($result)) {
    echo '<img src="../images/' . $user . '/' . $row['img'] . '" alt="Entered Vehicle">';
    echo '<h3><strong>Parking Spot ID:</strong>' . $row['parking_spot'] . '</h3>';
    echo '<h3><strong>Vehicle Number:</strong> ' . $row['vehicle_num'] . '</h3>';
    echo '<h3>Please Park your Vehicle : <strong>' . $row['parking_spot'] . ' Spot.</strong></h3>';
}

mysqli_close($conn);
