<?php
ini_set('display_errors', 1);
session_start();
if (!isset($_SESSION['login'])){
    header("Location: ../loginform.php");
  }
  else{
    if ($_SESSION['login'] == 'False'){
      header("Location: ../loginform.php");
    }
    if ($_SESSION['role'] != 'ssadmin'){
      header("Location: ../loginform.php");
    }
  }

  // Step 1: Sanitize and validate the user inputs
  $client = $_POST['client'];
  $mail = $_POST['mail'];
  $tel = $_POST['phone'];
  $pass = $_POST['pass'];
  $uname = $_POST['uname'];
  $a_class = $_POST['A_class'];
  $is_public = $_POST['is_public'];
  
  // Step 2: Insert data into 'iPMS-clients.clients' table
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname1 = "iPMS-clients";
  $dbname2 = "pms-ml-clients";
  $dbname3 = "clients-api-keys";
  
  // Create a database connection
  $connection1 = new mysqli($servername, $username, $password, $dbname1);
  
  // Check if the connection was successful
  if ($connection1->connect_error) {
      die("Connection failed: " . $connection1->connect_error);
  }

  // create a database connection2
  $connection2 = new mysqli($servername, $username, $password, $dbname2);

  // Check if the connection was successful
  if ($connection2->connect_error) {
      die("Connection failed: " . $connection2->connect_error);
  }

  // create a database connection3
  $connection3 = new mysqli($servername, $username, $password, $dbname3);

  // Check if the connection was successful
  if ($connection3->connect_error) {
      die("Connection failed: " . $connection3->connect_error);
  }
  
  // Prepare the INSERT statement
$query1 = "INSERT INTO `clients` (`name`, `mail`, `tel`, `userName`, `password`, `class`, `is_public`) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $connection1->prepare($query1);

// Check if the prepare was successful
if ($stmt === false) {
    die("Error preparing the statement: " . $connection1->error);
}

// Bind the parameters to the prepared statement
$stmt->bind_param("sssssss", $client, $mail, $tel, $uname, $pass, $a_class, $is_public);

// Execute the prepared statement
$result1 = $stmt->execute();

// Check if the execute was successful
if ($result1 === false) {
    die("Error executing the statement: " . $stmt->error);
}

// Close the prepared statement
$stmt->close();

