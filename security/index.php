<?php
session_start();

$user = $_SESSION['client'];

$database = 'pms-ml-' . $user;

$conn = mysqli_connect("localhost", "root", "", $database);

$sql = "SELECT * FROM `realtimeo` WHERE 1";

$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_all($result);



if ($result->num_rows > 0) {
  $vehicle = ($data[0][0]);
} else {
  $vehicle = "No";
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Meta tags  -->
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

  <title>Park'N Pay - Dashboard</title>
  <link rel="icon" type="image/png" href="../images/iPMS.svg">

  <!--    Sweet Alert -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>


  <!-- CSS Assets -->
  <link rel="stylesheet" href="../css/app.css">

  <!-- Javascript Assets -->
  <script src="../js/app.js" defer=""></script>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
  <link href="../css2?family=Inter:wght@400;500;600;700&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
  <script>
    /**
     * THIS SCRIPT REQUIRED FOR PREVENT FLICKERING IN SOME BROWSERS
     */
    localStorage.getItem("_x_darkMode_on") === "true" &&
      document.documentElement.classList.add("dark");
  </script>
  <link href="assets/styles.css" rel="stylesheet" />

  <style>
    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      /* Ensure the body takes at least the full viewport height */
    }

    .container {
      display: flex;
      justify-content: space-around;
      align-items: stretch;
      /* Allow columns to have the same height */
      margin: 0 auto;
      flex-wrap: wrap;
      max-height: fit-content;
      max-width: 920px;

      /* Allow columns to wrap on smaller screens */
    }

    .column {
      flex: 0 1 calc(50% - 20px);
      /* Adjust column width with spacing */
      margin: 10px;
      background-color: #fff;
      /* Background color for columns */
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      /* Add a subtle shadow to columns */
      border-radius: 8px;
      overflow: hidden;
      display: flex;
      flex-direction: column;




    }

    .column h2 {
      text-align: center;
      background-color: #007BFF;
      /* Header background color */
      color: #fff;
      /* Header text color */
      padding: 10px 0;
      margin: 0;
    }

    h3 {
      text-align: center;
      background-color: #15afa4;
      /* Header background color */
      color: #fff;
      /* Header text color */
      padding: 10px 0;
      margin: 0;
    }

    .data {
      flex-grow: 1;
      /* Allow data section to take up remaining space */

      padding: 20px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      max-height: 530px;
    }

    .data img {
      max-width: 100%;
      max-height: 300px;
      height: auto;
      display: block;
      margin: 10 auto;
      /* Center images horizontally */
    }

    .data p {
      margin: 10px 0;
      text-align: center;
    }

    /* Add hover effect to columns for interactivity */
    .column:hover {
      transform: translateY(-5px);
      transition: transform 0.3s ease;
    }

    /* Button styling */
    .hover-button {

      /*position: absolute; */

      background-color: #007BFF;
      color: #fff;
      border: none;
      border-radius: 5px;
      padding: 10px 20px;
      cursor: pointer;
      font-size: 16px;
      /* Increase font size */

      /* Add transition for background color change */
    }

    /* Button styling on hover */
    .hover-button:hover {
      background-color: #0056b3;
      /* Darker background color on hover */

    }

    /* Show button on hover */
    body:hover .hover-button {
      display: block;
    }


    .data h3 {
      margin: 10px 0;
    }

    .manual-button {
      display: flex;
      justify-content: center;
      align-items: center;
      margin-top: 20px;
    }

    .footer {
      display: flex;
      justify-content: center;
      /* Horizontally center the content */
      align-items: center;
      /* Vertically center the content */
      margin-top: 20px;
      /* Adjust as needed for spacing */


    }

    .footer p {
      font-size: 18px;
      /* Set the font size */
      color: #555;
      /* Set the text color */
      margin: 0;
      /* Remove default margins to ensure proper alignment */
      padding: 10px;
      /* Add some padding for spacing */
      border-radius: 4px;
      /* Add rounded corners */
      text-align: center;
      /* Center align the text horizontally */
    }

    .footer img {
      width: 80%;
      /* Make the image take the full width of the container */
      max-width: 300px;
      /* Ensure the image doesn't exceed its original width */
      margin-bottom: 10px;
    }



    .py-5 {
      padding: 0;
    }

    .payment-option {
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .button-container {
      text-align: center;
    }

    .button {
      margin: 0 10px;
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

    .p-pay-title {
      font-weight: bold;
      padding: 0px 0px;
      margin: 10px 0px;
      font-size: x-large;
    }
  </style>

  <script>
    window.Promise ||
      document.write(
        '<script src="https://cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.min.js"><\/script>'
      )
    window.Promise ||
      document.write(
        '<script src="https://cdn.jsdelivr.net/npm/eligrey-classlist-js-polyfill@1.2.20171210/classList.min.js"><\/script>'
      )
    window.Promise ||
      document.write(
        '<script src="https://cdn.jsdelivr.net/npm/findindex_polyfill_mdn"><\/script>'
      )
  </script>


  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>


  <script>
    // Replace Math.random() with a pseudo-random number generator to get reproducible results in e2e tests
    // Based on https://gist.github.com/blixt/f17b47c62508be59987b
    var _seed = 42;
    Math.random = function() {
      _seed = _seed * 16807 % 2147483647;
      return (_seed - 1) / 2147483646;
    };
  </script>
  <script>
    function loadData_in() {
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("data_in").innerHTML = this.responseText;
        }
      };
      xhttp.open("GET", "getdata_in.php", true);
      xhttp.send();
    }

    function loadData_out() {
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("data_out").innerHTML = this.responseText;
        }
      };
      xhttp.open("GET", "getdata_out.php", true);
      xhttp.send();
    }

    setInterval(function() {
      loadData_in();
      loadData_out()
    }, 1000); // call every 1 seconds
  </script>
