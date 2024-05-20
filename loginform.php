<!DOCTYPE html>
<html lang="zxx">
<head>
<!--    Sweet Alert -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <title>Park'N Pay | Login Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <!-- External CSS libraries -->
    <link type="text/css" rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="assets/fonts/f/font-awesome.min.3.dela">
    <link type="text/css" rel="stylesheet" href="assets/fonts/flatico/flaticon.4.delaye">
    <!-- Favicon icon -->
    <link rel="shortcut icon" href="images/iPMS.svg" type="image/x-icon" >
    <!-- Google fonts -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800%7CPoppins:400,500,700,800,900%7CRoboto:100,300,400,400i,500,700">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet">

    <!-- Custom Stylesheet -->
    <link type="text/css" rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" type="text/css" id="style_sheet" href="assets/css/skins/default.css">

</head>
<body id="top">
<div class="page_loader"></div>

<!-- Login start -->
<div class="login-12 tab-box">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-12 bg-img">

            </div>
            <div class="col-lg-6 col-md-12 form-section">
                <div class="login-inner-form">
                    <div class="details">
                        <div class="informeson">
                            <div class="logo">
                                <a href="loginform.php">
                                    <img style="height: 150px"  src="assets/img/logos/new1.png" alt="logo">
                                </a>
                            </div>
                            <div class="animated-text">
                                <h3 style =color:blue ><b>Welcome to Park'N Pay</b></h3>
                            </div>
                        </div>
                        <form action="login.php" method="POST">
                            <div class="form-group">
                                <label for="first_field" class="form-label float-start">Username</label><?php
                                    echo $_SESSION['err'];
                                ?>
                                <input required name="uname" type="text" class="form-control" id="first_field" placeholder="Username" aria-label="Username">
                            </div>
                            <div class="form-group clearfix">
                                <label for="second_field" class="form-label float-start">Password</label>
                                <input required name="password" type="password" class="form-control" autocomplete="off" id="second_field" placeholder="Password" aria-label="Password">
                            </div>
                            <div class="form-group clearfix">
                                <button type="submit" class="btn btn-lg btn-primary btn-theme"><span>Login</span></button>
                            </div>
                        </form>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Login 12 end -->

<!-- External JS libraries -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.e.delay"></script>
<!-- Custom JS Script -->

</body>
</html>
<?php
session_start();
if (isset($_SESSION['err'])){
    if ($_SESSION['err'] == 'UserName'){
        echo '<script>swal("Oops!", "Wrong User Name!", "error");</script>';
        unset($_SESSION['err']);
    }
    if ($_SESSION['err'] == 'pass'){
        echo '<script>swal("Oops!", "Wrong Password!", "error");</script>';
        unset($_SESSION['err']);
    }

}
?>
