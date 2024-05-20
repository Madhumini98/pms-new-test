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

// Check if parking is full
$sql3 = "SELECT `spot_id` FROM `spot` WHERE `availability`='t'";
$result3 = mysqli_query($link, $sql3);
$num_rows3 = mysqli_num_rows($result3);

if ($num_rows3 == 0){
	echo'
	
	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Parking_full</title>
	</head>
	<style>
		body{
			background-color: rgb(217, 238, 225) 
		}
		h1{
		margin: 10%;    
		font-size: 80px;
		color: red;
	}
	img{
		height: 300px;
		width: 300px;
		
	}
	</style>
	<body>
	<center>
		<div>
			<h1>Parking Lot Full Now!!!</h1>
		</div>  
		
		<div>
			<img src="images/nopark.jpg">
		</div>
	</center>
	</body>
	</html>
	
	';
}
else{
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
				<html lang="en">
				<head>
					<meta charset="UTF-8">
					<meta http-equiv="X-UA-Compatible" content="IE=edge">
					<meta name="viewport" content="width=device-width, initial-scale=1.0">
					<title>Ingate</title>
					<style>
					body{
						background-color: rgb(217, 238, 225) ;
					}
					
					h1{
						margin: 5px 20px 0px 20px;    
						font-size: 80px;
					}
					
					.main{
						display: flex;
						margin-left: 5rem;    
						font-size: 30px;
					}
					
					img{
						height: 300px;
						width: 300px;      
					}
					
					.gr{  
						border: 15px solid green;
						padding: 20px 20px 20px 20px;
						margin: 50px 0px 0px 10px ;
						background-color: #f1f1f1;     
					}
					
					
					.gr1{  
						border: 15px solid green;
						padding: 20px 20px 20px 20px;
						margin: 50px 0px 0px 0px ;
						background-color: #f1f1f1;     
					}
					
					.gr2{  
						border: 15px solid green;
						background-color: #f1f1f1;
						padding: 20px 20px 20px 20px;
						margin: 50px 50px 0px 0px;
					}
					
					p{
						padding: 0px 0px;
						margin: 10px 0px;
					}
					
					.button {
						background-color: #4CAF50; /* Green */
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
					
					h3{
						margin: 5px;
					}
					</style>
				</head>
				<body>
					<center>
						<h1>Parking IN Gate</h1>    

						<div class="main" style="margin-left: 10%;">
							<div class="gr" >
								<img src="../images/ingate/';
								echo $_SESSION['client'];
								echo '/';
								echo $row['vehicle_num'];
								echo '-i.jpg" alt="Parking entrance image">
							</div>        
							
							<div class="gr1">
								<h2>Vehicle Number:"';
								echo $row['vehicle_num'];
								echo '"</h2>
								<h2>Parking Spot: <b>';
								echo $row['parking_spot'];
					
								echo '</b></h2>
								<p style="color:red; font-size: 40px;">Please park your  vehicle <br> <b>';
								echo $row['parking_spot'];
					
								echo '</b> Spot</p>
							</div>
						</div>
					
					</center>             
					
					
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
							<h1 class="display-5 fw-bold" style="color: var(--bs-red);">You Are <b>Not Registered</b> in Our System.';
							echo '<br>Vehicle Number: ';
							echo $row1[0][2];
							echo '
							</h1>
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
}





// Close the connection
mysqli_close($link);