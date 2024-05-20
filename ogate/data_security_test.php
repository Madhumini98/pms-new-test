<?php
session_start();
// Connect to the database
$dbName = "pms-ml-" . $_SESSION['client'];
$link = mysqli_connect('localhost', 'root', '', $dbName);

// Check connection
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get a now time in srilanka
date_default_timezone_set("Asia/Colombo");
$now = date("m/d/Y H:i:s");

// Write a SQL query
$sql = "SELECT * FROM `realtimeo` WHERE 1";

// Execute the query
$result = mysqli_query($link, $sql);
$num_rows = mysqli_num_rows($result);
$data = mysqli_fetch_all($result);
$vehicle = $data[0][0];
$paked_time = $data[0][4];


if ($num_rows == 1){
    echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Outgate</title>
        <style>

        body {
            background-color: rgb(217, 238, 225);
        }
        
        h1 {
            margin: 5px 20px 0px 20px;
            font-size: 80px;
        }
        
        .main {
            display: flex;
            margin-left: 5rem;
            font-size: 30px;
        }
        
        img {
            height: 300px;
            width: 300px;
        }
        
        .gr {
            border: 15px solid green;
            padding: 20px 20px 20px 20px;
            margin: 50px 0px 0px 10px;
            background-color: #f1f1f1;
        }
        
        
        .gr1 {
            border: 15px solid green;
            padding: 20px 20px 20px 20px;
            margin: 50px 0px 0px 0px;
            background-color: #f1f1f1;
        }
        
        .gr2 {
            border: 15px solid green;
            background-color: #f1f1f1;
            padding: 20px 20px 20px 20px;
            margin: 50px 50px 0px 0px;
        }
        
        p {
            padding: 0px 0px;
            margin: 10px 0px;
        }
        
        .button {
            background-color: #4CAF50;
            /* Green */
            border: none;
            border-radius: 3px;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-top: 35px;
            margin-left: 10px;
        }
        
        h3 {
            margin: 5px;
        }

        </style>
    </head>
    <body>
        <center>
            <h1>Parking OUT Gate</h1>    
    
            <div class="main">
                <div class="gr" >
                    <img src="../images/ingate/'. $_SESSION['client']. '/';
                    echo $data[0][0];
                    echo '-i.jpg" >
                    <h3><b>In Time:</b> <br>';
                    echo $paked_time;
                    echo ' </h3>                             
                </div>  
                
                <div class="gr1" >
                    <img src="../images/outgate/'. $_SESSION['client']. '/';
                    echo $data[0][0];
                    echo '-o.jpg" >
                    <h3><b>Out Time:</b> <br>';
                    echo $now;
                    echo ' </h3>                              
                </div> 
                
                <div class="gr2" style="padding-top: 40px ;">
                    <h3>Vehical Number:<br> "';
                    echo $data[0][0];
                    echo '"</h3>       
                    <p>Parking Hours: ';
                    echo $data[0][2];
                    echo ' Hours </p>
                    <p>Parking Cost: <span style="color:red;">Rs.';
                    echo $data[0][1];
                    echo ' </span></p>
                    <br>
                    <P><b>You can pay cash or online</b></P> 
                    
                    <div >                    
                    <a href="update.php?meth=online&vnum=';
                    echo $data[0][0];
                    echo '"><input type="button" class="button" value="Online Payment"> </a>
                    <a href="update.php?meth=done&vnum=';
                    echo $data[0][0];
                    echo '">
                        <input type="button" class="button" value="Payment Done"> </a>
                    </div>
                </div>
            </div>   
        </center>         
       
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