<?php
include 'sesion_start.php';
include 'req.php';


$client = $_SESSION['client'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Connect to the iPMS-clients database
  $dbname = 'iPMS-clients';
  $link = mysqli_connect('localhost', 'root', '', $dbname);

  $selectedOption = $_POST['disable'];
  $mode = ($selectedOption === 'enable') ? 't' : 'f';

  // Sanitize mode value    
  $mode = mysqli_real_escape_string($link, $mode);

  if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
  }

  // Update the 'mode' column in the 'clients' table
  $sql = "UPDATE clients SET mode = '$mode' WHERE name = '$client'";

  if (mysqli_query($link, $sql)) {
    $_SESSION['edit'] = 'success';
  } else {
    $_SESSION['edit'] = 'error';
  }

  // Close the database connection
  mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!--    Sweet Alert -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

  <!-- Meta tags  -->
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

  <title>Park'N Pay - Dashboard</title>
  <link rel="icon" type="image/png" href="images/iPMS.svg">

  <!-- CSS Assets -->
  <link rel="stylesheet" href="css/app.css">

  <!-- Javascript Assets -->
  <script src="js/app.js" defer=""></script>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
  <link href="css2?family=Inter:wght@400;500;600;700&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
  <script>
    /**
     * THIS SCRIPT REQUIRED FOR PREVENT FLICKERING IN SOME BROWSERS
     */
    localStorage.getItem("_x_darkMode_on") === "true" &&
      document.documentElement.classList.add("dark");
  </script>
  <link href="assets/styles.css" rel="stylesheet" />

  <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->

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
  <style>
    body {
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      margin: 5;
      background-color: #f5f5f5;
    }

    .form-container {
      max-width: 400px;
      width: 100%;
      padding: 20px;
      border: 1px solid #ddd;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      background-color: #fff;
    }

    .form-container h2 {
      text-align: center;
      margin-bottom: 20px;
      font-weight: bold;
      font-size: 20px;
    }

    .form-container .form-group {
      margin-bottom: 20px;
    }

    .form-container .form-group label {
      font-weight: bold;
      display: block;
    }

    .form-container .form-control {
      width: 100%;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 3px;
    }

    .form-container .btn {
      width: 100%;
      padding: 10px;
      background-color: #007bff;
      color: #fff;
      border: none;
      border-radius: 3px;
      cursor: pointer;
    }

    .form-container .btn:hover {
      background-color: #0056b3;
    }
  </style>

</head>

