<?php
include 'conn.php';
if (isset($_POST['nic'])) {
    if (isset($_POST['owner'])) {
        $vehicle_id = mysqli_real_escape_string($link, $_POST['vehicleID']);
        $type = mysqli_real_escape_string($link, $_POST['type']);
        $class = mysqli_real_escape_string($link, $_POST['class']);
        $owner = mysqli_real_escape_string($link, $_POST['owner']);
        $image = $_FILES["uploaded_file"];
        $phone = mysqli_real_escape_string($link, $_POST['phone']);
        $nic = mysqli_real_escape_string($link, $_POST['nic']);
        
        // Check if the vehicle id already exists in the table
        $sqlVal = "SELECT `vehicle_num` FROM `vehicle` WHERE `vehicle_num` = '$vehicle_id'";
        $result = mysqli_query($link, $sqlVal);
        $num_rows = mysqli_num_rows($result);

        if ($num_rows == 0) {
            // image upload
            if (isset($_FILES["uploaded_file"])) {
                // File information
                $file_name = $_FILES['uploaded_file']['name'];
                $file_tmp = $_FILES['uploaded_file']['tmp_name'];
                $file_size = $_FILES['uploaded_file']['size'];
                $file_error = $_FILES['uploaded_file']['error'];
                // vehicle id uppercase
                $vehicle_id = strtoupper($vehicle_id);
                $image_name = $vehicle_id . ".jpg";
                // File upload path
                $upload_path = 'images/' . $_SESSION['client'] . '/' . $vehicle_id . '.jpg';

                // Allowed file types
                $allowed_types = array(IMAGETYPE_JPEG); //only jpeg

                // Get file type
                $detected_type = exif_imagetype($file_tmp);

                // Check if the file is an image and the correct type
                if (in_array($detected_type, $allowed_types) && $file_error === 0) {
                    // Check file size
                    if ($file_size <= 2097152) { // 2MB

                        // Prepare the SQL statement
                        $sql = $link->prepare("INSERT INTO `vehicle`(`vehicle_num`, `vehicle_type`, `vehicle_class`, `owner`, `phone`, `nic`, `image`) VALUES (?,?,?,?,?,?,?)");
                        
                        if (!$sql) {
                            $_SESSION['reg'] = 'fail';
                            header("Location: vehicle.php");
                        }

                        // Bind the values to the placeholders
                        $sql->bind_param("sssssss", $vehicle_id, $type, $class, $owner, $phone, $nic, $image_name);

                        if ($sql->execute()) {
                            // The query was executed successfully
                            // Execute the query
                           /* if ($sql->execute()) {*/
                                // Move the file to the uploads folder
                                if (move_uploaded_file($file_tmp, $upload_path)) {
                                    $_SESSION['reg'] = 'success';
                                    header("Location: vehicle.php");
                                    
                                } else {
                                    $_SESSION['reg'] = 'success';
                                    header("Location: vehicle.php");
                                }
                            /*} else {
                                $_SESSION['reg'] = 'fail';
                                header("Location: vehicle.php");
                            }*/
                        } else {
                            // An error occurred during execution
                            $_SESSION['reg'] = 'fail';
                            header("Location: vehicle.php");
                        }

                        

                    } else {
                        $_SESSION['reg'] = 'fail';
                        header("Location: vehicle.php");
                    }
                } else {
                    $_SESSION['reg'] = 'fail';
                    header("Location: vehicle.php");
                }
            } else {
                $_SESSION['reg'] = 'fail';
                header("Location: vehicle.php");
            }

        } else {
            $_SESSION['reg'] = 'fail';
            header("Location: vehicle.php");
        }


    } else {
        $_SESSION['reg'] = 'fail';
        header("Location: addnew.php");
    }
}

