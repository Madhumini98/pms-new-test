<?php
$log_file = "server_log/parking_system.log";
$filtered_log_lines = array();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $start_date = $_POST["start_date"];
    $end_date = $_POST["end_date"];

    $handle = fopen($log_file, "r");

    if ($handle) {
        // read the file line by line and store the lines within the date range in an array
        while (!feof($handle)) {
            $line = fgets($handle);

            // Extract the timestamp from the log line (assuming it is at a specific position)
            $timestamp = substr($line, 0, 19);

            // Check if the timestamp falls within the selected date range
            if ($timestamp >= $start_date && $timestamp <= $end_date) {
                $filtered_log_lines[] = $line;
            }
        }

        fclose($handle);
    }
}

// Return the filtered log lines as a string
echo implode("<br>", $filtered_log_lines);
?>
