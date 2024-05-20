<?php

$vehicleNumber='KX3411';
$client='slt';

    $pythonScript = "bill.py";
    $command = "python3 $pythonScript newUpdate_parking_cost_bill $vehicleNumber $client";
    $output = exec($command);

?>