if (isset($_POST['spotid'])){
    $spotID = $_POST['spotid'];
    $spotType = $_POST['type'];
    $spotClass = $_POST['class'];

    // Spot ID Validation
   echo 'Add spot Successfully';
   header("Location: parking_spots.php");
    $sqlValidateID = "SELECT `spot_id` FROM `spot` WHERE `spot_id`='$spotID'";
    $result1 = mysqli_query($link, $sqlValidateID);
    $num_rows = mysqli_num_rows($result1);
    if ($num_rows > 0){
        $_SESSION['add'] = 'id_error';
        header("Location: addnewspot.php");
    }
    else{
        // try to insert data
        $sqlInsertData = "INSERT INTO `spot`(`spot_id`,`type`, `class`) VALUES ('$spotID','$spotType','$spotClass')";
        $result2 = mysqli_query($link, $sqlInsertData);

        //update table NULL
        $sqlInsertData1 = "UPDATE `spot` SET `parked_vehicle`='',`parked_time`='' WHERE `spot_id`='$spotID'";
        $result3= mysqli_query($link, $sqlInsertData1);
        // close connection
        mysqli_close($link);

        // add data to Stat DB
        // first connect database
        $dbName = "pms-stats-" . $_SESSION['client'];
        $linkStat = mysqli_connect('localhost', 'root', '', $dbName);

        // Check connection
        if (!$linkStat) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // try to insert data
        $sqlDataAddStat = "INSERT INTO `spots`(`spots_id`) VALUES ('$spotID')";
        $result3 = mysqli_query($linkStat, $sqlDataAddStat);

        if (mysqli_affected_rows($link) > 0 && mysqli_affected_rows($linkStat) > 0){
            $_SESSION['add'] = 'success';
            header("Location: parking_spots.php");
        }
        else{
            $_SESSION['add'] = 'db_error';
            header("Location: addnewspot.php");
        }
    }
    
}



if (isset($_POST['username'])){
    $username = $_POST['username'];
    $role = $_POST['role'];
    $pass = $_POST['password'];

    echo $username . $role . $pass;

    // DB config
    $link1 = mysqli_connect('localhost', 'root', '', 'pms-ml-clients');

    // Check connection
    if (!$link1) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Username Validation

    $sqlValidateUserName = "SELECT `uname` FROM `users` WHERE `uname`='$username'";
    $result2 = mysqli_query($link1, $sqlValidateUserName);
    $num_rows1 = mysqli_num_rows($result2);

    if ($num_rows1 > 0){
        $_SESSION['add'] = 'id_error';
        header("Location: addnewuser.php");
    }
    else{
        $client = $_SESSION['client'];
        echo $client;
        $email = 'admin@' . $client . '.lk';
        // try to insert data
        $sqlInsertData1 = "INSERT INTO `users`(`client`, `email`, `password`, `role`, `uname`) VALUES ('$client','$email','$pass','$role','$username')";
        $result3 = mysqli_query($link1, $sqlInsertData1);

        if (mysqli_affected_rows($link1) > 0){
            $_SESSION['add'] = 'success';
            header("Location: addnewuser.php");
        }
        else{
            $_SESSION['add'] = 'db_error';
            header("Location: addnewuser.php");
        }
    }
}


// delete spot
if (isset($_POST['spotid-delete'])) {
    $spotID_delete = $_POST['spotid-delete'];

    // Spot ID Validation
    $sqlValidateID = "SELECT `spot_id` FROM `spot` WHERE `spot_id`='$spotID_delete'";
    $result3 = mysqli_query($link, $sqlValidateID);
    $num_rows3 = mysqli_num_rows($result3);

    if ($num_rows3 > 0) {
        // Data exists for the spot_id, so delete it
        $sqlDeleteSpot = "DELETE FROM `spot` WHERE `spot_id`='$spotID_delete'";
        $resultDelete = mysqli_query($link, $sqlDeleteSpot);

        if ($resultDelete) {
            // Deletion was successful
            $_SESSION['remove'] = 'success';
        } else {
            // Deletion failed
            $_SESSION['remove'] = 'db_error';
        }
    } else {
        // No data exists for the spot_id
        $_SESSION['remove'] = 'id_error';
        header("Location: parking_spots.php");
        exit(); // Terminate script execution after redirect
    }

    // Redirect to the desired location
    header("Location: parking_spots.php");
    exit(); // Terminate script execution after redirect
}



