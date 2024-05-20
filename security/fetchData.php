<?php
session_start();

$user = $_SESSION['client'];

$database = 'pms-ml-' . $user;

$conn = mysqli_connect("localhost", "root", "", $database);

$sql_in = "SELECT * FROM `in-gate` ";
$sql_out = "SELECT * FROM `out-gate` ";

$result_in = mysqli_query($conn, $sql_in);
$result_out = mysqli_query($conn, $sql_out);

$response = array();


if ($result_in && $result_out) {
    // Fetch data as an associative array
    $data_in = mysqli_fetch_all($result_in, MYSQLI_ASSOC);
    $data_out = mysqli_fetch_all($result_out, MYSQLI_ASSOC);

    $response['inGate'] = $data_in;
    $response['outGate'] = $data_out;

    // Convert data to JSON and send it to the client
    echo json_encode($response);
} else {
    // Handle query error
    echo "Error executing query: " . mysqli_error($connection);
}

// Close the database connection
mysqli_close($connection);
