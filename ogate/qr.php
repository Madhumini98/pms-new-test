<?php
session_start();

$qrImagePath = 'images/' . $_SESSION['client'] . '/qr.png';
if (file_exists($qrImagePath)){
    echo "available";
} else {
    echo "not available";
}
