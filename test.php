<?php

$file = fopen('/root/Intelligent-Parking-Management-System-Backend/dataAnalys/csv/vehicledata-slt.csv', 'r');
if ($file) {
  while (($line = fgets($file)) !== false) {
    echo $line; // Do something with the contents of each line
  }
  fclose($file);
} else {
  echo "Failed to open file";
}