<body x-data="" class="is-header-blur" x-bind="$store.global.documentBody">
  <!-- App preloader-->
  <div class="app-preloader fixed z-50 grid h-full w-full place-content-center bg-slate-50 dark:bg-navy-900">
    <div class="app-preloader-inner relative inline-block h-48 w-48"></div>
  </div>

  <!-- Page Wrapper -->
  <div id="root" class="min-h-100vh flex grow bg-slate-50 dark:bg-navy-900" x-cloak="">
    <!-- Sidebar -->
    <div class="sidebar print:hidden">
      <!-- Main Sidebar -->
      <div class="main-sidebar">
        <div class="flex h-full w-full flex-col items-center border-r border-slate-150 bg-white dark:border-navy-700 dark:bg-navy-800">
          <!-- Application Logo -->
          <div class="flex pt-4">
            <a href="index.php">
              <img class="h-16 w-16 transition-transform duration-500 ease-in-out hover:rotate-[360deg]" src="images/logos/iPMS.svg" alt="iPMS">
            </a>
          </div>

          <!-- Main Sections Links -->
          <div class="is-scrollbar-hidden flex grow flex-col space-y-4 overflow-y-auto pt-6">
            <!-- Dashobards -->
            <a href="index.php" class="flex h-11 w-11 items-center justify-center rounded-lg outline-none transition-colors duration-200 hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25" x-tooltip.placement.right="'Dashboards'">
              <svg class="h-7 w-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewbox="0 0 24 24">
                <path fill="#64748b" fill-opacity=".3" d="M5 14.059c0-1.01 0-1.514.222-1.945.221-.43.632-.724 1.453-1.31l4.163-2.974c.56-.4.842-.601 1.162-.601.32 0 .601.2 1.162.601l4.163 2.974c.821.586 1.232.88 1.453 1.31.222.43.222.935.222 1.945V19c0 .943 0 1.414-.293 1.707C18.414 21 17.943 21 17 21H7c-.943 0-1.414 0-1.707-.293C5 20.414 5 19.943 5 19v-4.94Z"></path>
                <path fill="#64748b" d="M3 12.387c0 .267 0 .4.084.441.084.041.19-.04.4-.204l7.288-5.669c.59-.459.885-.688 1.228-.688.343 0 .638.23 1.228.688l7.288 5.669c.21.163.316.245.4.204.084-.04.084-.174.084-.441v-.409c0-.48 0-.72-.102-.928-.101-.208-.291-.355-.67-.65l-7-5.445c-.59-.459-.885-.688-1.228-.688-.343 0-.638.23-1.228.688l-7 5.445c-.379.295-.569.442-.67.65-.102.208-.102.448-.102.928v.409Z"></path>
                <path fill="#64748b" d="M11.5 15.5h1A1.5 1.5 0 0 1 14 17v3.5h-4V17a1.5 1.5 0 0 1 1.5-1.5Z"></path>
                <path fill="#64748b" d="M17.5 5h-1a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5Z"></path>
              </svg>
            </a>

            <!-- Parking Spots -->
            <a href="parking_spots.php" class="flex h-11 w-11 items-center justify-center rounded-lg outline-none transition-colors duration-200 hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25" x-tooltip.placement.right="'Parking Spots'">
              <svg class="h-7 w-7" xmlns="http://www.w3.org/2000/svg" viewbox="0 0 24 24">
                <path fill="#64748b" d="M20 9.5v-2h-2.5L15 4H9L7.5 7.5H5v2h1v7a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-7h1zM9.5 7.5h5L16 9H8l1.5-1.5zM13 17a1 1 0 1 1-2 0 1 1 0 0 1 2 0zM8 16v-5h8v5H8z"></path>
              </svg>
            </a>

            <!-- Parking Map -->
            <a href="parking_map/" class="flex h-11 w-11 items-center justify-center rounded-lg outline-none transition-colors duration-200 hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25" x-tooltip.placement.right="'Parking Map'">
              <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="50" zoomAndPan="magnify" viewBox="0 0 37.5 37.499999" height="50" preserveAspectRatio="xMidYMid meet" version="1.0">
                <defs>
                  <clipPath id="22530e8c6e">
                    <path d="M 10.097656 6.914062 L 27.347656 6.914062 L 27.347656 30.914062 L 10.097656 30.914062 Z M 10.097656 6.914062 " clip-rule="nonzero" />
                  </clipPath>
                </defs>
                <g clip-path="url(#22530e8c6e)">
                  <path fill="#64748b" d="M 18.710938 6.914062 C 13.972656 6.914062 10.132812 10.960938 10.132812 15.957031 C 10.132812 20.953125 13.25 21.3125 18.710938 30.914062 C 24.160156 21.3125 27.292969 20.953125 27.292969 15.957031 C 27.292969 10.960938 23.449219 6.914062 18.710938 6.914062 Z M 18.710938 19.375 C 18.273438 19.367188 17.855469 19.273438 17.453125 19.09375 C 17.050781 18.917969 16.699219 18.667969 16.394531 18.347656 C 16.09375 18.027344 15.859375 17.660156 15.699219 17.246094 C 15.539062 16.832031 15.464844 16.402344 15.472656 15.957031 C 15.464844 15.511719 15.539062 15.082031 15.699219 14.667969 C 15.859375 14.253906 16.09375 13.886719 16.398438 13.566406 C 16.699219 13.25 17.054688 13 17.453125 12.820312 C 17.855469 12.644531 18.273438 12.550781 18.710938 12.542969 C 19.148438 12.550781 19.570312 12.644531 19.96875 12.820312 C 20.371094 13 20.722656 13.25 21.027344 13.566406 C 21.332031 13.886719 21.5625 14.253906 21.722656 14.667969 C 21.882812 15.082031 21.960938 15.511719 21.953125 15.957031 C 21.960938 16.402344 21.882812 16.832031 21.722656 17.246094 C 21.5625 17.660156 21.332031 18.027344 21.027344 18.347656 C 20.722656 18.667969 20.371094 18.917969 19.96875 19.09375 C 19.570312 19.273438 19.148438 19.367188 18.710938 19.375 Z M 18.710938 19.375 " fill-opacity="1" fill-rule="nonzero" />
                </g>
              </svg>
            </a>


            <!-- Add new Accounts -->
            <a href="addnew.php" class="flex h-11 w-11 items-center justify-center rounded-lg outline-none transition-colors duration-200 hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25" x-tooltip.placement.right="'Add New'">
              <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#64748b">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
              </svg>
            </a>

            <!-- Vehicle Gallery --><!--
              <a <?php if ($_SESSION['role'] != 'sadmin') {
                    echo 'style="display: none;"';
                  } ?> href="gallery.php" class="flex h-11 w-11 items-center justify-center rounded-lg outline-none transition-colors duration-200 hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25" x-tooltip.placement.right="'Vehicle Gallery'">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5h14v14H5V5z" />
                  <path d="M8 3h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2zm4 10l3-3m0 0l-3-3m3 3h-6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                </svg>
              </a>-->

            <?php
            if ($_SESSION['isEnable'] === 'enable') {
            ?>

              <a <?php if ($_SESSION['role'] != 'sadmin') {
                    echo 'style="display: none;"';
                  } ?> href="fee.php" class="flex h-11 w-11 items-center justify-center rounded-lg outline-none transition-colors duration-200 hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25" x-tooltip.placement.right="'Fee Viewer'">
                <svg class="h-7 w-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <path fill="currentColor" d="M12 1.5C6.21 1.5 1.5 6.21 1.5 12c0 5.79 4.71 10.5 10.5 10.5 5.79 0 10.5-4.71 10.5-10.5 0-5.79-4.71-10.5-10.5-10.5zM12 19.5c-4.14 0-7.5-3.36-7.5-7.5s3.36-7.5 7.5-7.5 7.5 3.36 7.5 7.5-3.36 7.5-7.5 7.5z"></path>
                  <path fill="currentColor" d="M13.5 10.5c0-.828-.672-1.5-1.5-1.5H9v-1.5h1.5c1.38 0 2.5 1.12 2.5 2.5v1.5h-.5zM9 15v-1.5h2c.828 0 1.5-.672 1.5-1.5 0-.828-.672-1.5-1.5-1.5H9V9h1.5c1.38 0 2.5 1.12 2.5 2.5s-1.12 2.5-2.5 2.5H9z"></path>
                </svg>
              </a>

            <?php
            }
            ?>

            <!-- Vehicles -->
            <a href="vehicle.php" class="flex h-11 w-11 items-center justify-center rounded-lg outline-none transition-colors duration-200 hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25" x-tooltip.placement.right="'Vehicles'">
              <svg class="h-7 w-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <path fill="#64748b" d="M2.5 9.5V6.05A1.55 1.55 0 0 1 4.05 4.5h8.9a1.55 1.55 0 0 1 1.55 1.55V9.5H2.5Z"></path>
                <path fill="#64748b" d="M2.5 14.5v3.45a1.55 1.55 0 0 0 1.55 1.55h8.9a1.55 1.55 0 0 0 1.55-1.55V14.5H2.5Z"></path>
                <path fill="#64748b" d="M4.05 4.5h8.9a1.55 1.55 0 0 1 1.55 1.55v9.45a1.55 1.55 0 0 1-1.55 1.55h-8.9a1.55 1.55 0 0 1-1.55-1.55V6.05A1.55 1.55 0 0 1 4.05 4.5Z"></path>
                <path fill="#64748b" d="M15.5 9.5v5h2.5V9.5h-2.5Z"></path>
                <path fill="#64748b" d="M6.5 9.5V7.75h2.5V9.5H6.5Z"></path>
                <path fill="#64748b" d="M13 7.75h2.5V9.5H13V7.75Z"></path>
                <path fill="#64748b" d="M13 12.75h2.5V14.5H13v-1.75Z"></path>
              </svg>

            </a>

            <!-- Server Status -->
            <a href="server.php" class="flex h-11 w-11 items-center justify-center rounded-lg outline-none transition-colors duration-200 hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25" x-tooltip.placement.right="'Server Status'">
              <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="50" zoomAndPan="magnify" viewBox="0 0 37.5 37.499999" height="50" preserveAspectRatio="xMidYMid meet" version="1.0">
                <defs>
                  <clipPath id="aa34806414">
                    <path d="M 5.878906 3.875 L 31.378906 3.875 L 31.378906 12 L 5.878906 12 Z M 5.878906 3.875 " clip-rule="nonzero" />
                  </clipPath>
                  <clipPath id="294d1371db">
                    <path d="M 15 3.875 L 31.378906 3.875 L 31.378906 16 L 15 16 Z M 15 3.875 " clip-rule="nonzero" />
                  </clipPath>
                  <clipPath id="d2f4669894">
                    <path d="M 17 3.875 L 31.378906 3.875 L 31.378906 16 L 17 16 Z M 17 3.875 " clip-rule="nonzero" />
                  </clipPath>
                  <clipPath id="d91879e462">
                    <path d="M 20 3.875 L 31.378906 3.875 L 31.378906 16 L 20 16 Z M 20 3.875 " clip-rule="nonzero" />
                  </clipPath>
                  <clipPath id="6e6c92010b">
                    <path d="M 5.878906 12 L 31.378906 12 L 31.378906 20 L 5.878906 20 Z M 5.878906 12 " clip-rule="nonzero" />
                  </clipPath>
                  <clipPath id="55fc91f3cc">
                    <path d="M 15 8 L 31.378906 8 L 31.378906 25 L 15 25 Z M 15 8 " clip-rule="nonzero" />
                  </clipPath>
                  <clipPath id="a07d158a93">
                    <path d="M 17 8 L 31.378906 8 L 31.378906 25 L 17 25 Z M 17 8 " clip-rule="nonzero" />
                  </clipPath>
                  <clipPath id="5261b93a12">
                    <path d="M 20 8 L 31.378906 8 L 31.378906 25 L 20 25 Z M 20 8 " clip-rule="nonzero" />
                  </clipPath>
                  <clipPath id="1121e46075">
                    <path d="M 5.878906 21 L 31.378906 21 L 31.378906 29 L 5.878906 29 Z M 5.878906 21 " clip-rule="nonzero" />
                  </clipPath>
                  <clipPath id="506439da94">
                    <path d="M 15 17 L 31.378906 17 L 31.378906 33.875 L 15 33.875 Z M 15 17 " clip-rule="nonzero" />
                  </clipPath>
                  <clipPath id="0f2cbe7ec3">
                    <path d="M 17 17 L 31.378906 17 L 31.378906 33.875 L 17 33.875 Z M 17 17 " clip-rule="nonzero" />
                  </clipPath>
                  <clipPath id="b8cf7bebfe">
                    <path d="M 20 17 L 31.378906 17 L 31.378906 33.875 L 20 33.875 Z M 20 17 " clip-rule="nonzero" />
                  </clipPath>
                  <clipPath id="4b3d0ddad2">
                    <path d="M 9 33 L 18 33 L 18 33.875 L 9 33.875 Z M 9 33 " clip-rule="nonzero" />
                  </clipPath>
                  <clipPath id="5b56525f76">
                    <path d="M 20 33 L 29 33 L 29 33.875 L 20 33.875 Z M 20 33 " clip-rule="nonzero" />
                  </clipPath>
                  <clipPath id="34e12966fd">
                    <path d="M 16 31 L 21 31 L 21 33.875 L 16 33.875 Z M 16 31 " clip-rule="nonzero" />
                  </clipPath>
                </defs>
                <g clip-path="url(#aa34806414)">
                  <path fill="#274169" d="M 31.3125 10.8125 C 31.3125 10.957031 31.195312 11.074219 31.050781 11.074219 L 6.191406 11.074219 C 6.042969 11.074219 5.925781 10.957031 5.925781 10.8125 L 5.925781 4.136719 C 5.925781 3.992188 6.042969 3.875 6.191406 3.875 L 31.050781 3.875 C 31.195312 3.875 31.3125 3.992188 31.3125 4.136719 L 31.3125 10.8125 " fill-opacity="1" fill-rule="nonzero" />
                </g>
                <path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 1441.316378 2954.802865 L 1441.316378 2805.227869 " stroke="#ffffff" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10" />
                <path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 1530.988335 2954.802865 L 1530.988335 2805.227869 " stroke="#ffffff" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10" />
                <path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 1620.660292 2954.802865 L 1620.660292 2805.227869 " stroke="#ffffff" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10" />
                <g clip-path="url(#294d1371db)">
                  <path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 2481.879234 2870.069534 C 2481.879234 2848.627868 2464.523371 2831.061201 2442.960026 2831.061201 C 2421.396682 2831.061201 2404.040819 2848.627868 2404.040819 2870.069534 C 2404.040819 2891.5112 2421.396682 2908.819533 2442.960026 2908.819533 C 2464.523371 2908.819533 2481.879234 2891.5112 2481.879234 2870.069534 Z M 2481.879234 2870.069534 " stroke="#d7282f" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10" />
                </g>
                <g clip-path="url(#d2f4669894)">
                  <path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 2647.811799 2870.069534 C 2647.811799 2848.627868 2630.192969 2831.061201 2608.892592 2831.061201 C 2587.329247 2831.061201 2569.973385 2848.627868 2569.973385 2870.069534 C 2569.973385 2891.5112 2587.329247 2908.819533 2608.892592 2908.819533 C 2630.192969 2908.819533 2647.811799 2891.5112 2647.811799 2870.069534 Z M 2647.811799 2870.069534 " stroke="#7fcb27" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10" />
                </g>
                <g clip-path="url(#d91879e462)">
                  <path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 2810.851721 2870.069534 C 2810.851721 2848.627868 2793.495858 2831.061201 2771.932514 2831.061201 C 2750.369169 2831.061201 2733.013307 2848.627868 2733.013307 2870.069534 C 2733.013307 2891.5112 2750.369169 2908.819533 2771.932514 2908.819533 C 2793.495858 2908.819533 2810.851721 2891.5112 2810.851721 2870.069534 Z M 2810.851721 2870.069534 " stroke="#3abdc4" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10" />
                </g>
                <path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 1782.122408 2921.477866 L 2284.390554 2921.477866 " stroke="#3abdc4" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10" />
                <path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 1782.122408 2818.661202 L 2284.390554 2818.661202 " stroke="#3abdc4" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10" />
                <g clip-path="url(#6e6c92010b)">
                  <path fill="#274169" d="M 31.3125 19.425781 C 31.3125 19.570312 31.195312 19.6875 31.050781 19.6875 L 6.191406 19.6875 C 6.042969 19.6875 5.925781 19.570312 5.925781 19.425781 L 5.925781 12.75 C 5.925781 12.605469 6.042969 12.488281 6.191406 12.488281 L 31.050781 12.488281 C 31.195312 12.488281 31.3125 12.605469 31.3125 12.75 L 31.3125 19.425781 " fill-opacity="1" fill-rule="nonzero" />
                </g>
                <path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 1441.316378 2385.177879 L 1441.316378 2235.602883 " stroke="#ffffff" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10" />
                <path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 1530.988335 2385.177879 L 1530.988335 2235.602883 " stroke="#ffffff" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10" />
                <path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 1620.660292 2385.177879 L 1620.660292 2235.602883 " stroke="#ffffff" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10" />
                <g clip-path="url(#55fc91f3cc)">
                  <path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 2481.879234 2300.444548 C 2481.879234 2279.002882 2464.523371 2261.436216 2442.960026 2261.436216 C 2421.396682 2261.436216 2404.040819 2279.002882 2404.040819 2300.444548 C 2404.040819 2321.886214 2421.396682 2339.194547 2442.960026 2339.194547 C 2464.523371 2339.194547 2481.879234 2321.886214 2481.879234 2300.444548 Z M 2481.879234 2300.444548 " stroke="#d7282f" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10" />
                </g>
                <g clip-path="url(#a07d158a93)">
                  <path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 2647.811799 2300.444548 C 2647.811799 2279.002882 2630.192969 2261.436216 2608.892592 2261.436216 C 2587.329247 2261.436216 2569.973385 2279.002882 2569.973385 2300.444548 C 2569.973385 2321.886214 2587.329247 2339.194547 2608.892592 2339.194547 C 2630.192969 2339.194547 2647.811799 2321.886214 2647.811799 2300.444548 Z M 2647.811799 2300.444548 " stroke="#7fcb27" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10" />
                </g>
                <g clip-path="url(#5261b93a12)">
                  <path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 2810.851721 2300.444548 C 2810.851721 2279.002882 2793.495858 2261.436216 2771.932514 2261.436216 C 2750.369169 2261.436216 2733.013307 2279.002882 2733.013307 2300.444548 C 2733.013307 2321.886214 2750.369169 2339.194547 2771.932514 2339.194547 C 2793.495858 2339.194547 2810.851721 2321.886214 2810.851721 2300.444548 Z M 2810.851721 2300.444548 " stroke="#3abdc4" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10" />
                </g>
                <path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 1782.122408 2351.594547 L 2284.390554 2351.594547 " stroke="#3abdc4" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10" />
                <path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 1782.122408 2249.036216 L 2284.390554 2249.036216 " stroke="#3abdc4" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10" />
                <g clip-path="url(#1121e46075)">
                  <path fill="#274169" d="M 31.3125 28.511719 C 31.3125 28.65625 31.195312 28.777344 31.050781 28.777344 L 6.191406 28.777344 C 6.042969 28.777344 5.925781 28.65625 5.925781 28.511719 L 5.925781 21.839844 C 5.925781 21.691406 6.042969 21.578125 6.191406 21.578125 L 31.050781 21.578125 C 31.195312 21.578125 31.3125 21.691406 31.3125 21.839844 L 31.3125 28.511719 " fill-opacity="1" fill-rule="nonzero" />
                </g>
                <path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 1441.316378 1784.036228 L 1441.316378 1634.719565 " stroke="#ffffff" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10" />
                <path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 1530.988335 1784.036228 L 1530.988335 1634.719565 " stroke="#ffffff" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10" />
                <path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 1620.660292 1784.036228 L 1620.660292 1634.719565 " stroke="#ffffff" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10" />
                <g clip-path="url(#506439da94)">
                  <path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 2481.879234 1699.302897 C 2481.879234 1677.861231 2464.523371 1660.294564 2442.960026 1660.294564 C 2421.396682 1660.294564 2404.040819 1677.861231 2404.040819 1699.302897 C 2404.040819 1720.744563 2421.396682 1738.311229 2442.960026 1738.311229 C 2464.523371 1738.311229 2481.879234 1720.744563 2481.879234 1699.302897 Z M 2481.879234 1699.302897 " stroke="#d7282f" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10" />
                </g>
                <g clip-path="url(#0f2cbe7ec3)">
                  <path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 2647.811799 1699.302897 C 2647.811799 1677.861231 2630.192969 1660.294564 2608.892592 1660.294564 C 2587.329247 1660.294564 2569.973385 1677.861231 2569.973385 1699.302897 C 2569.973385 1720.744563 2587.329247 1738.311229 2608.892592 1738.311229 C 2630.192969 1738.311229 2647.811799 1720.744563 2647.811799 1699.302897 Z M 2647.811799 1699.302897 " stroke="#7fcb27" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10" />
                </g>
                <g clip-path="url(#b8cf7bebfe)">
                  <path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 2810.851721 1699.302897 C 2810.851721 1677.861231 2793.495858 1660.294564 2771.932514 1660.294564 C 2750.369169 1660.294564 2733.013307 1677.861231 2733.013307 1699.302897 C 2733.013307 1720.744563 2750.369169 1738.311229 2771.932514 1738.311229 C 2793.495858 1738.311229 2810.851721 1720.744563 2810.851721 1699.302897 Z M 2810.851721 1699.302897 " stroke="#3abdc4" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10" />
                </g>
                <path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 1782.122408 1750.711229 L 2284.390554 1750.711229 " stroke="#3abdc4" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10" />
                <path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 1782.122408 1647.894565 L 2284.390554 1647.894565 " stroke="#3abdc4" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10" />
                <path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 2126.08405 1471.194569 L 2126.08405 1262.977908 " stroke="#274169" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10" />
                <g clip-path="url(#4b3d0ddad2)">
                  <path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 2016.952489 1159.12791 L 1519.41776 1159.12791 " stroke="#274169" stroke-width="44.157001" stroke-opacity="1" stroke-miterlimit="10" />
                </g>
                <g clip-path="url(#5b56525f76)">
                  <path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 2755.628521 1159.12791 L 2257.830825 1159.12791 " stroke="#274169" stroke-width="44.157001" stroke-opacity="1" stroke-miterlimit="10" />
                </g>
                <g clip-path="url(#34e12966fd)">
                  <path fill="#3abdc4" d="M 20.578125 33.878906 L 16.660156 33.878906 L 16.660156 31.925781 L 20.578125 31.925781 L 20.578125 33.878906 " fill-opacity="1" fill-rule="nonzero" />
                </g>
              </svg>
            </a>

            <!-- manual entry -->
            <a <?php if ($_SESSION['role'] != 'sadmin') {
                  echo 'style="display: none;"';
                } ?>href="manual_entry.php" class="flex h-11 w-11 items-center justify-center rounded-lg outline-none transition-colors duration-200 hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25" x-tooltip.placement.right="'Manual Entry'">
              <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 384 512" fill="none">
                <style>
                  svg {
                    fill: #fbbf24
                  }
                </style>
                <path fill="currentColor" d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V160H256c-17.7 0-32-14.3-32-32V0H64zM256 0V128H384L256 0zM80 64h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H80c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H80c-8.8 0-16-7.2-16-16s7.2-16 16-16zm16 96H288c17.7 0 32 14.3 32 32v64c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V256c0-17.7 14.3-32 32-32zm0 32v64H288V256H96zM240 416h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H240c-8.8 0-16-7.2-16-16s7.2-16 16-16z" />
              </svg>
            </a>

            <!-- payment option -->
            <a <?php if ($_SESSION['role'] != 'sadmin') {
                  echo 'style="display: none;"';
                } ?>href="payment_option.php" class="flex h-11 w-11 items-center justify-center rounded-lg bg-primary/10 text-primary outline-none transition-colors duration-200 hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:bg-navy-600 dark:text-accent-light dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90" x-tooltip.placement.right="'Payment Option'">
              <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512" Stroke="currentColor">
                <style>
                  svg {
                    fill: currentColor
                  }
                </style>
                <path d="M512 80c8.8 0 16 7.2 16 16v32H48V96c0-8.8 7.2-16 16-16H512zm16 144V416c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V224H528zM64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm56 304c-13.3 0-24 10.7-24 24s10.7 24 24 24h48c13.3 0 24-10.7 24-24s-10.7-24-24-24H120zm128 0c-13.3 0-24 10.7-24 24s10.7 24 24 24H360c13.3 0 24-10.7 24-24s-10.7-24-24-24H248z" />
              </svg>
            </a>

          </div>

          <!-- Bottom Links -->
          <div class="flex flex-col items-center space-y-3 py-3">
            <!-- Profile -->
            <div x-data="usePopper({placement:'right-end',offset:12})" @click.outside="isShowPopper && (isShowPopper = false)" class="flex">
              <button @click="isShowPopper = !isShowPopper" x-ref="popperRef" class="avatar h-12 w-12">
                <img class="rounded-full" src="images/logos/iPMS.svg" alt="avatar">
                <span class="absolute right-0 h-3.5 w-3.5 rounded-full border-2 border-white bg-success dark:border-navy-700"></span>
              </button>

              <div :class="isShowPopper && 'show'" class="popper-root fixed" x-ref="popperRoot">
                <div class="popper-box w-64 rounded-lg border border-slate-150 bg-white shadow-soft dark:border-navy-600 dark:bg-navy-700">
                  <div class="flex items-center space-x-4 rounded-t-lg bg-slate-100 py-5 px-4 dark:bg-navy-800">
                    <div class="avatar h-14 w-14">
                      <img class="rounded-full" src="images/logos/iPMS.svg" alt="avatar">
                    </div>
                    <div>
                      <a href="#" class="text-base font-medium text-slate-700 hover:text-primary focus:text-primary dark:text-navy-100 dark:hover:text-accent-light dark:focus:text-accent-light">
                        <!--                          Account Type -->
                        <?php echo $_SESSION['role']; ?>
                      </a>
                      <p class="text-xs text-slate-400 dark:text-navy-300">
                        <!--                          Company Name -->
                        <?php echo $_SESSION['client']; ?>
                      </p>
                    </div>
                  </div>
                  <div class="flex flex-col pt-2 pb-5">
                    <div class="mt-3 px-4">
                      <a href="logout.php"> <a href="logout.php"> <button class="btn h-9 w-full space-x-2 bg-primary text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewbox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            <span>Logout</span>
                          </button></a></a>
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
                <path d="M11.75 3.412a.818.818 0 01-.07.917 6.332 6.332 0 00-1.4 3.971c0 3.564 2.98 6.494 6.706 6.494a6.86 6.86 0 002.856-.617.818.818 0 011.1 1.047C19.593 18.614 16.218 21 12.283 21 7.18 21 3 16.973 3 11.956c0-4.563 3.46-8.31 7.925-8.948a.818.818 0 01.826.404z"></path>
              </svg>
              <svg xmlns="http://www.w3.org/2000/svg" x-show="!$store.global.isDarkModeEnabled" x-transition:enter="transition-transform duration-200 ease-out absolute origin-top" x-transition:enter-start="scale-75" x-transition:enter-end="scale-100 static" class="h-6 w-6 text-amber-400" viewbox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"></path>
              </svg>
            </button>
            <button @click="isShowPopper = !isShowPopper" x-ref="popperRef" class="avatar h-12 w-12">
              <img class="rounded-full" src="images/logos/iPMS.svg" alt="avatar">
              <span class="absolute right-0 h-3.5 w-3.5 rounded-full border-2 border-white bg-success dark:border-navy-700"></span>
            </button>
          </div>

        </div>
      </div>
    </nav>
    <!-- Main Content Wrapper -->
    <main @click="$store.global.isSidebarExpanded = false" class="main-content w-full px-[var(--margin-x)] pb-8">

      <diV style="display: flex; justify-content: center; align-items: center; height: 100vh;">

        <div class="form-container">
          <h2>Payment Section</h2>
          <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-group">
              <label for="disable">Select Payment Option</label>
              <select class="form-control" id="disable" name="disable" onchange="checkPaymentOption()">
                <option>--- Select Payment Option ---</option>
                <option value="enable" <?php echo (isset($_POST['disable']) && $_POST['disable'] == 'enable') ? 'selected' : ''; ?>>Enable</option>
                <option value="disable" <?php echo (isset($_POST['disable']) && $_POST['disable'] == 'disable') ? 'selected' : ''; ?>>Disable</option>
              </select>
            </div>
            <button type="submit" class="btn btn-primary btn-block" id="submitBtn" disabled>Submit</button>
            <div id="error-message" style="color: red;"></div>
          </form>
        </div>

        <div id="x-teleport-target"></div>
        <script>
          window.addEventListener("DOMContentLoaded", () => {
            Alpine.start();
            checkPaymentOption();
            // validateForm() // To set the initial state of the submit button
          });

          function checkPaymentOption() {
            var disableSelect = document.getElementById("disable");
            var submitBtn = document.getElementById("submitBtn");
            var errorMessage = document.getElementById("error-message");

            if (disableSelect.value === 'enable' || disableSelect.value === 'disable') {
              submitBtn.disabled = false;
              localStorage.setItem('selectedOption', disableSelect.value);
              errorMessage.innerText = '';
            } else {
              submitBtn.disabled = true;
              errorMessage.innerText = '';
            }
          }

          function validateForm() {
            var disableSelect = document.getElementById("disable");
            var errorMessage = document.getElementById("error-message");

            if (disableSelect.value === 'enable' || disableSelect.value === 'disable') {
              errorMessage.innerText = '';
              localStorage.setItem('selectedOption', disableSelect.value); // Store selected option in local storage
              return true;
            } else {
              errorMessage.innerText = 'Please select a payment option';
              return false;
            }
          }

          // Restore selected option from local storage on page load
          var storedOption = localStorage.getItem('selectedOption');
          if (storedOption) {
            document.getElementById('disable').value = storedOption;
          }
        </script>
</body>

</html>

<?php
if (isset($_SESSION['edit'])) {
  if ($_SESSION['edit'] == 'success') {
    $message = ($_POST['disable'] == 'enable') ? 'enable success.' : 'disable success.';
    echo '<script>swal("Success", "' . $message . '", "success");</script>';
  }
  if ($_SESSION['edit'] == 'error') {
    echo '<script>swal("Error", "Something went wrong, please try again.", "error");</script>';
  }
  unset($_SESSION['edit']);
}
?>