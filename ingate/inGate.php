<?php
session_start();
include 'conn.php';
if (isset($_SESSION['login'])){

    if (!$_SESSION['login']){
        header("Location=index.php");
    }
}
else{
    header("Location:../loginform.php");
}


?>

<!DOCTYPE html>
<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        setInterval(function(){
            $.ajax({
                type: "GET",
                url: "refresh.php",
                success: function(data) {
                    $("#content").html(data);
                }
            });
        }, 5000);
    </script>
</head>
<body>
<div id="content">
    <?php
    // Write a SQL query
    $sql = "SELECT * FROM `realtimeo` WHERE 1";

    // Execute the query
    $result = mysqli_query($link, $sql);
    $num_rows = mysqli_num_rows($result);

    if ($num_rows == 0){
        echo '<img src="img/banner.jpg" style="width: 100%; height: 100%; object-fit: contain;">';
    }
    else{
        include 'data.php';
    }

     ?>
</div>
</body>
</html>