</head>

<body x-data="" class="is-header-blur" x-bind="$store.global.documentBody">
  <!-- App preloader-->
  <div class="app-preloader fixed z-50 grid h-full w-full place-content-center bg-slate-50 dark:bg-navy-900">
    <div class="app-preloader-inner relative inline-block h-48 w-48"></div>
  </div>

  <!-- Page Wrapper -->
  <div id="root" class=" flex grow bg-slate-50 dark:bg-navy-900" x-cloak="">
    <!-- Sidebar -->
    <div class="sidebar print:hidden">
      <!-- Main Sidebar -->
      <div class="main-sidebar">
        <div class="flex h-full w-full flex-col items-center border-r border-slate-150 bg-white dark:border-navy-700 dark:bg-navy-800">
          <!-- Application Logo -->
          <div class="flex pt-4">
            <a href="#">
              <img class="h-16 w-16 transition-transform duration-500 ease-in-out hover:rotate-[360deg]" src="../images/logos/iPMS.svg" alt="iPMS">
            </a>
          </div>

          <!-- Main Sections Links -->
          <div class="is-scrollbar-hidden flex grow flex-col space-y-4 overflow-y-auto pt-6">

            <!-- Server Status -->
            <!-- <a href="server.php" class="flex h-11 w-11 items-center justify-center rounded-lg outline-none transition-colors duration-200 hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25" x-tooltip.placement.right="'Server Status'">
              <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="50" zoomAndPan="magnify" viewBox="0 0 37.5 37.499999" height="50" preserveAspectRatio="xMidYMid meet" version="1.0"><defs><clipPath id="aa34806414"><path d="M 5.878906 3.875 L 31.378906 3.875 L 31.378906 12 L 5.878906 12 Z M 5.878906 3.875 " clip-rule="nonzero"/></clipPath><clipPath id="294d1371db"><path d="M 15 3.875 L 31.378906 3.875 L 31.378906 16 L 15 16 Z M 15 3.875 " clip-rule="nonzero"/></clipPath><clipPath id="d2f4669894"><path d="M 17 3.875 L 31.378906 3.875 L 31.378906 16 L 17 16 Z M 17 3.875 " clip-rule="nonzero"/></clipPath><clipPath id="d91879e462"><path d="M 20 3.875 L 31.378906 3.875 L 31.378906 16 L 20 16 Z M 20 3.875 " clip-rule="nonzero"/></clipPath><clipPath id="6e6c92010b"><path d="M 5.878906 12 L 31.378906 12 L 31.378906 20 L 5.878906 20 Z M 5.878906 12 " clip-rule="nonzero"/></clipPath><clipPath id="55fc91f3cc"><path d="M 15 8 L 31.378906 8 L 31.378906 25 L 15 25 Z M 15 8 " clip-rule="nonzero"/></clipPath><clipPath id="a07d158a93"><path d="M 17 8 L 31.378906 8 L 31.378906 25 L 17 25 Z M 17 8 " clip-rule="nonzero"/></clipPath><clipPath id="5261b93a12"><path d="M 20 8 L 31.378906 8 L 31.378906 25 L 20 25 Z M 20 8 " clip-rule="nonzero"/></clipPath><clipPath id="1121e46075"><path d="M 5.878906 21 L 31.378906 21 L 31.378906 29 L 5.878906 29 Z M 5.878906 21 " clip-rule="nonzero"/></clipPath><clipPath id="506439da94"><path d="M 15 17 L 31.378906 17 L 31.378906 33.875 L 15 33.875 Z M 15 17 " clip-rule="nonzero"/></clipPath><clipPath id="0f2cbe7ec3"><path d="M 17 17 L 31.378906 17 L 31.378906 33.875 L 17 33.875 Z M 17 17 " clip-rule="nonzero"/></clipPath><clipPath id="b8cf7bebfe"><path d="M 20 17 L 31.378906 17 L 31.378906 33.875 L 20 33.875 Z M 20 17 " clip-rule="nonzero"/></clipPath><clipPath id="4b3d0ddad2"><path d="M 9 33 L 18 33 L 18 33.875 L 9 33.875 Z M 9 33 " clip-rule="nonzero"/></clipPath><clipPath id="5b56525f76"><path d="M 20 33 L 29 33 L 29 33.875 L 20 33.875 Z M 20 33 " clip-rule="nonzero"/></clipPath><clipPath id="34e12966fd"><path d="M 16 31 L 21 31 L 21 33.875 L 16 33.875 Z M 16 31 " clip-rule="nonzero"/></clipPath></defs><g clip-path="url(#aa34806414)"><path fill="#274169" d="M 31.3125 10.8125 C 31.3125 10.957031 31.195312 11.074219 31.050781 11.074219 L 6.191406 11.074219 C 6.042969 11.074219 5.925781 10.957031 5.925781 10.8125 L 5.925781 4.136719 C 5.925781 3.992188 6.042969 3.875 6.191406 3.875 L 31.050781 3.875 C 31.195312 3.875 31.3125 3.992188 31.3125 4.136719 L 31.3125 10.8125 " fill-opacity="1" fill-rule="nonzero"/></g><path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 1441.316378 2954.802865 L 1441.316378 2805.227869 " stroke="#ffffff" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10"/><path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 1530.988335 2954.802865 L 1530.988335 2805.227869 " stroke="#ffffff" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10"/><path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 1620.660292 2954.802865 L 1620.660292 2805.227869 " stroke="#ffffff" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10"/><g clip-path="url(#294d1371db)"><path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 2481.879234 2870.069534 C 2481.879234 2848.627868 2464.523371 2831.061201 2442.960026 2831.061201 C 2421.396682 2831.061201 2404.040819 2848.627868 2404.040819 2870.069534 C 2404.040819 2891.5112 2421.396682 2908.819533 2442.960026 2908.819533 C 2464.523371 2908.819533 2481.879234 2891.5112 2481.879234 2870.069534 Z M 2481.879234 2870.069534 " stroke="#d7282f" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10"/></g><g clip-path="url(#d2f4669894)"><path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 2647.811799 2870.069534 C 2647.811799 2848.627868 2630.192969 2831.061201 2608.892592 2831.061201 C 2587.329247 2831.061201 2569.973385 2848.627868 2569.973385 2870.069534 C 2569.973385 2891.5112 2587.329247 2908.819533 2608.892592 2908.819533 C 2630.192969 2908.819533 2647.811799 2891.5112 2647.811799 2870.069534 Z M 2647.811799 2870.069534 " stroke="#7fcb27" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10"/></g><g clip-path="url(#d91879e462)"><path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 2810.851721 2870.069534 C 2810.851721 2848.627868 2793.495858 2831.061201 2771.932514 2831.061201 C 2750.369169 2831.061201 2733.013307 2848.627868 2733.013307 2870.069534 C 2733.013307 2891.5112 2750.369169 2908.819533 2771.932514 2908.819533 C 2793.495858 2908.819533 2810.851721 2891.5112 2810.851721 2870.069534 Z M 2810.851721 2870.069534 " stroke="#3abdc4" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10"/></g><path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 1782.122408 2921.477866 L 2284.390554 2921.477866 " stroke="#3abdc4" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10"/><path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 1782.122408 2818.661202 L 2284.390554 2818.661202 " stroke="#3abdc4" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10"/><g clip-path="url(#6e6c92010b)"><path fill="#274169" d="M 31.3125 19.425781 C 31.3125 19.570312 31.195312 19.6875 31.050781 19.6875 L 6.191406 19.6875 C 6.042969 19.6875 5.925781 19.570312 5.925781 19.425781 L 5.925781 12.75 C 5.925781 12.605469 6.042969 12.488281 6.191406 12.488281 L 31.050781 12.488281 C 31.195312 12.488281 31.3125 12.605469 31.3125 12.75 L 31.3125 19.425781 " fill-opacity="1" fill-rule="nonzero"/></g><path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 1441.316378 2385.177879 L 1441.316378 2235.602883 " stroke="#ffffff" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10"/><path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 1530.988335 2385.177879 L 1530.988335 2235.602883 " stroke="#ffffff" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10"/><path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 1620.660292 2385.177879 L 1620.660292 2235.602883 " stroke="#ffffff" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10"/><g clip-path="url(#55fc91f3cc)"><path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 2481.879234 2300.444548 C 2481.879234 2279.002882 2464.523371 2261.436216 2442.960026 2261.436216 C 2421.396682 2261.436216 2404.040819 2279.002882 2404.040819 2300.444548 C 2404.040819 2321.886214 2421.396682 2339.194547 2442.960026 2339.194547 C 2464.523371 2339.194547 2481.879234 2321.886214 2481.879234 2300.444548 Z M 2481.879234 2300.444548 " stroke="#d7282f" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10"/></g><g clip-path="url(#a07d158a93)"><path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 2647.811799 2300.444548 C 2647.811799 2279.002882 2630.192969 2261.436216 2608.892592 2261.436216 C 2587.329247 2261.436216 2569.973385 2279.002882 2569.973385 2300.444548 C 2569.973385 2321.886214 2587.329247 2339.194547 2608.892592 2339.194547 C 2630.192969 2339.194547 2647.811799 2321.886214 2647.811799 2300.444548 Z M 2647.811799 2300.444548 " stroke="#7fcb27" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10"/></g><g clip-path="url(#5261b93a12)"><path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 2810.851721 2300.444548 C 2810.851721 2279.002882 2793.495858 2261.436216 2771.932514 2261.436216 C 2750.369169 2261.436216 2733.013307 2279.002882 2733.013307 2300.444548 C 2733.013307 2321.886214 2750.369169 2339.194547 2771.932514 2339.194547 C 2793.495858 2339.194547 2810.851721 2321.886214 2810.851721 2300.444548 Z M 2810.851721 2300.444548 " stroke="#3abdc4" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10"/></g><path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 1782.122408 2351.594547 L 2284.390554 2351.594547 " stroke="#3abdc4" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10"/><path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 1782.122408 2249.036216 L 2284.390554 2249.036216 " stroke="#3abdc4" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10"/><g clip-path="url(#1121e46075)"><path fill="#274169" d="M 31.3125 28.511719 C 31.3125 28.65625 31.195312 28.777344 31.050781 28.777344 L 6.191406 28.777344 C 6.042969 28.777344 5.925781 28.65625 5.925781 28.511719 L 5.925781 21.839844 C 5.925781 21.691406 6.042969 21.578125 6.191406 21.578125 L 31.050781 21.578125 C 31.195312 21.578125 31.3125 21.691406 31.3125 21.839844 L 31.3125 28.511719 " fill-opacity="1" fill-rule="nonzero"/></g><path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 1441.316378 1784.036228 L 1441.316378 1634.719565 " stroke="#ffffff" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10"/><path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 1530.988335 1784.036228 L 1530.988335 1634.719565 " stroke="#ffffff" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10"/><path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 1620.660292 1784.036228 L 1620.660292 1634.719565 " stroke="#ffffff" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10"/><g clip-path="url(#506439da94)"><path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 2481.879234 1699.302897 C 2481.879234 1677.861231 2464.523371 1660.294564 2442.960026 1660.294564 C 2421.396682 1660.294564 2404.040819 1677.861231 2404.040819 1699.302897 C 2404.040819 1720.744563 2421.396682 1738.311229 2442.960026 1738.311229 C 2464.523371 1738.311229 2481.879234 1720.744563 2481.879234 1699.302897 Z M 2481.879234 1699.302897 " stroke="#d7282f" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10"/></g><g clip-path="url(#0f2cbe7ec3)"><path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 2647.811799 1699.302897 C 2647.811799 1677.861231 2630.192969 1660.294564 2608.892592 1660.294564 C 2587.329247 1660.294564 2569.973385 1677.861231 2569.973385 1699.302897 C 2569.973385 1720.744563 2587.329247 1738.311229 2608.892592 1738.311229 C 2630.192969 1738.311229 2647.811799 1720.744563 2647.811799 1699.302897 Z M 2647.811799 1699.302897 " stroke="#7fcb27" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10"/></g><g clip-path="url(#b8cf7bebfe)"><path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 2810.851721 1699.302897 C 2810.851721 1677.861231 2793.495858 1660.294564 2771.932514 1660.294564 C 2750.369169 1660.294564 2733.013307 1677.861231 2733.013307 1699.302897 C 2733.013307 1720.744563 2750.369169 1738.311229 2771.932514 1738.311229 C 2793.495858 1738.311229 2810.851721 1720.744563 2810.851721 1699.302897 Z M 2810.851721 1699.302897 " stroke="#3abdc4" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10"/></g><path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 1782.122408 1750.711229 L 2284.390554 1750.711229 " stroke="#3abdc4" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10"/><path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 1782.122408 1647.894565 L 2284.390554 1647.894565 " stroke="#3abdc4" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10"/><path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 2126.08405 1471.194569 L 2126.08405 1262.977908 " stroke="#274169" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10"/><g clip-path="url(#4b3d0ddad2)"><path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 2016.952489 1159.12791 L 1519.41776 1159.12791 " stroke="#274169" stroke-width="44.157001" stroke-opacity="1" stroke-miterlimit="10"/></g><g clip-path="url(#5b56525f76)"><path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 2755.628521 1159.12791 L 2257.830825 1159.12791 " stroke="#274169" stroke-width="44.157001" stroke-opacity="1" stroke-miterlimit="10"/></g><g clip-path="url(#34e12966fd)"><path fill="#3abdc4" d="M 20.578125 33.878906 L 16.660156 33.878906 L 16.660156 31.925781 L 20.578125 31.925781 L 20.578125 33.878906 " fill-opacity="1" fill-rule="nonzero"/></g></svg>
              </a> -->

            <!-- Available Slots -->
            <a href="http://165.227.144.188/pms-new/availableSlots.html" class="flex h-11 w-11 items-center justify-center rounded-lg outline-none transition-colors duration-200 hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25" x-tooltip.placement.right="'Available Slots'">

              <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                  <path d="M14.5 19.9815C16.0728 19.9415 17.1771 19.815 18 19.4151V20.9999C18 21.5522 17.5523 21.9999 17 21.9999H15.5C14.9477 21.9999 14.5 21.5522 14.5 20.9999V19.9815Z" fill="#1C274C"></path>
                  <path d="M6 19.415C6.82289 19.815 7.9272 19.9415 9.5 19.9815V20.9999C9.5 21.5522 9.05228 21.9999 8.5 21.9999H7C6.44772 21.9999 6 21.5522 6 20.9999V19.415Z" fill="#1C274C"></path>
                  <path opacity="0.5" fill-rule="evenodd" clip-rule="evenodd" d="M5.17157 3.17157C6.34315 2 8.22876 2 12 2C15.7712 2 17.6569 2 18.8284 3.17157C19.8915 4.23467 19.99 5.8857 19.9991 9L20 13C19.9909 16.1143 19.8915 17.7653 18.8284 18.8284C18.5862 19.0706 18.3136 19.2627 18 19.4151C17.1771 19.8151 16.0728 19.9415 14.5 19.9815C13.7729 19.9999 12.9458 20 12 20C11.0542 20 10.2271 20 9.5 19.9815C7.9272 19.9415 6.82289 19.815 6 19.415C5.68645 19.2626 5.41375 19.0706 5.17157 18.8284C4.10848 17.7653 4.00911 16.1143 4 13L4.00093 9C4.01004 5.8857 4.10848 4.23467 5.17157 3.17157Z" fill="#1C274C"></path>
                  <path d="M17.75 16C17.75 15.5858 17.4142 15.25 17 15.25H15.5C15.0858 15.25 14.75 15.5858 14.75 16C14.75 16.4142 15.0858 16.75 15.5 16.75H17C17.4142 16.75 17.75 16.4142 17.75 16Z" fill="#1C274C"></path>
                  <path d="M6.25 16C6.25 15.5858 6.58579 15.25 7 15.25H8.5C8.91421 15.25 9.25 15.5858 9.25 16C9.25 16.4142 8.91421 16.75 8.5 16.75H7C6.58579 16.75 6.25 16.4142 6.25 16Z" fill="#1C274C"></path>
                  <path d="M5.5 9.5C5.5 10.9142 5.5 11.6213 5.93934 12.0607C6.37868 12.5 7.08579 12.5 8.5 12.5H15.5C16.9142 12.5 17.6213 12.5 18.0607 12.0607C18.5 11.6213 18.5 10.9142 18.5 9.5V6.99998C18.5 5.58578 18.5 4.87868 18.0607 4.43934C17.6213 4 16.9142 4 15.5 4H8.5C7.08579 4 6.37868 4 5.93934 4.43934C5.5 4.87868 5.5 5.58579 5.5 7V9.5Z" fill="#1C274C"></path>
                  <path d="M2.4 11.8L4 13L4.00093 9H3C2.44772 9 2 9.44772 2 10V11C2 11.3148 2.14819 11.6111 2.4 11.8Z" fill="#1C274C"></path>
                  <path d="M21 9H19.999L20 13L21.6 11.8C21.8518 11.6111 22 11.3148 22 11V10C22 9.44772 21.5522 9 21 9Z" fill="#1C274C"></path>
                </g>
              </svg>
            </a>


          </div>



          <!-- Bottom Links -->
          <div class="flex flex-col items-center space-y-3 py-3">
            <!-- Profile -->
            <div x-data="usePopper({placement:'right-end',offset:12})" @click.outside="isShowPopper && (isShowPopper = false)" class="flex">
              <button @click="isShowPopper = !isShowPopper" x-ref="popperRef" class="avatar h-12 w-12">
                <img class="rounded-full" src="../images/logos/iPMS.svg" alt="avatar">
                <span class="absolute right-0 h-3.5 w-3.5 rounded-full border-2 border-white bg-success dark:border-navy-700"></span>
              </button>

              <div :class="isShowPopper && 'show'" class="popper-root fixed" x-ref="popperRoot">
                <div class="popper-box w-64 rounded-lg border border-slate-150 bg-white shadow-soft dark:border-navy-600 dark:bg-navy-700">
                  <div class="flex items-center space-x-4 rounded-t-lg bg-slate-100 py-5 px-4 dark:bg-navy-800">
                    <div class="avatar h-14 w-14">
                      <img class="rounded-full" src="../images/logos/iPMS.svg" alt="avatar">
                    </div>
                    <div>
                      <a href="#" class="text-base font-medium text-slate-700 hover:text-primary focus:text-primary dark:text-navy-100 dark:hover:text-accent-light dark:focus:text-accent-light">
                        <!--                          Account Type -->

                      </a>
                      <p class="text-xs text-slate-400 dark:text-navy-300">
                        <!--                          Company Name -->

                      </p>
                    </div>
                  </div>
                  <div class="flex flex-col pt-2 pb-5">
                    <div class="mt-3 px-4">
                      <a href="../logout.php"> <button class="btn h-9 w-full space-x-2 bg-primary text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewbox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                          </svg>
                          <span>Logout</span>
                        </button></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- App Header Wrapper-->
    <nav class="header print:hidden">
      <!-- App Header  -->
      <div class="header-container relative flex w-full bg-white dark:bg-navy-750 print:hidden">
        <!-- Header Items -->
        <div class="flex w-full items-center justify-between">
          <!-- Left: Sidebar Toggle Button -->
          <div class="h-7 w-7">
            <button class="sm:hidden menu-toggle ml-0.5 flex h-7 w-7 flex-col justify-center space-y-1.5 text-primary outline-none focus:outline-none dark:text-accent-light/80" :class="$store.global.isSidebarExpanded && 'active'" @click="$store.global.isSidebarExpanded = !$store.global.isSidebarExpanded">
              <span></span>
              <span></span>
              <span></span>
            </button>
          </div>

          <!-- Right: Header buttons -->
          <div class="-mr-1.5 flex items-center space-x-2">
            <!-- Dark Mode Toggle -->
            <button @click="$store.global.isDarkModeEnabled = !$store.global.isDarkModeEnabled" class="btn h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
              <svg x-show="$store.global.isDarkModeEnabled" x-transition:enter="transition-transform duration-200 ease-out absolute origin-top" x-transition:enter-start="scale-75" x-transition:enter-end="scale-100 static" class="h-6 w-6 text-amber-400" fill="currentColor" viewbox="0 0 24 24">
                <path d="M11.75 3.412a.818.818 0 01-.07.917 6.332 6.332 0 00-1.4 3.971c0 3.564 2.98 6.494 6.706 6.494a6.86 6.86 0 002.856-.617.818.818 0 011.1 1.047C19.593 18.614 16.218 21 12.283 21 7.18 21 3 16.973 3 11.956c0-4.563 3.46-8.31 7.925-8.948a.818.818 0 01.826.404z">
                </path>
              </svg>
              <svg xmlns="http://www.w3.org/2000/svg" x-show="!$store.global.isDarkModeEnabled" x-transition:enter="transition-transform duration-200 ease-out absolute origin-top" x-transition:enter-start="scale-75" x-transition:enter-end="scale-100 static" class="h-6 w-6 text-amber-400" viewbox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"></path>
              </svg>
            </button>
            <!-- <button @click="isShowPopper = !isShowPopper" x-ref="popperRef" class="avatar h-12 w-12">
                <img class="rounded-full" src="../images/logos/iPMS.svg" alt="avatar">
                <span class="absolute right-0 h-3.5 w-3.5 rounded-full border-2 border-white bg-success dark:border-navy-700"></span>
              </button>-->

            <!-- Profile || ADD Clear button-->
            <div x-data="usePopper({placement:'right-end',offset:12})" @click.outside="isShowPopper && (isShowPopper = false)" class="flex">
              <button @click="isShowPopper = !isShowPopper" x-ref="popperRef" class="avatar h-12 w-12">
                <img class="rounded-full" src="../images/logos/iPMS.svg" alt="avatar">
                <span class="absolute right-0 h-3.5 w-3.5 rounded-full border-2 border-white bg-success dark:border-navy-700"></span>
              </button>

              <!-- <div :class="isShowPopper && 'show'" class="popper-root fixed" x-ref="popperRoot">
                <div class="popper-box w-64 rounded-lg border border-slate-150 bg-white shadow-soft dark:border-navy-600 dark:bg-navy-700">
                  <div class="flex items-center space-x-4 rounded-t-lg bg-slate-100 py-5 px-4 dark:bg-navy-800">
                    <div class="avatar h-14 w-14">
                      <img class="rounded-full" src="../images/logos/iPMS.svg" alt="avatar">
                    </div>
                    <div>
                      <a href="#" class="text-base font-medium text-slate-700 hover:text-primary focus:text-primary dark:text-navy-100 dark:hover:text-accent-light dark:focus:text-accent-light">
                       

                      </a>
                      <p class="text-xs text-slate-400 dark:text-navy-300">
                        

                      </p>
                    </div>
                  </div>
                  <div class="flex flex-col pt-2 pb-5">
                    <div class="mt-3 px-4">
                      <a onclick="confirmDelete()">
                        <button class="btn h-9 w-full space-x-2" style="background-color: red; color: white;" class="hover:bg-red-focus focus:bg-red-focus active:bg-red-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewbox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                          </svg>
                          <span>Clear</span>
                        </button>
                      </a>

                    </div>
                  </div>
                </div>
              </div> -->
            </div>


          </div>

        </div>
      </div>
    </nav>
    <!-- Main Content Wrapper -->
    <main @click="$store.global.isSidebarExpanded = false" class="main-content w-full px-[var(--margin-x)] pb-8">

      <div class="items-center justify-between py-5 lg:py-6">
        <div class=container>
          <div class="column">
            <h2>In-Gate</h2>
            <div class="data" id="data_in"></div>

          </div>
          <div class="column">
            <h2>Out-Gate</h2>
            <div class="data" id="data_out">
            </div>
          </div>

        </div>
        <div class=" manual-button">
          <!-- Button that appears on hover -->
          <a href="../manual/index.php" target="_blank"><button class="hover-button">Manual Mode Test</button></a>
        </div>
      </div>


      <div class="payment-option">
        <div class="button-container">
          <P class="p-pay-title">You can pay cash or online</P>
          <?php
          // Online Payment link
          echo '<a href="update.php?meth=online&vnum=' . urlencode($vehicle) . '" class="button' . ($vehicle === "No" ? ' disabled' : '') . '">Online Payment</a>';

          // Payment Done link
          echo '<a href="update.php?meth=done&vnum=' . urlencode($vehicle) . '" class="button' . ($vehicle === "No" ? ' disabled' : '') . '">Payment Done</a>';
          ?>
        </div>
      </div>




  </div>

  </main>
  <footer>
    <!-- <div class="footer-content"> -->
    <div class="footer  dark:bg-navy-900">
      <img src="../images/logos/TheEmbryo.png" alt="avatar">

    </div>
  </footer>
  </div>
  <div id="x-teleport-target"></div>
  <script>
    window.addEventListener("DOMContentLoaded", () => Alpine.start());
  </script>
  <script src="https://unpkg.com/gridjs/dist/gridjs.umd.js"></script>


  <script src="https://unpkg.com/gridjs/dist/gridjs.umd.js"></script>


</body>




</html>