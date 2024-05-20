<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname1 = "iPMS-clients";

// Create a database connection
$connection1 = new mysqli($servername, $username, $password, $dbname1);

// Check if the connection was successful
if ($connection1->connect_error) {
    die("Connection failed: " . $connection1->connect_error);
}

$company = $_SESSION['client'];
$sql = "SELECT `class` FROM `clients` WHERE `name` = '$company'";
$result = mysqli_query($connection1, $sql);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Park'N Pay - Register New Vehicle</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Noto+Sans+Inscriptional+Pahlavi&amp;display=swap">
    <link rel="stylesheet" href="assets/css/Clean-Button-Scale-Hover-Effect.css">
    <link rel="stylesheet" href="assets/css/FORM.css">
</head>

<body>
<div class="text-center w-100" style="position: absolute;top: 20%;margin-top: 20%;">
    <div class="container" style="position: absolute;left: 0;right: 0;top: 50%;transform: translateY(-50%);-ms-transform: translateY(-50%);-moz-transform: translateY(-50%);-webkit-transform: translateY(-50%);-o-transform: translateY(-50%);background: rgba(255,255,255,0.05);">
        <div class="row d-flex d-xl-flex justify-content-center justify-content-xl-center">
            <div class="col-sm-12 col-lg-10 col-xl-9 col-xxl-7 bg-white shadow-lg" style="border-radius: 5px;width: 90%;">
                <div class="p-5">
                    <div class="text-center">
                        <h4 class="text-dark mb-4">Register New Vehicles</h4>
                    </div>
                    <form class="user" action="add.php" method="post" enctype="multipart/form-data">

                        <?php
                        if (isset($_GET['vehicle'])) {
                            $number = $_GET['vehicle'];
                            echo '<div class="mb-3"><input class="form-control form-control-user" name="vehicleID" type="text" placeholder="Vehicle Number" required="" style="text-align: center;" value="';
                            echo $number;
                            echo '"></div>';
                        } else {
                            echo '<div class="mb-3"><input class="form-control form-control-user" name="vehicleID" type="text" placeholder="Vehicle Number" required="" style="text-align: center;"></div>';
                        }
                        ?>

                        <div class="mb-3"><select name="type" class="form-select" style="text-align: center;">
                                <!--<option> Select Vehicle Type: </option>-->
                                <option value="h">Light Weight</option>
                                <option value="l">Long</option>    
                            </select></div>
                       
                        <div>
                            <?php
                            if ($result && mysqli_num_rows($result) > 0) {
                                $classes = mysqli_fetch_assoc($result);
                                $classArray = explode(",", $classes['class']);
                            
                                // Output the select dropdown
                                echo '<div class="mb-3"><select name="class" class="form-select" style="text-align: center;">';
                                
                                foreach ($classArray as $class) {
                                    // Assuming class names are single characters, e.g., 'A', 'B', 'C'
                                    $class = trim($class);
                                    echo '<option value="' . $class . '">' . $class . '</option>';
                                }
                            
                                echo '</select></div>';
                            } else {
                                echo 'No classes found for this company.';
                            }
                            ?>
                        </div>
                        <div class="mb-3"><input name="owner" class="form-control form-control-user" type="text" placeholder="Owner Name" required="" style="text-align: center;"></div>
                        <div class="mb-3"><input name="nic" class="form-control form-control-user" type="text" placeholder="NIC Number" required="" style="text-align: center;"></div>
                        <div class="mb-3">
                            <input required name="phone" class="form-control" type="tel" placeholder="07XXXXXXXX" style="text-align: center;">
                        </div>
                        <div class="mb-3">
                            <input required class="form-control" type="file" style="text-align: center;" name="uploaded_file" value="Vehicle front image.">
                        </div>


                        <?php
                        if (isset($_GET['vehicle'])) {
                            $number = $_GET['vehicle'];
                            echo '<div class="row mb-3"><a href="images/notRegister/' . $_SESSION['client'] . '/';
                            $imgName = $number. ".jpg";
                            echo $imgName;
                            echo '" download="">Download Your Image</a></div>';
                        }
                        ?>
                        <div class="row mb-3">
                            <p id="emailErrorMsg" class="text-danger" style="display:none;">Paragraph</p>
                            <p id="passwordErrorMsg" class="text-danger" style="display:none;">Paragraph</p>
                        </div>
                        <button class="btn btn-primary d-block btn-user w-100" id="submitBtn" type="submit">Register Vehicle</button>
                        <hr>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/Button-Ripple-Effect-Animation-Wave-Pulse.js"></script>
</body>

</html>