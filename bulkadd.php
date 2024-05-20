<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if a file was uploaded
    if (isset($_FILES['uploaded_file'])) {
        $file = $_FILES['uploaded_file'];

        // Check the file extension
        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if ($fileExtension === 'csv') {
            // File is a CSV

            $destinationPath = 'csv/bulkadd/data.csv';
            // check upload success or not
            if (move_uploaded_file($file['tmp_name'], $destinationPath)) {
                echo 'File was successfully uploaded.';
                $user = $_SESSION['client'];
                // Run the dataAdd function in Python with the user parameter
                exec("python3 csv/bulkadd/main.py " . escapeshellarg($user) . " 2>&1", $output, $return);

                // Check if the execution was successful
                if ($return === 0) {
                    // Python script executed successfully
                    $_SESSION['bulkadd'] = "success";
                    // rederect to vehicle.php
                    header("Location: vehicle.php");
                } else {
                    // Python script encountered an error
                    $_SESSION['bulkadd'] = "err";
                    // rederect to vehicle.php
                    header("Location: vehicle.php");
                }
            } else {
                echo 'Upload failed.';
                $_SESSION['bulkadd'] = "err";
                // rederect to vehicle.php
                header("Location: vehicle.php");
            }
        } else {
            // File is not a CSV
            echo "Invalid file format. Please upload a CSV file.";
            $_SESSION['bulkadd'] = "err";
            // rederect to vehicle.php
            header("Location: vehicle.php");
        }
    } else {
        // No file uploaded
        echo "Please select a file to upload.";
        $_SESSION['bulkadd'] = "err";
        // rederect to vehicle.php
        header("Location: vehicle.php");
    }
}
?>
