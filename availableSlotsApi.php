<?php

// Include the 'connSlots.php' file, which contains the database connection function.
include 'connSlots.php';

// An array to store the location names.
$locationNames = array();

// SQL query to fetch location names from the 'clients' table in the 'iPMS-clients' database.
$query = "SELECT name FROM clients";

// Connect to the 'iPMS-clients' database.
$connection = connectToDatabase("iPMS-clients");

// Execute the SQL query to fetch location names.
$result = mysqli_query($connection, $query);

// Check if the query was successful.
if ($result) {
    // Loop through the result set and store location names in the array.
    while ($row = mysqli_fetch_assoc($result)) {
        $locationNames[] = $row['name'];
    }

    // An array to store parking data.
    $parkingData = array();

    // Loop through each location name.
    foreach ($locationNames as $locationName) {

        // Form the database name by combining "pms-ml-" with the location name.
        $databaseName = "pms-ml-" . $locationName;

        // Connect to the client-specific database.
        $connectionClient = connectToDatabase($databaseName);

        // SQL query to fetch data from the spot table.
        $querySpot = "SELECT * FROM spot";
        $resultSpot = mysqli_query($connectionClient, $querySpot);

        $totalSpots = 0;
        $availableSpots = 0;
        $parkingDetails = array();

        if ($resultSpot) {
            while ($rowSpot = mysqli_fetch_assoc($resultSpot)) {
                $totalSpots++;
                if ($rowSpot['availability'] == 't') {
                    $availableSpots++;
                } else {
                    $parkingDetails[] = array(
                        'spot_id' => $rowSpot['spot_id'],
                        'parked_vehicle' => $rowSpot['parked_vehicle'],
                        'parked_time' => $rowSpot['parked_time']
                    );
                }
            }
        }

        $parkingData[$locationName] = array(
            'totalSpots' => $totalSpots,
            'availableSpots' => $availableSpots,
            'parkingDetails' => $parkingDetails
        );
    }
} else {
    // Print an error message if the query fails.
    echo "Error executing query: " . mysqli_error($link);
}


// Convert the parking data array to JSON and send it as the API response.
header('Content-Type: application/json');
echo json_encode($parkingData);
