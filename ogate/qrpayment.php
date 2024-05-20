<?php
session_start();
echo '<!DOCTYPE html>
<html>
<head>
    <title>Center Image</title>
    <style>
        .center {
          display: flex;
          justify-content: center;
          align-items: center;
          height: 100vh;
        }

        .center img {
          max-width: 100%;
          max-height: 100%;
        }
    </style>
</head>
<body style="background-color: black;">
    <div class="center">
      <img src="images/';
      echo $_SESSION['client'];
      echo '/';
      echo $_SESSION['vehicle_For_QR'] . "-qr";
      echo'.png" alt="QR Code Loading" />
    </div>
</body>
</html>
';
?>
