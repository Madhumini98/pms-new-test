<?php
session_start();
if (!isset($_SESSION['login'])){
  header("Location: ../loginform.php");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $vehicleNumber = $_POST['vehicleNumber'];
    $entryExit = $_POST['entryExit'];

    $client = $_SESSION['client'];
    // Read session and change database name
    // Connect to the database
    $dbname = 'pms-ml-' . $client;
    $link = mysqli_connect('localhost', 'root', '', $dbname);

    // Check connection
    if (!$link) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Check if the vehicle is registered
    $sql_check_registration = "SELECT * FROM `vehicle` WHERE `vehicle_num`='$vehicleNumber'";
    $result_check_registration = mysqli_query($link, $sql_check_registration);

    if (mysqli_num_rows($result_check_registration) > 0) {
        if ($entryExit == 'enter') {
            // Check if there is an available spot
            $sql_check_spot = "SELECT * FROM `spot` WHERE `availability`='t'";
            $result_check_spot = mysqli_query($link, $sql_check_spot);

            if (mysqli_num_rows($result_check_spot) > 0) {
                // Get the first available spot
                $row = mysqli_fetch_assoc($result_check_spot);
                $spot_id = $row['spot_id'];

                // Update vehicle status
                $sql_update_vehicle = "UPDATE `vehicle` SET `status`='t',`next_fun`='o' WHERE `vehicle_num`='$vehicleNumber'";
                $result_update_vehicle = mysqli_query($link, $sql_update_vehicle);

                if ($result_update_vehicle) {
                    // Update spot table
                    $current_time = date("Y-m-d H:i:s");
                    $sql_update_spot = "UPDATE `spot` SET `availability`='f',`parked_vehicle`='$vehicleNumber',`parked_time`='$current_time' WHERE `spot_id`='$spot_id'";
                    $result_update_spot = mysqli_query($link, $sql_update_spot);

                    if ($result_update_spot) {
                        $_SESSION['manual_add'] = "success";
                    } else {
                        $_SESSION['manual_add'] = "Error";
                    }
                } else {
                    $_SESSION['manual_add'] = "Error";
                }
            } else {
                $_SESSION['manual_add'] = "Parking is Full";
            }
        } else {           

            // Update spot table for exit
            $sql_exit_spot = "UPDATE `spot` SET `availability`='t',`parked_vehicle`='',`parked_time`='' WHERE `parked_vehicle`='$vehicleNumber'";
            $result_exit_spot = mysqli_query($link, $sql_exit_spot);

            if ($result_exit_spot) {
               // Call Python script with the my_function
               $pythonScript = "bill.py";
               $command = "python3 $pythonScript newUpdate_parking_cost_bill $vehicleNumber $client";
               $output = exec($command);
              $_SESSION['manual_add'] = "success";
            } else {
                $_SESSION['manual_add'] = "Error";
            }
        }
    } else {
        $_SESSION['manual_add'] = "Not Register Vehicle";
    }

    // Close the database connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <title>Manual Enter and Exit</title>
  <!--    Sweet Alert -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
  <style>
    body {
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }
    .form-container {
      max-width: 400px;
      width: 100%;
      padding: 20px;
      border: 1px solid #ddd;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    .form-container h2 {
      text-align: center;
      margin-bottom: 20px;
    }
    .form-container .form-group {
      margin-bottom: 20px;
    }
    .form-container .form-group label {
      font-weight: bold;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h2>Manual Enter and Exit</h2>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <div class="form-group">
        <label for="vehicleNumber">Vehicle Number</label>
        <input type="text" class="form-control" id="vehicleNumber" name="vehicleNumber" placeholder="Enter vehicle number">
      </div>
      <div class="form-group">
        <label for="entryExit">Select Enter or Exit</label>
        <select class="form-control" id="entryExit" name="entryExit">
          <option value="enter">Enter</option>
          <option value="exit">Exit</option>
        </select>
      </div>
      <button type="submit" class="btn btn-primary btn-block">Submit</button>
    </form>
  </div>
</body>
</html>


<?php
if (isset($_SESSION['manual_add'])){
    if ($_SESSION['manual_add'] == 'success') {
        echo '<script>swal("Success", "Work success.", "success");</script>';

    }
    if ($_SESSION['manual_add'] == 'Not Register Vehicle') {
        echo '<script>swal("Error", "Not Register Vehicle", "error");</script>';

    }
    if ($_SESSION['manual_add'] == 'Parking is full') {
      echo '<script>swal("Error", "Parking is full", "error");</script>';

  }
    if ($_SESSION['manual_add'] == 'Error') {
        echo '<script>swal("Error", "Something wrong please try again.", "error");</script>';

    }
    unset($_SESSION['manual_add']);
}
