
<?php
session_start();
if (!isset($_SESSION['login'])){
    header("Location: loginform.php");
}
else{
    if($_SESSION['role'] != 'sadmin' && $_SESSION['role'] != 'admin'){
        session_destroy();
        header("Location: loginform.php");
    }
}
?>

<?php


$isEnable = '';

// Connect to the iPMS-clients database
$dbname = 'iPMS-clients';
$link = mysqli_connect('localhost', 'root', '', $dbname);

if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve the 'mode' value from the 'clients' table
$client = $_SESSION['client'];
$sql1 = "SELECT mode FROM clients WHERE name = '$client'";
$result1 = mysqli_query($link, $sql1);

if ($result1) {
    $row1 = mysqli_fetch_assoc($result1);
    $isEnable = ($row1['mode'] === 't') ? 'enable' : 'disable';
    $_SESSION['isEnable'] = $isEnable;
   
} else {
    // Handle the error if the query fails
    // You can set $isEnable to a default value or handle the error as needed
}

// Close the database connection
mysqli_close($link);
?>