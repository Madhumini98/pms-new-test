<?php

include 'conn_slots.php';

// $apiKey = $_GET['key'];

// if ($apiKey !== 'YOUR_API_KEY') {
//     http_response_code(401); // Unauthorized
//     echo "Unauthorized Access";
//     exit;
// }

$sql = "SELECT location_name, available_slots FROM parking_locations";
$result = mysqli_query($link, $sql);
// Check if the query was successful
if ($result) {
    $results = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $results[] = $row;
    }

    header('Content-Type" application/json');
    echo json_encode($results);

} else {
    echo "Error executing query: " . mysqli_error($link);
}
mysqli_close($link);

?>