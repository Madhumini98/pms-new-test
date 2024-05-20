<?php
session_start();
// Connect to the database
$dbName = "pms-ml-" . $_SESSION['client'];
$link = mysqli_connect('localhost', 'root', '', $dbName);

// Check connection
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

// Write a SQL query
$sql = "SELECT * FROM `realtimeo` WHERE 1";

// Execute the query
$result = mysqli_query($link, $sql);
$num_rows = mysqli_num_rows($result);
$data = mysqli_fetch_all($result);
$vehicle = $data[0][0];
// Write sql query to get the parked time from the database
$sql1 = "SELECT `parked_time` FROM `spot` WHERE `parked_vehicle`='$vehicle'";
$result1 = mysqli_query($link, $sql1);
$num_rows1 = mysqli_num_rows($result1);
$data1 = mysqli_fetch_all($result1);
if ($num_rows1 == 1){
    $paked_time = $data1[0][0];
}
else{
    $paked_time = "00:00:00";
}

// Get a now time in srilanka
date_default_timezone_set("Asia/Colombo");
$now = date("m/d/Y H:i:s");

if ($num_rows == 1){
    echo '<!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>Parking Exit Gate Display</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                text-align: center;
            }
            h1 {
                font-size: 36px;
            }
            h2 {
                font-size: 24px;
                margin-top: 30px;
            }
            p {
                font-size: 18px;
                margin-top: 20px;
            }
            button {
                font-size: 20px;
                padding: 10px 20px;
                background-color: #4CAF50;
                color: white;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }
            .row {
                display: flex;
                flex-direction: row;
                flex-wrap: wrap;
                justify-content: center;
                align-items: center;
    
            }
            .col {
                flex-basis: 33.33%;
                max-width: 33.33%;
                text-align: center;
                margin-bottom: 20px;
            }
            img {
                max-width: 70%;
                height: 50%;
            }
            #parking-cost {
                font-size: 28px;
            }
            #vehicle_num {
                font-size: 28px;
            }
            #parking-time {
                font-size: 28px;
            }
        </style>
    </head>
    <body>
        <div class="row">
            <div class="col">
                <h2>Enter - ';
                echo $paked_time;
                echo '</h2>
                <img id="incoming-img" src="../images/ingate/'. $_SESSION['client']. '/';
                echo $data[0][0];
                echo '-i.jpg" alt="Parking entrance image">
            </div>
            <div class="col">
                <h2>Exit - ';
                echo $now;
                echo '</h2>
                <img id="outgoing-img" src="../images/outgate/'. $_SESSION['client']. '/';
                echo $data[0][0];
                echo '-o.jpg" alt="Parking exit image">
            </div>
        </div>
        
        <p id="vehicle_num">Vehicle Num: ';
        echo $data[0][0];
        echo '</p>
        <p id="parking-cost">Parking Cost: Rs. ';
        echo $data[0][1];
        echo '</p>
        <p id="parking-time">Parking Time: ';
        echo $data[0][2];
        echo ' Hours</p>


        <a href="update.php?meth=online&vnum=';
        echo $data[0][0];
        echo '"><button>Online Payment</button> </a>
        <a href="update.php?meth=done&vnum=';
        echo $data[0][0];
        echo '"><button>Payment Done</button> </a>
    </body>
    </html>
    
    
    ';
}

else{
    echo '
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        .container-fluid, .video {
            padding: 0;
            margin: 0;
        }
    </style>
<body>
<div class="container-fluid p-0 m-0 vh-100">
    <video src="../images/video/anpr.mp4" autoplay loop muted class="w-100 h-100"></video>
</div>
</body>
</html>
    ';
}