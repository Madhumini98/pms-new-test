<?php

// Include the 'connSlots.php' file, which contains the database connection function.
include 'connSlots.php';

// An array to store the location names.
$locationNames = array();

// SQL query to fetch location names from the 'clients' table in the 'iPMS-clients' database.
$query = "SELECT name FROM clients where is_public ='Yes';";

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

        // SQL query to fetch the availability from the 'spot' table in the specific location database.
        $query = "SELECT availability FROM spot";

        // Connect to the specific location database.
        $connection = connectToDatabase($databaseName);

        // Execute the SQL query to fetch data.
        $result = mysqli_query($connection, $query);

        // Initialize a variable to count available slots.
        $numberOfSpots = 0;

        // Loop through the result set and count available slots.
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['availability'] === 't') {
                $numberOfSpots++;
            }
        }

        // Store the location name and the number of available slots in the 'parkingData' array.
        $parkingData[] = array(
            'location_name' => $locationName,
            'available_slots' => $numberOfSpots
        );
    }

    // Set the response header to indicate JSON data and echo the JSON-encoded parking data.
    header('Content-Type: application/json');
    echo json_encode($parkingData);

} else {
    // Print an error message if the query fails.
    echo "Error executing query: " . mysqli_error($link);
}

?>