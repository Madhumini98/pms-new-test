<?php
session_start();
// Connect to the database
$dbName = "pms-ml-" . $_SESSION['client'];
$link = mysqli_connect('localhost', 'root', '', $dbName);

// Check connection
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['meth']) and isset($_GET['vnum'])){
    
    $method = $_GET['meth'];
    $vehicleNum = $_GET['vnum'];

    if($method == 'online'){

        // update the signals table
        $sql = "UPDATE `signals` SET `info`='online' WHERE `id`='$vehicleNum'";
        // execute query
        $result = mysqli_query($link, $sql);
        // rederection for oGate.php
        header("Location: oGate_security.php");
        
    }
    else{
        if($method == 'done'){
        $sql = "UPDATE `signals` SET `info`='cashier' WHERE `id` = '$vehicleNum'";

        // execute query
        $result = mysqli_query($link, $sql);

        $link->close();
            if ($result){
                header("Location: oGate_security.php");
                exit();
            }
            else{
                echo "Error: " . $sql . "<br>" . mysqli_error($link);
            }
        }
        else{
            echo "Authentication Error";
        }
    }
    

    
    


}
else{
    header("Location: oGate.php");
}