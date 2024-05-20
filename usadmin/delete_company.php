<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if ($_SESSION['role'] !== 'ssadmin') {
    $_SESSION['delete'] = 'delete_error';
    header("Location: index.php");
    exit;
} else {
    $id = $_GET['id'];

    // delete user  account 
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "iPMS-clients";

    // Create a database connection
    $link = new mysqli($servername, $username, $password, $dbname);

    // Check if the connection was successful
    if ($link->connect_error) {
        die("Connection failed: " . $link->connect_error);
    }

    // Prepare and bind parameterized statement
    $stmt = $link->prepare("DELETE FROM `clients` WHERE `name` = ?");
    $stmt->bind_param("s", $id);

    // Execute statement
    if (!$stmt->execute() || !$link->commit()) {
        $_SESSION['delete'] = 'delete_error';
        header("Location: index.php");
        exit;
    }

    // Close statement and database connection
    $stmt->close();
    $link->close();





    // Delete stat DB
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "pms-stats-" . $id;

    // Create a database connection
    $link = new mysqli($servername, $username, $password, $dbname);

    // Check if the connection was successful
    if ($link->connect_error) {
        die("Connection failed: " . $link->connect_error);
    }

    // Prepare and bind parameterized statement
    $stmt = $link->prepare("DROP DATABASE IF EXISTS `$dbname`");

    // Execute statement
    if (!$stmt->execute() || !$link->commit()) {
        $_SESSION['delete'] = 'delete_error';
        header("Location: index.php");
        exit;
    }

    // Close statement and database connection
    $stmt->close();
    $link->close();

    // Delete ML db
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "pms-ml-" . $id;

    // Create a database connection
    $link = new mysqli($servername, $username, $password, $dbname);

    // Check if the connection was successful
    if ($link->connect_error) {
        die("Connection failed: " . $link->connect_error);
    }

    // Prepare and bind parameterized statement
    $stmt = $link->prepare("DROP DATABASE IF EXISTS `$dbname`");

    // Execute statement
    if (!$stmt->execute() || !$link->commit()) {
        $_SESSION['delete'] = 'delete_error';
        header("Location: index.php");
        exit;
    }

    // Close statement and database connection
    $stmt->close();
    $link->close();

    // Delete API key
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "clients-api-keys";

    // Create a database connection
    $link = new mysqli($servername, $username, $password, $dbname);

    // Check if the connection was successful
    if ($link->connect_error) {
        die("Connection failed: " . $link->connect_error);
    }

    // Prepare and bind parameterized statement
    $stmt = $link->prepare("DELETE FROM `api` WHERE `client` = ?");
    $stmt->bind_param("s", $id);

    // Execute statement
    if (!$stmt->execute() || !$link->commit()) {
        $_SESSION['delete'] = 'delete_error';
        header("Location: index.php");
        exit;
    }

    // Close statement and database connection
    $stmt->close();
    $link->close();

    // Delete clients accounts
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "pms-ml-clients";

    // Create a database connection
    $link = new mysqli($servername, $username, $password, $dbname);

    // Check if the connection was successful
    if ($link->connect_error) {
        die("Connection failed: " . $link->connect_error);
    }

    // Prepare and bind parameterized statement
    $stmt = $link->prepare("DELETE FROM `users` WHERE `client`= ?");
    $stmt->bind_param("s", $id);

    // Execute statement
    if (!$stmt->execute() || !$link->commit()) {
        $_SESSION['delete'] = 'delete_error';
        header("Location: index.php");
        exit;
    }

    // Close statement and database connection
    $stmt->close();
    $link->close();

    // Delete folder ../images/
    $folder = '../images/' . $id;
    if (is_dir($folder)) {
        $files = glob($folder . '/*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
        rmdir($folder);
    }

    // Delete folder ../bills/
    $folder = '../bills/' . $id;
    if (is_dir($folder)) {
        $files = glob($folder . '/*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
        rmdir($folder);
    }

    // Delete folder ../images/ingate/
    $folder = '../images/ingate/' . $id;
    if (is_dir($folder)) {
        $files = glob($folder . '/*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
        rmdir($folder);
    }

    // Delete folder ../images/outgate/
    $folder = '../images/ingate/' . $id;
    if (is_dir($folder)) {
        $files = glob($folder . '/*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
        rmdir($folder);
    }

    // Delete folder ../images/notRegister/
    $folder = '../images/notRegister/' . $id;
    if (is_dir($folder)) {
        $files = glob($folder . '/*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
        rmdir($folder);
    }

    $_SESSION['delete'] = 'delete_success';
    header("Location: index.php");
    exit;
}
