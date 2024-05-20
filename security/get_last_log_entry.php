<?php
// Set the path to your log file
$logFile = './server_log/parking_system.log';

// Read the last line of the log file
$lastLine = `tail -n 1 $logFile`;

// Return the last line as JSON
$response = ['lastLine' => $lastLine];
echo json_encode($response);
?>