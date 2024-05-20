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
$sql = "SELECT * FROM `realtime` WHERE 1";

// Execute the query
$result = mysqli_query($link, $sql);
$num_rows = mysqli_num_rows($result);

if ($num_rows == 1){
    # register
    $sql2 = "SELECT `register`,`img`,`vehicle_num` FROM `realtime` WHERE 1";

    $result2 = mysqli_query($link, $sql2);
    $row1 = mysqli_fetch_all($result2);
    $register =  $row1[0][0];

    if($register == "t"){
        // Loop through the result set
        while ($row = mysqli_fetch_assoc($result)) {
            echo '

            <!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Parking IN Gate Display</title>
	<style>
		body {
			margin: 0;
			padding: 0;
			width: 100%;
			height: 100%;
			font-family: Arial, sans-serif;
			text-align: center;
			font-size: 16px;
			line-height: 1.5;
			color: #333;
			background-color: #f5f5f5;
		}
		h1 {
			font-size: 36px;
			margin: 0 0 20px;
		}
		h2 {
			font-size: 24px;
			margin: 30px 0 20px;
		}
		p {
			font-size: 18px;
			margin: 20px 0;
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
			flex-wrap: wrap;
			justify-content: center;
			align-items: center;
			margin: 0 auto;
			width: 80%;
		}
		.col {
			flex-basis: 100%;
			max-width: 30%;
			text-align: center;
			margin-bottom: 20px;
		}
		img {
			max-width: 100%;
			height: 30%;
		}
		#parking-cost {
			font-size: 28px;
			margin-bottom: 0;
		}
		#vehicle_num {
			font-size: 35px;
			margin-top: 0;
		}
		#msg {
			font-size: 28px;
			margin-top: 0;
		}
		#parking-time {
			font-size: 28px;
		}
	</style>
</head>
<body>
<div class="row">
	<div class="col">
		<h1>Parking IN Gate</h1>
		<img src="../images/ingate/';
        echo $_SESSION['client'];
        echo '/';
        echo $row['vehicle_num'];
        echo '-i.jpg" alt="Parking entrance image">
	</div>
</div>
<p id="vehicle_num">Vehicle Number: ';
echo $row['vehicle_num'];
echo '</p>
<p id="parking-cost">Parking Spot: <b>';
echo $row['parking_spot'];

echo '</b></p>
<p id="msg">Please Park Your Vehicle in Only the <b>';
echo $row['parking_spot'];

echo '</b> Spot.</p>
</body>
</html>

            
            ';
        }
    }
    # Not registered vehicles
    else{
        echo '<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Untitled</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
</head>

<body>
    <div class="px-4 py-5 my-5 text-center"><img src="../images/notRegister/' . $_SESSION['client'] . '/';

        echo $row1[0][1];

        echo '" width="253" height="187">
        <h1 class="display-5 fw-bold" style="color: var(--bs-red);">Not Register Vehicle - ';
        echo $row1[0][2];
        echo '
        </h1>
        <div class="col-lg-6 m-auto">
            <div class="d-grid gap-2 d-sm-flex justify-content-sm-center"><a target="_blank" href="../addnewvehicle.php?vehicle=';

        echo $row1[0][2];

        echo '"> <button class="btn btn-primary btn-lg px-4 gap-3" type="button">Register Now</button></a></div>
        </div>
    </div>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>

        
        
        
        ';
    }


    }
else{
    echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
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
</html>';
}




// Close the connection
mysqli_close($link);