// Close the database connection
$connection1->close();
  
  // Step 3: Insert data into 'pms-ml-clients.users' table
  $query2 = "INSERT INTO `users`(`client`, `email`, `password`, `role`, `uname`) VALUES ('$client', '$mail', '$pass', 'sadmin', '$uname')";
  $result2 = $connection2->query($query2);
  // closs the connection2
  $connection2->close();

  // Step 4: Insert data into 'clients-api-keys.api-keys' table
  $query3 = "INSERT INTO `api`(`client`) VALUES ('$client')";
  $result3 = $connection3->query($query3);
  // closs the connection3
  $connection3->close();
  
  // Check the results of all queries
  if ($result1 && $result2 && $result3) {

    // Database Creation
    // Step 2: Insert data into 'iPMS-clients.clients' table
    $servername = "localhost";
    $username = "root";
    $password = "";

    // Create a database connection
    $connection1 = new mysqli($servername, $username, $password);
      
    // Check if the connection was successful
    if ($connection1->connect_error) {
        die("Connection failed: " . $connection1->connect_error);
    }

    $dbname1 = "pms-ml-" . $client;
    $dbname2 = "pms-stats-" . $client;

    $query = "CREATE DATABASE IF NOT EXISTS `$dbname1`";
    $query1 = "CREATE DATABASE IF NOT EXISTS `$dbname2`";
    if ($connection1->query($query) === TRUE && $connection1->query($query1) === TRUE) {
      echo "Database created successfully";
      $sql = "
      USE `" . $dbname1 . "`;
      SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';
      START TRANSACTION;
      SET time_zone = '+05:00';


      CREATE TABLE `communicate` (
      `signal` int NOT NULL
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



      CREATE TABLE `realtime` (
      `vehicle_num` varchar(20) DEFAULT NULL,
      `parking_spot` varchar(20) DEFAULT NULL,
      `class` varchar(1) DEFAULT NULL,
      `img` varchar(50) DEFAULT NULL,
      `register` varchar(1) NOT NULL DEFAULT 't'
      ) ENGINE=MyISAM DEFAULT CHARSET=latin1;


      CREATE TABLE `realtimeo` (
      `vehicle_num` varchar(20) NOT NULL,
      `fee` varchar(20) NOT NULL,
      `hour` varchar(20) NOT NULL,
      `img` varchar(20) DEFAULT NULL,
      `parked` VARCHAR(50) DEFAULT NULL
      ) ENGINE=MyISAM DEFAULT CHARSET=latin1;

      CREATE TABLE `signals` (
      `id` varchar(10) NOT NULL,
      `info` varchar(10) NOT NULL
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

      CREATE TABLE `spot` (
      `spot_id` varchar(30) NOT NULL,
      `availability` varchar(1) NOT NULL DEFAULT 't',
      `type` varchar(1) NOT NULL DEFAULT 'n',
      `class` varchar(1) NOT NULL DEFAULT 'a',
      `parked_vehicle` varchar(7) DEFAULT NULL,
      `parked_time` varchar(50) DEFAULT NULL,
      `info` varchar(10) NOT NULL DEFAULT 'active'
      ) ENGINE=MyISAM DEFAULT CHARSET=latin1;

      CREATE TABLE `tolls` (
      `feeid` varchar(50) NOT NULL,
      `toll_per_hour` int NOT NULL
      ) ENGINE=MyISAM DEFAULT CHARSET=latin1;

      CREATE TABLE `users` (
      `uname` varchar(20) NOT NULL,
      `pass` varchar(20) NOT NULL,
      `type` varchar(20) NOT NULL,
      `email` varchar(20) NOT NULL
      ) ENGINE=MyISAM DEFAULT CHARSET=latin1;

      CREATE TABLE `vehicle` (
      `vehicle_num` varchar(7) NOT NULL,
      `vehicle_type` varchar(20) NOT NULL,
      `vehicle_class` varchar(1) NOT NULL DEFAULT 'c',
      `status` varchar(1) NOT NULL DEFAULT 't',
      `owner` varchar(50) NOT NULL,
      `phone` varchar(10) NOT NULL,
      `nic` varchar(12) NOT NULL,
      `image` varchar(100) NOT NULL,
      `next_fun` varchar(1) NOT NULL DEFAULT 'i'
      ) ENGINE=MyISAM DEFAULT CHARSET=latin1;


      ALTER TABLE `payment_signal`
      ADD UNIQUE KEY `payment_id` (`payment_id`);


      ALTER TABLE `spot`
      ADD PRIMARY KEY (`spot_id`);


      ALTER TABLE `users`
      ADD PRIMARY KEY (`uname`);


      ALTER TABLE `vehicle`
      ADD PRIMARY KEY (`vehicle_num`);
      COMMIT;

      ";
      $sql1 = "
      USE `" . $dbname2 . "`;
      SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';
      START TRANSACTION;
      SET time_zone = '+05:00';

      CREATE TABLE `revenue` (
      `AvRevenue` int DEFAULT NULL,
      `day` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
      `total_revenue` int DEFAULT NULL,
      `week_count` int DEFAULT NULL
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

      CREATE TABLE `spots` (
      `revenue` int DEFAULT '0',
      `spots_id` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
      `total_vehicle` int DEFAULT '0'
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

      CREATE TABLE `statbyday` (
      `AverageIn` int DEFAULT NULL,
      `AverageOut` int DEFAULT NULL,
      `day` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
      `i` int DEFAULT NULL,
      `o` int DEFAULT NULL
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

      INSERT INTO `statbyday`(`AverageIn`, `AverageOut`, `day`, `i`, `o`) VALUES (0,0,'Sunday',0,0), (0,0,'Monday',0,0), (0,0,'Tuesday',0,0),(0,0,'Wednesday',0,0), (0,0,'Thursday',0,0), (0,0,'Friday',0,0), (0,0,'Saturday',0,0);

      CREATE TABLE `totals` (
      `revenue` int DEFAULT NULL,
      `vehicle` int DEFAULT NULL,
      `vehicle_in` int DEFAULT NULL,
      `vehicle_out` int DEFAULT NULL
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

      INSERT INTO `totals`(`revenue`, `vehicle`, `vehicle_in`, `vehicle_out`) VALUES (0,0,0,0);

      INSERT INTO `revenue`(`AvRevenue`, `day`, `total_revenue`, `week_count`) VALUES (0,'Sunday',0,0), (0,'Monday',0,0), (0,'Tuesday',0,0),(0,'Wednesday',0,0), (0,'Thursday',0,0), (0,'Friday',0,0), (0,'Saturday',0,0);

      ALTER TABLE `revenue`
      ADD PRIMARY KEY (`day`);

      ALTER TABLE `spots`
      ADD PRIMARY KEY (`spot_id`);

      ALTER TABLE `statbyday`
      ADD PRIMARY KEY (`day`);

      COMMIT;
      ";
      
      if ($connection1->multi_query($sql) === TRUE) {
        echo "Table created successfully";
        
        $servername = "localhost";
        $username = "root";
        $password = "";

        // Create a database connection
        $connection1 = new mysqli($servername, $username, $password);
        
        // Check if the connection was successful
        if ($connection1->connect_error) {
          die("Connection failed: " . $connection1->connect_error);
        }
        if ($connection1->multi_query($sql1) === TRUE) {
          echo "Table created successfully";

          $folder_name = $client;

          // try to make a folder
          try{
            // Create main folder
            $main_folder = "/var/www/html/users/" . $folder_name;
            mkdir($main_folder);

            // Set permissions for the main folder
            chmod($main_folder, 0777); // Set all permissions for owner, group, and others

            // Create sub-folders
            $path = $main_folder . "/uploads";
            mkdir($path);
            chmod($path, 0777);

            $path = "../ogate/images/" . $folder_name;
            mkdir($path);
            chmod($path, 0777);

            $path = "../images/" . $folder_name;
            mkdir($path);
            chmod($path, 0777);

            $path = "../images/ingate/" . $folder_name;
            mkdir($path);
            chmod($path, 0777);

            $path = "../images/notRegister/" . $folder_name;
            mkdir($path);
            chmod($path, 0777);

            $path = "../images/outgate/" . $folder_name;
            mkdir($path);
            chmod($path, 0777);

            $path = "../bills/" . $folder_name;
            mkdir($path);
            chmod($path, 0777);

            $_SESSION['add'] = 'success';
            // rederect to index page
            header('Location: index.php');
          }
          catch(Exception $e){
            $_SESSION['add'] = 'err';
            // rederect to index page
            header('Location: index.php');
          }
          
        } else {
          $_SESSION['add'] = 'fail';
          echo "Error creating table: " . $connection1->error;
          // rederect to index page
          header('Location: index.php');
        }
      } else {
        $_SESSION['add'] = 'fail';
        echo "Error creating table: " . $connection1->error;
        // rederect to index page
        header('Location: index.php');
      }
    } else {
      $_SESSION['add'] = 'fail';
      echo "Error creating database: " . $connection1->error;
      // rederect to index page
      header('Location: index.php');
    }
  } else {
    $_SESSION['add'] = 'fail';
    echo "Error: " . $connection->error;
    // rederect to index page
    header('Location: index.php');
  }
  
  // Close the database connection
  $connection->close();
  
  ?>
  