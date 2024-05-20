<?php
include 'sesion_start.php';
include 'req.php';
include 'connStat.php';

// get stats data from database
$sql_get_database_data = "SELECT * FROM `totals`";
$sqlData = mysqli_query($link, $sql_get_database_data);
$data = mysqli_fetch_all($sqlData);

// get bar chart dataset
$sql = "SELECT `day`,`i`,`o` FROM statbyday";
$result = mysqli_query($link, $sql);

$vehicle_data = array();
$vehicle_data[] = ['Day', 'Vehicles In', 'Vehicles Out'];

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        $vehicle_data[] = [$row["day"], intval($row["i"]), intval($row["o"])];
    }
} else {
    echo "0 results";
}

$vehicle_json_data = json_encode($vehicle_data);

// get bar chart dataset
$sql1 = "SELECT `day`,`total_revenue` FROM `revenue`";
$result = mysqli_query($link, $sql1);

$vehicle_data1 = array();
$vehicle_data1[] = ['Day', 'Revenue'];

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        $vehicle_data1[] = [$row["day"], intval($row["total_revenue"])];
    }
} else {
    echo "0 results";
}

$vehicle_json_data1 = json_encode($vehicle_data1);


// top spots data
$sql1 = "SELECT * FROM spots ORDER BY revenue DESC LIMIT 3;";
$result1 = mysqli_query($link, $sql1);
$data1 = mysqli_fetch_all($result1);

$top1 = $data1[0][1];
$top1Revenue = $data1[0][0];
$top2 = $data1[1][1];
$top2Revenue = $data1[1][0];
$top3 = $data1[1][1];
$top3Revenue = $data1[1][0];




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

    <style>

      #chart {

      }
      .popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            opacity: 0;
            transition: opacity 0.3s;
        }

    </style>

    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->

    <style>
    /* Set the height and overflow for the table container */
    .table-container {
      max-height: 400px; /* Adjust the maximum height as needed */
      overflow-y: auto;
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
              <a href="index.php" class="flex h-11 w-11 items-center justify-center rounded-lg bg-primary/10 text-primary outline-none transition-colors duration-200 hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:bg-navy-600 dark:text-accent-light dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90" x-tooltip.placement.right="'Dashboards'">
                <svg class="h-7 w-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewbox="0 0 24 24">
                  <path fill="currentColor" fill-opacity=".3" d="M5 14.059c0-1.01 0-1.514.222-1.945.221-.43.632-.724 1.453-1.31l4.163-2.974c.56-.4.842-.601 1.162-.601.32 0 .601.2 1.162.601l4.163 2.974c.821.586 1.232.88 1.453 1.31.222.43.222.935.222 1.945V19c0 .943 0 1.414-.293 1.707C18.414 21 17.943 21 17 21H7c-.943 0-1.414 0-1.707-.293C5 20.414 5 19.943 5 19v-4.94Z"></path>
                  <path fill="currentColor" d="M3 12.387c0 .267 0 .4.084.441.084.041.19-.04.4-.204l7.288-5.669c.59-.459.885-.688 1.228-.688.343 0 .638.23 1.228.688l7.288 5.669c.21.163.316.245.4.204.084-.04.084-.174.084-.441v-.409c0-.48 0-.72-.102-.928-.101-.208-.291-.355-.67-.65l-7-5.445c-.59-.459-.885-.688-1.228-.688-.343 0-.638.23-1.228.688l-7 5.445c-.379.295-.569.442-.67.65-.102.208-.102.448-.102.928v.409Z"></path>
                  <path fill="currentColor" d="M11.5 15.5h1A1.5 1.5 0 0 1 14 17v3.5h-4V17a1.5 1.5 0 0 1 1.5-1.5Z"></path>
                  <path fill="currentColor" d="M17.5 5h-1a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5Z"></path>
                </svg>
              </a>

              <!-- Parking Spots -->
              <a href="parking_spots.php" class="flex h-11 w-11 items-center justify-center rounded-lg outline-none transition-colors duration-200 hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25" x-tooltip.placement.right="'Parking Spots'">
                <svg class="h-7 w-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewbox="0 0 24 24">
                  <path fill="currentColor" d="M20 9.5v-2h-2.5L15 4H9L7.5 7.5H5v2h1v7a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-7h1zM9.5 7.5h5L16 9H8l1.5-1.5zM13 17a1 1 0 1 1-2 0 1 1 0 0 1 2 0zM8 16v-5h8v5H8z"></path>
                </svg>
              </a>

              <!-- Parking Map -->
              <a href="parking_map/" class="flex h-11 w-11 items-center justify-center rounded-lg outline-none transition-colors duration-200 hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25" x-tooltip.placement.right="'Parking Map'">
              <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="50" zoomAndPan="magnify" viewBox="0 0 37.5 37.499999" height="50" preserveAspectRatio="xMidYMid meet" version="1.0">
                  <defs>
                    <clipPath id="22530e8c6e">
                      <path d="M 10.097656 6.914062 L 27.347656 6.914062 L 27.347656 30.914062 L 10.097656 30.914062 Z M 10.097656 6.914062 " clip-rule="nonzero"/>
                    </clipPath>
                  </defs><g clip-path="url(#22530e8c6e)">
                      <path fill="#64748b" d="M 18.710938 6.914062 C 13.972656 6.914062 10.132812 10.960938 10.132812 15.957031 C 10.132812 20.953125 13.25 21.3125 18.710938 30.914062 C 24.160156 21.3125 27.292969 20.953125 27.292969 15.957031 C 27.292969 10.960938 23.449219 6.914062 18.710938 6.914062 Z M 18.710938 19.375 C 18.273438 19.367188 17.855469 19.273438 17.453125 19.09375 C 17.050781 18.917969 16.699219 18.667969 16.394531 18.347656 C 16.09375 18.027344 15.859375 17.660156 15.699219 17.246094 C 15.539062 16.832031 15.464844 16.402344 15.472656 15.957031 C 15.464844 15.511719 15.539062 15.082031 15.699219 14.667969 C 15.859375 14.253906 16.09375 13.886719 16.398438 13.566406 C 16.699219 13.25 17.054688 13 17.453125 12.820312 C 17.855469 12.644531 18.273438 12.550781 18.710938 12.542969 C 19.148438 12.550781 19.570312 12.644531 19.96875 12.820312 C 20.371094 13 20.722656 13.25 21.027344 13.566406 C 21.332031 13.886719 21.5625 14.253906 21.722656 14.667969 C 21.882812 15.082031 21.960938 15.511719 21.953125 15.957031 C 21.960938 16.402344 21.882812 16.832031 21.722656 17.246094 C 21.5625 17.660156 21.332031 18.027344 21.027344 18.347656 C 20.722656 18.667969 20.371094 18.917969 19.96875 19.09375 C 19.570312 19.273438 19.148438 19.367188 18.710938 19.375 Z M 18.710938 19.375 " fill-opacity="1" fill-rule="nonzero"/>
                </g>
              </svg>
              </a>                 


              <!-- Add new Accounts -->
              <a href="addnew.php" class="flex h-11 w-11 items-center justify-center rounded-lg outline-none transition-colors duration-200 hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25" x-tooltip.placement.right="'Add New'">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
              </a>
              
              <!-- Vehicle Gallery -->
              <a <?php if($_SESSION['role'] != 'sadmin'){
                echo 'style="display: none;"';
              } ?> href="gallery.php" class="flex h-11 w-11 items-center justify-center rounded-lg outline-none transition-colors duration-200 hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25" x-tooltip.placement.right="'Vehicle Gallery'">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5h14v14H5V5z" />
                  <path d="M8 3h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2zm4 10l3-3m0 0l-3-3m3 3h-6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                </svg>

              </a>

              <!-- Fees -->
              <a <?php if($_SESSION['role'] != 'sadmin'){
                echo 'style="display: none;"';
              } ?> href="fee.php" class="flex h-11 w-11 items-center justify-center rounded-lg outline-none transition-colors duration-200 hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25" x-tooltip.placement.right="'Fee Viewer'">
                <svg class="h-7 w-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <path fill="currentColor" d="M12 1.5C6.21 1.5 1.5 6.21 1.5 12c0 5.79 4.71 10.5 10.5 10.5 5.79 0 10.5-4.71 10.5-10.5 0-5.79-4.71-10.5-10.5-10.5zM12 19.5c-4.14 0-7.5-3.36-7.5-7.5s3.36-7.5 7.5-7.5 7.5 3.36 7.5 7.5-3.36 7.5-7.5 7.5z"></path>
                  <path fill="currentColor" d="M13.5 10.5c0-.828-.672-1.5-1.5-1.5H9v-1.5h1.5c1.38 0 2.5 1.12 2.5 2.5v1.5h-.5zM9 15v-1.5h2c.828 0 1.5-.672 1.5-1.5 0-.828-.672-1.5-1.5-1.5H9V9h1.5c1.38 0 2.5 1.12 2.5 2.5s-1.12 2.5-2.5 2.5H9z"></path>
                </svg>
              </a>

              <!-- Vehicles -->
              <a href="vehicle.php" class="flex h-11 w-11 items-center justify-center rounded-lg outline-none transition-colors duration-200 hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25" x-tooltip.placement.right="'Vehicles'">
                <svg class="h-7 w-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <path fill="currentColor" d="M2.5 9.5V6.05A1.55 1.55 0 0 1 4.05 4.5h8.9a1.55 1.55 0 0 1 1.55 1.55V9.5H2.5Z"></path>
                  <path fill="currentColor" d="M2.5 14.5v3.45a1.55 1.55 0 0 0 1.55 1.55h8.9a1.55 1.55 0 0 0 1.55-1.55V14.5H2.5Z"></path>
                  <path fill="currentColor" d="M4.05 4.5h8.9a1.55 1.55 0 0 1 1.55 1.55v9.45a1.55 1.55 0 0 1-1.55 1.55h-8.9a1.55 1.55 0 0 1-1.55-1.55V6.05A1.55 1.55 0 0 1 4.05 4.5Z"></path>
                  <path fill="currentColor" d="M15.5 9.5v5h2.5V9.5h-2.5Z"></path>
                  <path fill="currentColor" d="M6.5 9.5V7.75h2.5V9.5H6.5Z"></path>
                  <path fill="currentColor" d="M13 7.75h2.5V9.5H13V7.75Z"></path>
                  <path fill="currentColor" d="M13 12.75h2.5V14.5H13v-1.75Z"></path>
                </svg>

              </a><!-- Server Status -->
              <a href="server.php" class="flex h-11 w-11 items-center justify-center rounded-lg outline-none transition-colors duration-200 hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25" x-tooltip.placement.right="'Server Status'">
              <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="50" zoomAndPan="magnify" viewBox="0 0 37.5 37.499999" height="50" preserveAspectRatio="xMidYMid meet" version="1.0"><defs><clipPath id="aa34806414"><path d="M 5.878906 3.875 L 31.378906 3.875 L 31.378906 12 L 5.878906 12 Z M 5.878906 3.875 " clip-rule="nonzero"/></clipPath><clipPath id="294d1371db"><path d="M 15 3.875 L 31.378906 3.875 L 31.378906 16 L 15 16 Z M 15 3.875 " clip-rule="nonzero"/></clipPath><clipPath id="d2f4669894"><path d="M 17 3.875 L 31.378906 3.875 L 31.378906 16 L 17 16 Z M 17 3.875 " clip-rule="nonzero"/></clipPath><clipPath id="d91879e462"><path d="M 20 3.875 L 31.378906 3.875 L 31.378906 16 L 20 16 Z M 20 3.875 " clip-rule="nonzero"/></clipPath><clipPath id="6e6c92010b"><path d="M 5.878906 12 L 31.378906 12 L 31.378906 20 L 5.878906 20 Z M 5.878906 12 " clip-rule="nonzero"/></clipPath><clipPath id="55fc91f3cc"><path d="M 15 8 L 31.378906 8 L 31.378906 25 L 15 25 Z M 15 8 " clip-rule="nonzero"/></clipPath><clipPath id="a07d158a93"><path d="M 17 8 L 31.378906 8 L 31.378906 25 L 17 25 Z M 17 8 " clip-rule="nonzero"/></clipPath><clipPath id="5261b93a12"><path d="M 20 8 L 31.378906 8 L 31.378906 25 L 20 25 Z M 20 8 " clip-rule="nonzero"/></clipPath><clipPath id="1121e46075"><path d="M 5.878906 21 L 31.378906 21 L 31.378906 29 L 5.878906 29 Z M 5.878906 21 " clip-rule="nonzero"/></clipPath><clipPath id="506439da94"><path d="M 15 17 L 31.378906 17 L 31.378906 33.875 L 15 33.875 Z M 15 17 " clip-rule="nonzero"/></clipPath><clipPath id="0f2cbe7ec3"><path d="M 17 17 L 31.378906 17 L 31.378906 33.875 L 17 33.875 Z M 17 17 " clip-rule="nonzero"/></clipPath><clipPath id="b8cf7bebfe"><path d="M 20 17 L 31.378906 17 L 31.378906 33.875 L 20 33.875 Z M 20 17 " clip-rule="nonzero"/></clipPath><clipPath id="4b3d0ddad2"><path d="M 9 33 L 18 33 L 18 33.875 L 9 33.875 Z M 9 33 " clip-rule="nonzero"/></clipPath><clipPath id="5b56525f76"><path d="M 20 33 L 29 33 L 29 33.875 L 20 33.875 Z M 20 33 " clip-rule="nonzero"/></clipPath><clipPath id="34e12966fd"><path d="M 16 31 L 21 31 L 21 33.875 L 16 33.875 Z M 16 31 " clip-rule="nonzero"/></clipPath></defs><g clip-path="url(#aa34806414)"><path fill="#274169" d="M 31.3125 10.8125 C 31.3125 10.957031 31.195312 11.074219 31.050781 11.074219 L 6.191406 11.074219 C 6.042969 11.074219 5.925781 10.957031 5.925781 10.8125 L 5.925781 4.136719 C 5.925781 3.992188 6.042969 3.875 6.191406 3.875 L 31.050781 3.875 C 31.195312 3.875 31.3125 3.992188 31.3125 4.136719 L 31.3125 10.8125 " fill-opacity="1" fill-rule="nonzero"/></g><path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 1441.316378 2954.802865 L 1441.316378 2805.227869 " stroke="#ffffff" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10"/><path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 1530.988335 2954.802865 L 1530.988335 2805.227869 " stroke="#ffffff" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10"/><path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 1620.660292 2954.802865 L 1620.660292 2805.227869 " stroke="#ffffff" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10"/><g clip-path="url(#294d1371db)"><path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 2481.879234 2870.069534 C 2481.879234 2848.627868 2464.523371 2831.061201 2442.960026 2831.061201 C 2421.396682 2831.061201 2404.040819 2848.627868 2404.040819 2870.069534 C 2404.040819 2891.5112 2421.396682 2908.819533 2442.960026 2908.819533 C 2464.523371 2908.819533 2481.879234 2891.5112 2481.879234 2870.069534 Z M 2481.879234 2870.069534 " stroke="#d7282f" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10"/></g><g clip-path="url(#d2f4669894)"><path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 2647.811799 2870.069534 C 2647.811799 2848.627868 2630.192969 2831.061201 2608.892592 2831.061201 C 2587.329247 2831.061201 2569.973385 2848.627868 2569.973385 2870.069534 C 2569.973385 2891.5112 2587.329247 2908.819533 2608.892592 2908.819533 C 2630.192969 2908.819533 2647.811799 2891.5112 2647.811799 2870.069534 Z M 2647.811799 2870.069534 " stroke="#7fcb27" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10"/></g><g clip-path="url(#d91879e462)"><path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 2810.851721 2870.069534 C 2810.851721 2848.627868 2793.495858 2831.061201 2771.932514 2831.061201 C 2750.369169 2831.061201 2733.013307 2848.627868 2733.013307 2870.069534 C 2733.013307 2891.5112 2750.369169 2908.819533 2771.932514 2908.819533 C 2793.495858 2908.819533 2810.851721 2891.5112 2810.851721 2870.069534 Z M 2810.851721 2870.069534 " stroke="#3abdc4" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10"/></g><path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 1782.122408 2921.477866 L 2284.390554 2921.477866 " stroke="#3abdc4" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10"/><path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 1782.122408 2818.661202 L 2284.390554 2818.661202 " stroke="#3abdc4" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10"/><g clip-path="url(#6e6c92010b)"><path fill="#274169" d="M 31.3125 19.425781 C 31.3125 19.570312 31.195312 19.6875 31.050781 19.6875 L 6.191406 19.6875 C 6.042969 19.6875 5.925781 19.570312 5.925781 19.425781 L 5.925781 12.75 C 5.925781 12.605469 6.042969 12.488281 6.191406 12.488281 L 31.050781 12.488281 C 31.195312 12.488281 31.3125 12.605469 31.3125 12.75 L 31.3125 19.425781 " fill-opacity="1" fill-rule="nonzero"/></g><path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 1441.316378 2385.177879 L 1441.316378 2235.602883 " stroke="#ffffff" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10"/><path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 1530.988335 2385.177879 L 1530.988335 2235.602883 " stroke="#ffffff" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10"/><path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 1620.660292 2385.177879 L 1620.660292 2235.602883 " stroke="#ffffff" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10"/><g clip-path="url(#55fc91f3cc)"><path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 2481.879234 2300.444548 C 2481.879234 2279.002882 2464.523371 2261.436216 2442.960026 2261.436216 C 2421.396682 2261.436216 2404.040819 2279.002882 2404.040819 2300.444548 C 2404.040819 2321.886214 2421.396682 2339.194547 2442.960026 2339.194547 C 2464.523371 2339.194547 2481.879234 2321.886214 2481.879234 2300.444548 Z M 2481.879234 2300.444548 " stroke="#d7282f" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10"/></g><g clip-path="url(#a07d158a93)"><path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 2647.811799 2300.444548 C 2647.811799 2279.002882 2630.192969 2261.436216 2608.892592 2261.436216 C 2587.329247 2261.436216 2569.973385 2279.002882 2569.973385 2300.444548 C 2569.973385 2321.886214 2587.329247 2339.194547 2608.892592 2339.194547 C 2630.192969 2339.194547 2647.811799 2321.886214 2647.811799 2300.444548 Z M 2647.811799 2300.444548 " stroke="#7fcb27" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10"/></g><g clip-path="url(#5261b93a12)"><path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 2810.851721 2300.444548 C 2810.851721 2279.002882 2793.495858 2261.436216 2771.932514 2261.436216 C 2750.369169 2261.436216 2733.013307 2279.002882 2733.013307 2300.444548 C 2733.013307 2321.886214 2750.369169 2339.194547 2771.932514 2339.194547 C 2793.495858 2339.194547 2810.851721 2321.886214 2810.851721 2300.444548 Z M 2810.851721 2300.444548 " stroke="#3abdc4" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10"/></g><path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 1782.122408 2351.594547 L 2284.390554 2351.594547 " stroke="#3abdc4" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10"/><path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 1782.122408 2249.036216 L 2284.390554 2249.036216 " stroke="#3abdc4" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10"/><g clip-path="url(#1121e46075)"><path fill="#274169" d="M 31.3125 28.511719 C 31.3125 28.65625 31.195312 28.777344 31.050781 28.777344 L 6.191406 28.777344 C 6.042969 28.777344 5.925781 28.65625 5.925781 28.511719 L 5.925781 21.839844 C 5.925781 21.691406 6.042969 21.578125 6.191406 21.578125 L 31.050781 21.578125 C 31.195312 21.578125 31.3125 21.691406 31.3125 21.839844 L 31.3125 28.511719 " fill-opacity="1" fill-rule="nonzero"/></g><path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 1441.316378 1784.036228 L 1441.316378 1634.719565 " stroke="#ffffff" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10"/><path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 1530.988335 1784.036228 L 1530.988335 1634.719565 " stroke="#ffffff" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10"/><path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 1620.660292 1784.036228 L 1620.660292 1634.719565 " stroke="#ffffff" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10"/><g clip-path="url(#506439da94)"><path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 2481.879234 1699.302897 C 2481.879234 1677.861231 2464.523371 1660.294564 2442.960026 1660.294564 C 2421.396682 1660.294564 2404.040819 1677.861231 2404.040819 1699.302897 C 2404.040819 1720.744563 2421.396682 1738.311229 2442.960026 1738.311229 C 2464.523371 1738.311229 2481.879234 1720.744563 2481.879234 1699.302897 Z M 2481.879234 1699.302897 " stroke="#d7282f" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10"/></g><g clip-path="url(#0f2cbe7ec3)"><path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 2647.811799 1699.302897 C 2647.811799 1677.861231 2630.192969 1660.294564 2608.892592 1660.294564 C 2587.329247 1660.294564 2569.973385 1677.861231 2569.973385 1699.302897 C 2569.973385 1720.744563 2587.329247 1738.311229 2608.892592 1738.311229 C 2630.192969 1738.311229 2647.811799 1720.744563 2647.811799 1699.302897 Z M 2647.811799 1699.302897 " stroke="#7fcb27" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10"/></g><g clip-path="url(#b8cf7bebfe)"><path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 2810.851721 1699.302897 C 2810.851721 1677.861231 2793.495858 1660.294564 2771.932514 1660.294564 C 2750.369169 1660.294564 2733.013307 1677.861231 2733.013307 1699.302897 C 2733.013307 1720.744563 2750.369169 1738.311229 2771.932514 1738.311229 C 2793.495858 1738.311229 2810.851721 1720.744563 2810.851721 1699.302897 Z M 2810.851721 1699.302897 " stroke="#3abdc4" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10"/></g><path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 1782.122408 1750.711229 L 2284.390554 1750.711229 " stroke="#3abdc4" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10"/><path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 1782.122408 1647.894565 L 2284.390554 1647.894565 " stroke="#3abdc4" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10"/><path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 2126.08405 1471.194569 L 2126.08405 1262.977908 " stroke="#274169" stroke-width="35.735001" stroke-opacity="1" stroke-miterlimit="10"/><g clip-path="url(#4b3d0ddad2)"><path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 2016.952489 1159.12791 L 1519.41776 1159.12791 " stroke="#274169" stroke-width="44.157001" stroke-opacity="1" stroke-miterlimit="10"/></g><g clip-path="url(#5b56525f76)"><path stroke-linecap="butt" transform="matrix(0.0148545, 0, 0, -0.015121, -12.960802, 51.02323)" fill="none" stroke-linejoin="miter" d="M 2755.628521 1159.12791 L 2257.830825 1159.12791 " stroke="#274169" stroke-width="44.157001" stroke-opacity="1" stroke-miterlimit="10"/></g><g clip-path="url(#34e12966fd)"><path fill="#3abdc4" d="M 20.578125 33.878906 L 16.660156 33.878906 L 16.660156 31.925781 L 20.578125 31.925781 L 20.578125 33.878906 " fill-opacity="1" fill-rule="nonzero"/></g></svg>
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
              <!--<a href = gallery.php>
              <button @click="isShowPopper = !isShowPopper" x-ref="popperRef" class="avatar h-12 w-12">
                <img class="rounded-full" src="images/logos/iPMS.svg" alt="avatar">
                <span class="absolute right-0 h-3.5 w-3.5 rounded-full border-2 border-white bg-success dark:border-navy-700"></span>
              </button>-->

              <!-- Profile || ADD Clear button-->
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
                          <!--  Account Type -->
                              <?php echo $_SESSION['role']; ?>
                          </a>
                          <p class="text-xs text-slate-400 dark:text-navy-300">
                          <!--    Company Name -->
                            <?php echo $_SESSION['client']; ?>
                          </p>
                        </div>
                      </div>
                      <div class="flex flex-col pt-2 pb-5">
                        <div class="mt-3 px-4">                       
                          <a  <?php if($_SESSION['role'] != 'sadmin'){
                                echo 'style="display: none;"';
                                
                              } ?>onclick="confirmDelete()">
                          <button class="btn h-9 w-full space-x-2" style="background-color: red; color: white;" 
                                  class="hover:bg-red-focus focus:bg-red-focus active:bg-red-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewbox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            <span>Clear</span>
                          </button>
                        </a>
                        <?php
                          if (isset($_SESSION['data_cleared']) && $_SESSION['data_cleared']) {
                            echo '<script>
                                var popup = document.createElement("div");
                                popup.className = "popup";
                                popup.innerHTML = "Data cleared successfully.";
                                document.body.appendChild(popup);
                                
                                  setTimeout(function() {
                                      popup.style.opacity = "1";
                                  }, 100);
                                  
                                  setTimeout(function() {
                                      popup.style.opacity = "0";
                                      setTimeout(function() {
                                          document.body.removeChild(popup);
                                      }, 300);
                                  }, 3000);
                              </script>';
                            
                            // Clear the session variable
                            unset($_SESSION['data_cleared']);
                        }
                        ?> 
                        </div>
                      </div>
                    </div>
                  </div>
            </div>

          </div>
        </div>
      </nav>
      <!-- Main Content Wrapper -->
      <main @click="$store.global.isSidebarExpanded = false" class="main-content w-full px-[var(--margin-x)] pb-8">
        <div class="mt-4 grid grid-cols-1 gap-4 sm:mt-5 sm:gap-5 lg:mt-6 lg:gap-6">
          <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-5 lg:grid-cols-4 lg:gap-6">
            <div class="card flex-row justify-between p-4">
              <div>
                <p class="text-xs+ uppercase">Total Income</p>
                <div class="mt-8 flex items-baseline space-x-1">
                  <p class="text-2xl font-semibold text-slate-700 dark:text-navy-100">
                    <!-- <?php echo 'Rs. '.$data[0][0]; ?> -->
                    <?php echo 'Rs. '.number_format($data[0][0], 2, '.', ','); ?>
                  </p>
                  <p class="text-xs text-success"></p>
                </div>
              </div>
              <div class="mask is-squircle flex h-10 w-10 items-center justify-center bg-warning/10">
                <i class="fa-solid fa-money-check-dollar text-xl text-warning"></i>
              </div>
              <div class="absolute bottom-0 right-0 overflow-hidden rounded-lg">
                <i class="fa-solid fa-money-check-dollar translate-x-1/4 translate-y-1/4 text-5xl opacity-15"></i>
              </div>
            </div>
            <div class="card flex-row justify-between p-4">
              <div>
                <p class="text-xs+ uppercase">Total Vehicle</p>
                <div class="mt-8 flex items-baseline space-x-1">
                  <p class="text-2xl font-semibold text-slate-700 dark:text-navy-100">
                      <?php echo $data[0][1]; ?>
                  </p>
                  <p class="text-xs text-success"></p>
                </div>
              </div>
              <div class="mask is-squircle flex h-10 w-10 items-center justify-center bg-info/10">
                <i class="fa-solid fa-car text-xl text-info"></i>
              </div>
              <div class="absolute bottom-0 right-0 overflow-hidden rounded-lg">
                <i class="fa-solid fa-car translate-x-1/4 translate-y-1/4 text-5xl opacity-15"></i>
              </div>
            </div>
            <div class="card flex-row justify-between p-4">
              <div>
                <p class="text-xs+ uppercase">Total In</p>
                <div class="mt-8 flex items-baseline space-x-1">
                  <p class="text-2xl font-semibold text-slate-700 dark:text-navy-100">
                      <?php echo $data[0][2]; ?>
                  </p>
                  <p class="text-xs text-success"></p>
                </div>
              </div>
              <div class="mask is-squircle flex h-10 w-10 items-center justify-center bg-success/10">
                <i class="fa-solid fa-car-side text-xl text-success"></i>
              </div>
              <div class="absolute bottom-0 right-0 overflow-hidden rounded-lg">
                <i class="fa-solid fa-car-side translate-x-1/4 translate-y-1/4 text-5xl opacity-15"></i>
              </div>
            </div>
            <div class="card flex-row justify-between p-4">
              <div>
                <p class="text-xs+ uppercase">Total Out</p>
                <div class="mt-8 flex items-baseline space-x-1">
                  <p class="text-2xl font-semibold text-slate-700 dark:text-navy-100">
                      <?php echo $data[0][3]; ?>
                  </p>
                  <p class="text-xs text-error"></p>
                </div>
              </div>
              <div class="mask is-squircle flex h-10 w-10 items-center justify-center bg-error/10">
                <i class="fa-solid fa-car-side text-xl text-error"></i>
              </div>
              <div class="absolute bottom-0 right-0 overflow-hidden rounded-lg">
                <i class="fa-solid fa-car-side translate-x-1/4 translate-y-1/4 text-5xl opacity-15"></i>
              </div>
            </div>
          </div>
          <div id="chart"></div>
          <div id="chart1"></div>
        </div>

        <!-- Table to show in and out vehicls -->
        <div>
          <div class="table-container">
                <table id="vehicle-table" class="w-full text-left"">
                  <thead class="thead-light">
                    <tr class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
                      <th class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">Date</th>
                      <th class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">Vehicle Number</th>
                      <th class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">In/Out</th>
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
              </div>
        </div>




        <div class="items-center justify-between py-5 lg:py-6">
            <h1 class="text-3xl text-primary dark:text-accent-light" style="text-align: center; font-family: 'Helvetica Neue'">Top 3 Parking Spots</h1>
        </div>
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-5 lg:grid-cols-3 lg:gap-6">
              <div class="card">
                  <img class="h-72 w-full rounded-lg object-cover object-center" src="images/object/1st.png" alt="image">
                  <div class="absolute inset-0 flex h-full w-full flex-col justify-end">
                      <div class="space-y-1.5 rounded-lg bg-gradient-to-t from-[#19213299] via-[#19213266] to-transparent px-4 pb-3 pt-12">
                          <div class="line-clamp-2">
                              <h1 class="text-xl text-info"><?php echo $top1;?></h1>
                          </div>
                          <div class="flex items-center justify-between">
                              <div class="flex items-center text-xs text-slate-200">
                                  <p class="flex items-center space-x-1">

                                      <!-- <span class="line-clamp-1">Total Income - Rs. <?php echo $top1Revenue;?></span> -->
                                      <span class="line-clamp-1">Total Income - Rs. <?php echo number_format($top1Revenue, 2, '.', ',');?></span>

                                  </p>
                                  <div class="mx-3 my-0.5 w-px self-stretch bg-white/20"></div>
                              </div>
                              <div class="-mr-1.5 flex">
                                  <button x-tooltip.secondary="'Top Spot'" class="btn h-7 w-7 rounded-full p-0 text-secondary-light hover:bg-secondary/20 focus:bg-secondary/20 active:bg-secondary/25 dark:hover:bg-secondary-light/20 dark:focus:bg-secondary-light/20 dark:active:bg-secondary-light/25">
                                      <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" zoomAndPan="magnify" viewBox="0 0 600 449.999984" preserveAspectRatio="xMidYMid meet" version="1.0"><defs><clipPath id="01702c59c0"><path d="M 127.5 52.5 L 472.5 52.5 L 472.5 397.5 L 127.5 397.5 Z M 127.5 52.5 " clip-rule="nonzero"/></clipPath></defs><path fill="#ee826c" d="M 453.953125 224.988281 C 453.953125 227.507812 453.890625 230.027344 453.765625 232.542969 C 453.644531 235.058594 453.457031 237.570312 453.210938 240.078125 C 452.964844 242.585938 452.65625 245.085938 452.285156 247.578125 C 451.917969 250.070312 451.484375 252.550781 450.996094 255.023438 C 450.503906 257.492188 449.953125 259.953125 449.339844 262.394531 C 448.726562 264.839844 448.054688 267.265625 447.324219 269.679688 C 446.59375 272.089844 445.800781 274.480469 444.953125 276.851562 C 444.105469 279.222656 443.199219 281.574219 442.234375 283.902344 C 441.269531 286.230469 440.25 288.53125 439.171875 290.808594 C 438.09375 293.085938 436.960938 295.335938 435.773438 297.558594 C 434.585938 299.78125 433.347656 301.972656 432.050781 304.132812 C 430.753906 306.292969 429.40625 308.421875 428.007812 310.515625 C 426.609375 312.613281 425.15625 314.671875 423.65625 316.695312 C 422.15625 318.71875 420.605469 320.703125 419.007812 322.652344 C 417.410156 324.597656 415.765625 326.507812 414.074219 328.375 C 412.382812 330.238281 410.644531 332.0625 408.863281 333.847656 C 407.082031 335.628906 405.257812 337.363281 403.390625 339.054688 C 401.523438 340.746094 399.617188 342.394531 397.667969 343.992188 C 395.722656 345.589844 393.734375 347.140625 391.710938 348.640625 C 389.6875 350.140625 387.628906 351.589844 385.535156 352.992188 C 383.441406 354.390625 381.3125 355.738281 379.152344 357.035156 C 376.988281 358.328125 374.796875 359.570312 372.578125 360.757812 C 370.355469 361.945312 368.105469 363.078125 365.828125 364.15625 C 363.550781 365.230469 361.246094 366.253906 358.917969 367.21875 C 356.589844 368.179688 354.242188 369.085938 351.871094 369.9375 C 349.496094 370.785156 347.105469 371.574219 344.695312 372.308594 C 342.285156 373.039062 339.855469 373.710938 337.414062 374.320312 C 334.96875 374.933594 332.511719 375.484375 330.039062 375.976562 C 327.570312 376.46875 325.085938 376.898438 322.59375 377.269531 C 320.101562 377.640625 317.605469 377.945312 315.097656 378.195312 C 312.589844 378.441406 310.078125 378.625 307.5625 378.75 C 305.042969 378.875 302.527344 378.933594 300.007812 378.933594 C 297.488281 378.933594 294.96875 378.875 292.453125 378.75 C 289.9375 378.625 287.425781 378.441406 284.917969 378.195312 C 282.410156 377.945312 279.910156 377.640625 277.417969 377.269531 C 274.925781 376.898438 272.445312 376.46875 269.972656 375.976562 C 267.503906 375.484375 265.046875 374.933594 262.601562 374.320312 C 260.15625 373.710938 257.730469 373.039062 255.320312 372.308594 C 252.90625 371.574219 250.515625 370.785156 248.144531 369.9375 C 245.773438 369.085938 243.421875 368.179688 241.09375 367.21875 C 238.765625 366.253906 236.464844 365.230469 234.1875 364.15625 C 231.910156 363.078125 229.660156 361.945312 227.4375 360.757812 C 225.214844 359.570312 223.023438 358.328125 220.863281 357.035156 C 218.703125 355.738281 216.574219 354.390625 214.480469 352.992188 C 212.382812 351.589844 210.324219 350.140625 208.300781 348.640625 C 206.277344 347.140625 204.292969 345.589844 202.34375 343.992188 C 200.398438 342.394531 198.488281 340.746094 196.625 339.054688 C 194.757812 337.363281 192.933594 335.628906 191.152344 333.847656 C 189.371094 332.0625 187.632812 330.238281 185.941406 328.375 C 184.25 326.507812 182.601562 324.597656 181.003906 322.652344 C 179.40625 320.703125 177.855469 318.71875 176.355469 316.695312 C 174.855469 314.671875 173.40625 312.613281 172.003906 310.515625 C 170.605469 308.421875 169.257812 306.292969 167.964844 304.132812 C 166.667969 301.972656 165.425781 299.78125 164.238281 297.558594 C 163.050781 295.335938 161.917969 293.085938 160.839844 290.808594 C 159.765625 288.53125 158.742188 286.230469 157.78125 283.902344 C 156.816406 281.574219 155.910156 279.222656 155.058594 276.851562 C 154.210938 274.480469 153.421875 272.089844 152.691406 269.679688 C 151.957031 267.265625 151.285156 264.839844 150.675781 262.394531 C 150.0625 259.953125 149.511719 257.492188 149.019531 255.023438 C 148.527344 252.550781 148.097656 250.070312 147.726562 247.578125 C 147.359375 245.085938 147.050781 242.585938 146.800781 240.078125 C 146.554688 237.570312 146.371094 235.058594 146.246094 232.542969 C 146.121094 230.027344 146.0625 227.507812 146.0625 224.988281 C 146.0625 222.46875 146.121094 219.953125 146.246094 217.4375 C 146.371094 214.917969 146.554688 212.40625 146.800781 209.898438 C 147.050781 207.394531 147.359375 204.894531 147.726562 202.402344 C 148.097656 199.910156 148.527344 197.425781 149.019531 194.957031 C 149.511719 192.484375 150.0625 190.027344 150.675781 187.582031 C 151.285156 185.140625 151.957031 182.710938 152.691406 180.300781 C 153.421875 177.890625 154.210938 175.5 155.058594 173.125 C 155.910156 170.753906 156.816406 168.40625 157.78125 166.078125 C 158.742188 163.75 159.765625 161.445312 160.839844 159.167969 C 161.917969 156.890625 163.050781 154.640625 164.238281 152.421875 C 165.425781 150.199219 166.667969 148.007812 167.964844 145.84375 C 169.257812 143.683594 170.605469 141.558594 172.003906 139.460938 C 173.40625 137.367188 174.855469 135.308594 176.355469 133.285156 C 177.855469 131.261719 179.40625 129.273438 181.003906 127.328125 C 182.601562 125.378906 184.25 123.472656 185.941406 121.605469 C 187.632812 119.738281 189.371094 117.914062 191.152344 116.132812 C 192.933594 114.351562 194.757812 112.613281 196.625 110.921875 C 198.488281 109.230469 200.398438 107.585938 202.34375 105.988281 C 204.292969 104.390625 206.277344 102.839844 208.300781 101.339844 C 210.324219 99.839844 212.382812 98.386719 214.480469 96.988281 C 216.574219 95.589844 218.703125 94.242188 220.863281 92.945312 C 223.023438 91.652344 225.214844 90.410156 227.4375 89.222656 C 229.660156 88.035156 231.910156 86.902344 234.1875 85.824219 C 236.464844 84.746094 238.765625 83.726562 241.09375 82.761719 C 243.421875 81.796875 245.773438 80.890625 248.144531 80.042969 C 250.515625 79.195312 252.90625 78.402344 255.320312 77.671875 C 257.730469 76.941406 260.15625 76.269531 262.601562 75.65625 C 265.046875 75.046875 267.503906 74.492188 269.972656 74 C 272.445312 73.511719 274.925781 73.078125 277.417969 72.710938 C 279.910156 72.339844 282.410156 72.03125 284.917969 71.785156 C 287.425781 71.539062 289.9375 71.351562 292.453125 71.230469 C 294.96875 71.105469 297.488281 71.042969 300.007812 71.042969 C 302.527344 71.042969 305.042969 71.105469 307.5625 71.230469 C 310.078125 71.351562 312.589844 71.539062 315.097656 71.785156 C 317.605469 72.03125 320.101562 72.339844 322.59375 72.710938 C 325.085938 73.078125 327.570312 73.511719 330.039062 74 C 332.511719 74.492188 334.96875 75.046875 337.414062 75.65625 C 339.855469 76.269531 342.285156 76.941406 344.695312 77.671875 C 347.105469 78.402344 349.496094 79.195312 351.871094 80.042969 C 354.242188 80.890625 356.589844 81.796875 358.917969 82.761719 C 361.246094 83.726562 363.550781 84.746094 365.828125 85.824219 C 368.105469 86.902344 370.355469 88.035156 372.578125 89.222656 C 374.796875 90.410156 376.988281 91.652344 379.152344 92.945312 C 381.3125 94.242188 383.441406 95.589844 385.535156 96.988281 C 387.628906 98.386719 389.6875 99.839844 391.710938 101.339844 C 393.734375 102.839844 395.722656 104.390625 397.667969 105.988281 C 399.617188 107.585938 401.523438 109.230469 403.390625 110.921875 C 405.257812 112.613281 407.082031 114.351562 408.863281 116.132812 C 410.644531 117.914062 412.382812 119.738281 414.074219 121.605469 C 415.765625 123.472656 417.410156 125.378906 419.007812 127.328125 C 420.605469 129.273438 422.15625 131.261719 423.65625 133.285156 C 425.15625 135.308594 426.609375 137.367188 428.007812 139.460938 C 429.40625 141.558594 430.753906 143.683594 432.050781 145.84375 C 433.347656 148.007812 434.585938 150.199219 435.773438 152.421875 C 436.960938 154.640625 438.09375 156.890625 439.171875 159.167969 C 440.25 161.445312 441.269531 163.75 442.234375 166.078125 C 443.199219 168.40625 444.105469 170.753906 444.953125 173.125 C 445.800781 175.5 446.59375 177.890625 447.324219 180.300781 C 448.054688 182.710938 448.726562 185.140625 449.339844 187.582031 C 449.953125 190.027344 450.503906 192.484375 450.996094 194.957031 C 451.484375 197.425781 451.917969 199.910156 452.285156 202.402344 C 452.65625 204.894531 452.964844 207.394531 453.210938 209.898438 C 453.457031 212.40625 453.644531 214.917969 453.765625 217.4375 C 453.890625 219.953125 453.953125 222.46875 453.953125 224.988281 Z M 453.953125 224.988281 " fill-opacity="1" fill-rule="nonzero"/><g clip-path="url(#01702c59c0)"><path fill="#ee826c" d="M 299.992188 397.488281 C 204.875 397.488281 127.5 320.117188 127.5 224.992188 C 127.5 129.875 204.875 52.5 299.992188 52.5 C 395.113281 52.5 472.5 129.875 472.5 224.992188 C 472.5 320.117188 395.125 397.488281 299.992188 397.488281 Z M 299.992188 64.324219 C 211.40625 64.324219 139.324219 136.402344 139.324219 224.992188 C 139.324219 313.601562 211.410156 385.667969 299.992188 385.667969 C 388.601562 385.667969 460.675781 313.597656 460.675781 224.992188 C 460.6875 136.402344 388.597656 64.324219 299.992188 64.324219 Z M 299.992188 64.324219 " fill-opacity="1" fill-rule="nonzero"/></g><path fill="#ffffff" d="M 239.902344 147.214844 C 243.886719 147.226562 248.148438 146.847656 252.726562 146.085938 C 257.3125 145.308594 261.457031 143.996094 265.21875 142.113281 C 268.949219 140.230469 272.089844 137.65625 274.597656 134.394531 C 277.101562 131.113281 278.347656 126.898438 278.371094 121.722656 L 342.519531 121.945312 L 342.078125 259.628906 C 342.054688 265.816406 343.53125 269.855469 346.535156 271.75 C 349.535156 273.667969 353.390625 274.613281 358.105469 274.636719 L 367.535156 274.664062 L 367.335938 326.0625 L 242.246094 325.667969 L 242.417969 274.28125 L 253.503906 274.304688 C 258.398438 274.328125 262.027344 272.800781 264.390625 269.707031 C 266.757812 266.605469 267.945312 263.265625 267.957031 259.652344 L 268.171875 193.023438 L 239.777344 192.933594 Z M 239.902344 147.214844 " fill-opacity="1" fill-rule="nonzero"/></svg>
                                  </button>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="card">
                <img class="h-72 w-full rounded-lg object-cover object-center" src="images/object/2nd.png" alt="image">
                <div class="absolute inset-0 flex h-full w-full flex-col justify-end">
                    <div class="space-y-1.5 rounded-lg bg-gradient-to-t from-[#19213299] via-[#19213266] to-transparent px-4 pb-3 pt-12">
                        <div class="line-clamp-2">
                            <h1 class="text-xl text-info"><?php echo $top2;?></h1>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-xs text-slate-200">
                                <p class="flex items-center space-x-1">
                                    <!--                                         Put
                                                                                    Total
                                                                                            Income-->
                                    <span class="line-clamp-1">Total Income - Rs. <?php echo number_format($top2Revenue, 2, '.', ',');?></span>
                                </p>
                                <div class="mx-3 my-0.5 w-px self-stretch bg-white/20"></div>
                            </div>
                            <div class="-mr-1.5 flex">
                                <button x-tooltip.secondary="'2nd'" class="btn h-7 w-7 rounded-full p-0 text-secondary-light hover:bg-secondary/20 focus:bg-secondary/20 active:bg-secondary/25 dark:hover:bg-secondary-light/20 dark:focus:bg-secondary-light/20 dark:active:bg-secondary-light/25">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" zoomAndPan="magnify" viewBox="0 0 600 449.999984" preserveAspectRatio="xMidYMid meet" version="1.0"><defs><clipPath id="705025b523"><path d="M 115.761719 45 L 484.011719 45 L 484.011719 413.25 L 115.761719 413.25 Z M 115.761719 45 " clip-rule="nonzero"/></clipPath></defs><path fill="#ee826c" d="M 464.214844 229.113281 C 464.214844 231.804688 464.148438 234.492188 464.019531 237.175781 C 463.886719 239.863281 463.6875 242.542969 463.425781 245.21875 C 463.160156 247.894531 462.832031 250.566406 462.4375 253.226562 C 462.042969 255.886719 461.582031 258.535156 461.058594 261.171875 C 460.535156 263.808594 459.945312 266.433594 459.292969 269.039062 C 458.636719 271.648438 457.921875 274.238281 457.140625 276.8125 C 456.359375 279.386719 455.515625 281.941406 454.609375 284.472656 C 453.703125 287.003906 452.738281 289.511719 451.707031 291.996094 C 450.679688 294.480469 449.589844 296.9375 448.4375 299.371094 C 447.289062 301.800781 446.082031 304.203125 444.8125 306.574219 C 443.546875 308.945312 442.21875 311.285156 440.835938 313.589844 C 439.457031 315.898438 438.015625 318.167969 436.523438 320.40625 C 435.027344 322.640625 433.480469 324.839844 431.878906 327 C 430.277344 329.160156 428.621094 331.277344 426.917969 333.359375 C 425.210938 335.4375 423.453125 337.472656 421.648438 339.464844 C 419.84375 341.457031 417.988281 343.40625 416.085938 345.304688 C 414.1875 347.207031 412.238281 349.0625 410.246094 350.867188 C 408.253906 352.671875 406.21875 354.429688 404.140625 356.136719 C 402.058594 357.839844 399.941406 359.496094 397.78125 361.097656 C 395.621094 362.699219 393.421875 364.246094 391.1875 365.742188 C 388.949219 367.234375 386.679688 368.671875 384.371094 370.054688 C 382.066406 371.4375 379.726562 372.765625 377.355469 374.03125 C 374.984375 375.300781 372.582031 376.507812 370.152344 377.65625 C 367.71875 378.808594 365.261719 379.898438 362.777344 380.925781 C 360.292969 381.957031 357.785156 382.921875 355.253906 383.828125 C 352.722656 384.734375 350.167969 385.578125 347.59375 386.359375 C 345.023438 387.140625 342.429688 387.855469 339.820312 388.511719 C 337.214844 389.164062 334.589844 389.753906 331.953125 390.277344 C 329.316406 390.800781 326.667969 391.261719 324.007812 391.65625 C 321.347656 392.050781 318.679688 392.378906 316 392.644531 C 313.324219 392.90625 310.644531 393.105469 307.957031 393.238281 C 305.273438 393.367188 302.585938 393.433594 299.894531 393.433594 C 297.207031 393.433594 294.519531 393.367188 291.832031 393.238281 C 289.148438 393.105469 286.464844 392.90625 283.789062 392.644531 C 281.113281 392.378906 278.445312 392.050781 275.785156 391.65625 C 273.125 391.261719 270.476562 390.800781 267.839844 390.277344 C 265.199219 389.753906 262.578125 389.164062 259.96875 388.511719 C 257.359375 387.855469 254.769531 387.140625 252.195312 386.359375 C 249.621094 385.578125 247.070312 384.734375 244.539062 383.828125 C 242.003906 382.921875 239.496094 381.957031 237.011719 380.925781 C 234.527344 379.898438 232.070312 378.808594 229.640625 377.65625 C 227.207031 376.507812 224.808594 375.300781 222.433594 374.03125 C 220.0625 372.765625 217.722656 371.4375 215.417969 370.054688 C 213.109375 368.675781 210.839844 367.234375 208.605469 365.742188 C 206.367188 364.246094 204.167969 362.699219 202.007812 361.097656 C 199.851562 359.496094 197.730469 357.839844 195.652344 356.136719 C 193.574219 354.429688 191.535156 352.671875 189.542969 350.867188 C 187.550781 349.0625 185.605469 347.207031 183.703125 345.304688 C 181.800781 343.40625 179.949219 341.457031 178.140625 339.464844 C 176.335938 337.472656 174.578125 335.4375 172.875 333.359375 C 171.167969 331.277344 169.515625 329.160156 167.910156 327 C 166.308594 324.839844 164.761719 322.640625 163.269531 320.40625 C 161.773438 318.167969 160.335938 315.898438 158.953125 313.589844 C 157.570312 311.285156 156.246094 308.945312 154.976562 306.574219 C 153.710938 304.203125 152.5 301.800781 151.351562 299.371094 C 150.203125 296.9375 149.113281 294.480469 148.082031 291.996094 C 147.054688 289.511719 146.085938 287.003906 145.179688 284.472656 C 144.273438 281.941406 143.429688 279.386719 142.652344 276.8125 C 141.871094 274.242188 141.152344 271.648438 140.5 269.039062 C 139.847656 266.433594 139.257812 263.808594 138.730469 261.171875 C 138.207031 258.535156 137.746094 255.886719 137.351562 253.226562 C 136.957031 250.566406 136.628906 247.894531 136.367188 245.21875 C 136.101562 242.542969 135.90625 239.863281 135.773438 237.175781 C 135.640625 234.492188 135.574219 231.804688 135.574219 229.113281 C 135.574219 226.425781 135.640625 223.738281 135.773438 221.050781 C 135.90625 218.363281 136.101562 215.683594 136.367188 213.007812 C 136.628906 210.332031 136.957031 207.664062 137.351562 205.003906 C 137.746094 202.34375 138.207031 199.695312 138.730469 197.054688 C 139.257812 194.417969 139.847656 191.796875 140.5 189.1875 C 141.152344 186.578125 141.871094 183.988281 142.652344 181.414062 C 143.429688 178.839844 144.273438 176.289062 145.179688 173.757812 C 146.085938 171.222656 147.054688 168.714844 148.082031 166.230469 C 149.113281 163.746094 150.203125 161.289062 151.351562 158.859375 C 152.5 156.425781 153.710938 154.027344 154.976562 151.652344 C 156.246094 149.28125 157.570312 146.941406 158.953125 144.636719 C 160.335938 142.328125 161.773438 140.058594 163.269531 137.824219 C 164.761719 135.585938 166.308594 133.386719 167.910156 131.226562 C 169.515625 129.066406 171.167969 126.949219 172.875 124.871094 C 174.578125 122.792969 176.335938 120.753906 178.140625 118.761719 C 179.949219 116.769531 181.800781 114.824219 183.703125 112.921875 C 185.605469 111.019531 187.550781 109.167969 189.542969 107.359375 C 191.535156 105.554688 193.574219 103.796875 195.652344 102.09375 C 197.730469 100.386719 199.851562 98.734375 202.007812 97.128906 C 204.167969 95.527344 206.367188 93.980469 208.605469 92.488281 C 210.839844 90.992188 213.109375 89.554688 215.417969 88.171875 C 217.722656 86.789062 220.0625 85.464844 222.433594 84.195312 C 224.808594 82.929688 227.207031 81.71875 229.640625 80.570312 C 232.070312 79.421875 234.527344 78.332031 237.011719 77.300781 C 239.496094 76.273438 242.003906 75.304688 244.539062 74.398438 C 247.070312 73.492188 249.621094 72.648438 252.195312 71.867188 C 254.769531 71.089844 257.359375 70.371094 259.96875 69.71875 C 262.578125 69.066406 265.199219 68.476562 267.839844 67.949219 C 270.476562 67.425781 273.125 66.964844 275.785156 66.570312 C 278.445312 66.175781 281.113281 65.847656 283.789062 65.585938 C 286.464844 65.320312 289.148438 65.125 291.832031 64.992188 C 294.519531 64.859375 297.207031 64.792969 299.894531 64.792969 C 302.585938 64.792969 305.273438 64.859375 307.957031 64.992188 C 310.644531 65.125 313.324219 65.320312 316 65.585938 C 318.679688 65.847656 321.347656 66.175781 324.007812 66.570312 C 326.667969 66.964844 329.316406 67.425781 331.953125 67.949219 C 334.589844 68.476562 337.214844 69.066406 339.820312 69.71875 C 342.429688 70.371094 345.023438 71.089844 347.59375 71.867188 C 350.167969 72.648438 352.722656 73.492188 355.253906 74.398438 C 357.785156 75.304688 360.292969 76.273438 362.777344 77.300781 C 365.261719 78.332031 367.71875 79.421875 370.152344 80.570312 C 372.582031 81.71875 374.984375 82.929688 377.355469 84.195312 C 379.726562 85.464844 382.066406 86.789062 384.371094 88.171875 C 386.679688 89.554688 388.949219 90.992188 391.1875 92.488281 C 393.421875 93.980469 395.621094 95.527344 397.78125 97.128906 C 399.941406 98.734375 402.058594 100.386719 404.140625 102.09375 C 406.21875 103.796875 408.253906 105.554688 410.246094 107.359375 C 412.238281 109.167969 414.1875 111.019531 416.085938 112.921875 C 417.988281 114.824219 419.84375 116.769531 421.648438 118.761719 C 423.453125 120.753906 425.210938 122.792969 426.917969 124.871094 C 428.621094 126.949219 430.277344 129.066406 431.878906 131.226562 C 433.480469 133.386719 435.027344 135.585938 436.523438 137.824219 C 438.015625 140.058594 439.457031 142.328125 440.835938 144.636719 C 442.21875 146.941406 443.546875 149.28125 444.8125 151.652344 C 446.082031 154.027344 447.289062 156.425781 448.4375 158.859375 C 449.589844 161.289062 450.679688 163.746094 451.707031 166.230469 C 452.738281 168.714844 453.703125 171.222656 454.609375 173.757812 C 455.515625 176.289062 456.359375 178.839844 457.140625 181.414062 C 457.921875 183.988281 458.636719 186.578125 459.292969 189.1875 C 459.945312 191.796875 460.535156 194.417969 461.058594 197.054688 C 461.582031 199.695312 462.042969 202.34375 462.4375 205.003906 C 462.832031 207.664062 463.160156 210.332031 463.425781 213.007812 C 463.6875 215.683594 463.886719 218.363281 464.019531 221.050781 C 464.148438 223.738281 464.214844 226.425781 464.214844 229.113281 Z M 464.214844 229.113281 " fill-opacity="1" fill-rule="nonzero"/><g clip-path="url(#705025b523)"><path fill="#ee826c" d="M 299.878906 413.238281 C 198.351562 413.238281 115.761719 330.652344 115.761719 229.117188 C 115.761719 127.589844 198.351562 45 299.878906 45 C 401.410156 45 484.011719 127.589844 484.011719 229.117188 C 484.011719 330.652344 401.421875 413.238281 299.878906 413.238281 Z M 299.878906 57.621094 C 205.324219 57.621094 128.382812 134.554688 128.382812 229.117188 C 128.382812 323.699219 205.328125 400.617188 299.878906 400.617188 C 394.460938 400.617188 471.394531 323.695312 471.394531 229.117188 C 471.402344 134.554688 394.457031 57.621094 299.878906 57.621094 Z M 299.878906 57.621094 " fill-opacity="1" fill-rule="nonzero"/></g><path fill="#ffffff" d="M 251.710938 291.78125 C 253.695312 289.320312 256.320312 286.632812 259.585938 283.746094 C 262.84375 280.839844 266.597656 278.128906 270.851562 275.628906 C 275.089844 273.148438 279.882812 271.027344 285.21875 269.316406 C 290.554688 267.613281 296.371094 266.765625 302.679688 266.789062 C 309.085938 266.816406 314.511719 267.171875 318.945312 267.871094 C 323.382812 268.585938 327.425781 269.289062 331.070312 270.066406 C 334.722656 270.808594 338.160156 271.542969 341.410156 272.234375 C 344.652344 272.949219 348.238281 273.296875 352.199219 273.324219 C 359.6875 273.347656 365.578125 271.714844 369.804688 268.492188 C 374.078125 265.261719 376.199219 259.199219 376.226562 250.324219 L 405.355469 250.433594 C 405.308594 269.25 403.484375 284.199219 399.910156 295.292969 C 396.308594 306.359375 391.425781 314.789062 385.246094 320.53125 C 379.082031 326.273438 371.738281 329.921875 363.261719 331.472656 C 354.777344 333.027344 345.710938 333.792969 336.050781 333.765625 C 328.371094 333.742188 320.941406 332.988281 313.792969 331.472656 C 306.65625 329.96875 299.808594 328.34375 293.253906 326.582031 C 286.695312 324.828125 280.4375 323.179688 274.492188 321.652344 C 268.53125 320.101562 262.933594 319.296875 257.707031 319.273438 C 253.1875 319.273438 249.601562 319.875 246.988281 321.109375 C 244.363281 322.339844 242.269531 323.625 240.691406 325.003906 C 238.804688 326.691406 237.378906 328.503906 236.378906 330.484375 L 202.503906 330.363281 C 202.550781 315.5625 204.269531 302.773438 207.578125 292.015625 C 210.917969 281.21875 215.339844 271.820312 220.839844 263.796875 C 226.347656 255.785156 232.632812 248.910156 239.683594 243.167969 C 246.757812 237.421875 253.941406 232.378906 261.246094 228.066406 C 268.554688 223.753906 275.726562 219.886719 282.800781 216.460938 C 289.859375 213.019531 296.136719 209.507812 301.613281 205.878906 C 307.097656 202.242188 311.503906 198.308594 314.8125 194.070312 C 318.117188 189.84375 319.796875 184.828125 319.816406 179.011719 C 319.84375 170.328125 316.488281 163.867188 309.75 159.597656 C 303.011719 155.339844 294.914062 153.191406 285.449219 153.167969 C 278.746094 153.128906 272.730469 153.613281 267.398438 154.585938 C 262.074219 155.558594 256.996094 157.261719 252.152344 159.714844 C 258.164062 161.5 263.375 164.386719 267.789062 168.339844 C 272.226562 172.296875 274.40625 178.125 274.378906 185.816406 C 274.367188 189.253906 273.589844 192.578125 272.0625 195.796875 C 270.523438 198.988281 268.28125 201.90625 265.375 204.570312 C 262.464844 207.222656 258.78125 209.277344 254.347656 210.746094 C 249.882812 212.210938 244.871094 212.929688 239.25 212.914062 C 235.007812 212.902344 230.644531 212.199219 226.171875 210.808594 C 221.699219 209.425781 217.65625 207.1875 214.058594 204.121094 C 210.472656 201.0625 207.53125 197.046875 205.238281 192.117188 C 202.929688 187.175781 201.796875 181.160156 201.824219 174.050781 C 201.859375 164.589844 204.398438 155.925781 209.4375 148.046875 C 214.492188 140.171875 221.566406 133.371094 230.660156 127.628906 C 239.753906 121.882812 250.660156 117.496094 263.390625 114.429688 C 276.121094 111.363281 290.070312 109.859375 305.25 109.902344 C 321.417969 109.957031 335.664062 111.742188 347.964844 115.214844 C 360.289062 118.703125 370.613281 123.496094 378.96875 129.59375 C 387.324219 135.679688 393.632812 142.753906 397.851562 150.804688 C 402.039062 158.851562 404.132812 167.464844 404.105469 176.625 C 404.082031 187.664062 402.257812 196.882812 398.695312 204.265625 C 395.136719 211.644531 390.292969 217.730469 384.21875 222.550781 C 378.128906 227.382812 371.152344 231.3125 363.265625 234.394531 C 355.359375 237.476562 347.078125 240.171875 338.375 242.515625 C 329.6875 244.871094 320.914062 247.1875 312.054688 249.453125 C 303.167969 251.746094 294.730469 254.613281 286.71875 258.105469 C 278.722656 261.59375 271.4375 265.894531 264.878906 271.046875 C 258.3125 276.1875 253.074219 282.828125 249.214844 290.875 Z M 251.710938 291.78125 " fill-opacity="1" fill-rule="nonzero"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
              <div class="card">
                <img class="h-72 w-full rounded-lg object-cover object-center" src="images/object/3rd.png" alt="image">
                <div class="absolute inset-0 flex h-full w-full flex-col justify-end">
                    <div class="space-y-1.5 rounded-lg bg-gradient-to-t from-[#19213299] via-[#19213266] to-transparent px-4 pb-3 pt-12">
                        <div class="line-clamp-2">
                            <h1 class="text-xl text-info"><?php echo $top3;?></h1>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-xs text-slate-200">
                                <p class="flex items-center space-x-1">
                                    <!--                                         Put
                                                                                    Total
                                                                                            Income-->
                                    <span class="line-clamp-1">Total Income - Rs. <?php echo number_format($top3Revenue,2,'.',',');?></span>

                                </p>
                                <div class="mx-3 my-0.5 w-px self-stretch bg-white/20"></div>
                            </div>
                            <div class="-mr-1.5 flex">
                                <button x-tooltip.secondary="'3rd'" class="btn h-7 w-7 rounded-full p-0 text-secondary-light hover:bg-secondary/20 focus:bg-secondary/20 active:bg-secondary/25 dark:hover:bg-secondary-light/20 dark:focus:bg-secondary-light/20 dark:active:bg-secondary-light/25">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" zoomAndPan="magnify" viewBox="0 0 600 449.999984" preserveAspectRatio="xMidYMid meet" version="1.0"><defs><clipPath id="01512d6251"><path d="M 93.847656 18.847656 L 506.347656 18.847656 L 506.347656 431.347656 L 93.847656 431.347656 Z M 93.847656 18.847656 " clip-rule="nonzero"/></clipPath></defs><path fill="#ee826c" d="M 484.171875 225.085938 C 484.171875 228.097656 484.097656 231.109375 483.949219 234.117188 C 483.800781 237.125 483.582031 240.128906 483.285156 243.125 C 482.988281 246.125 482.621094 249.113281 482.179688 252.09375 C 481.738281 255.074219 481.222656 258.039062 480.632812 260.996094 C 480.046875 263.949219 479.386719 266.886719 478.65625 269.808594 C 477.921875 272.730469 477.121094 275.632812 476.246094 278.515625 C 475.371094 281.398438 474.425781 284.257812 473.410156 287.09375 C 472.398438 289.929688 471.3125 292.742188 470.160156 295.523438 C 469.007812 298.308594 467.785156 301.058594 466.5 303.785156 C 465.210938 306.507812 463.855469 309.195312 462.4375 311.851562 C 461.015625 314.507812 459.53125 317.128906 457.984375 319.714844 C 456.433594 322.296875 454.824219 324.839844 453.152344 327.347656 C 451.476562 329.851562 449.742188 332.3125 447.949219 334.734375 C 446.152344 337.152344 444.300781 339.527344 442.390625 341.855469 C 440.480469 344.183594 438.511719 346.464844 436.488281 348.695312 C 434.464844 350.929688 432.390625 353.109375 430.257812 355.238281 C 428.128906 357.371094 425.949219 359.445312 423.714844 361.46875 C 421.484375 363.492188 419.203125 365.457031 416.875 367.371094 C 414.546875 369.28125 412.171875 371.132812 409.753906 372.929688 C 407.332031 374.722656 404.871094 376.457031 402.367188 378.128906 C 399.863281 379.804688 397.316406 381.414062 394.734375 382.964844 C 392.152344 384.511719 389.53125 385.996094 386.875 387.417969 C 384.21875 388.835938 381.527344 390.191406 378.804688 391.476562 C 376.082031 392.765625 373.328125 393.988281 370.542969 395.140625 C 367.761719 396.292969 364.953125 397.375 362.117188 398.390625 C 359.277344 399.40625 356.417969 400.351562 353.535156 401.226562 C 350.65625 402.097656 347.753906 402.902344 344.828125 403.632812 C 341.90625 404.367188 338.96875 405.027344 336.015625 405.613281 C 333.0625 406.203125 330.09375 406.714844 327.113281 407.160156 C 324.132812 407.601562 321.144531 407.96875 318.148438 408.265625 C 315.148438 408.558594 312.144531 408.78125 309.136719 408.929688 C 306.128906 409.078125 303.117188 409.152344 300.105469 409.152344 C 297.09375 409.152344 294.082031 409.078125 291.074219 408.929688 C 288.066406 408.78125 285.0625 408.558594 282.0625 408.265625 C 279.066406 407.96875 276.078125 407.601562 273.097656 407.160156 C 270.117188 406.714844 267.152344 406.203125 264.195312 405.613281 C 261.242188 405.027344 258.304688 404.367188 255.382812 403.632812 C 252.460938 402.902344 249.558594 402.097656 246.675781 401.226562 C 243.792969 400.351562 240.933594 399.40625 238.097656 398.390625 C 235.257812 397.375 232.449219 396.292969 229.667969 395.140625 C 226.882812 393.988281 224.128906 392.765625 221.40625 391.476562 C 218.683594 390.191406 215.996094 388.835938 213.335938 387.417969 C 210.679688 385.996094 208.0625 384.511719 205.476562 382.964844 C 202.894531 381.414062 200.347656 379.804688 197.84375 378.128906 C 195.339844 376.457031 192.878906 374.722656 190.457031 372.929688 C 188.039062 371.132812 185.664062 369.28125 183.335938 367.371094 C 181.007812 365.457031 178.726562 363.492188 176.496094 361.46875 C 174.261719 359.445312 172.082031 357.371094 169.953125 355.238281 C 167.820312 353.109375 165.746094 350.929688 163.722656 348.695312 C 161.699219 346.464844 159.730469 344.183594 157.820312 341.855469 C 155.910156 339.527344 154.058594 337.152344 152.261719 334.734375 C 150.46875 332.3125 148.734375 329.851562 147.0625 327.347656 C 145.386719 324.839844 143.777344 322.296875 142.226562 319.714844 C 140.679688 317.128906 139.195312 314.507812 137.773438 311.851562 C 136.355469 309.195312 135 306.507812 133.710938 303.785156 C 132.425781 301.058594 131.203125 298.308594 130.050781 295.523438 C 128.898438 292.742188 127.816406 289.929688 126.800781 287.09375 C 125.785156 284.257812 124.839844 281.398438 123.964844 278.515625 C 123.089844 275.632812 122.289062 272.730469 121.554688 269.808594 C 120.824219 266.886719 120.164062 263.949219 119.578125 260.996094 C 118.988281 258.039062 118.472656 255.074219 118.03125 252.09375 C 117.589844 249.113281 117.222656 246.125 116.925781 243.125 C 116.632812 240.128906 116.410156 237.125 116.261719 234.117188 C 116.113281 231.109375 116.039062 228.097656 116.039062 225.085938 C 116.039062 222.074219 116.113281 219.0625 116.261719 216.054688 C 116.410156 213.042969 116.632812 210.042969 116.925781 207.042969 C 117.222656 204.046875 117.589844 201.058594 118.03125 198.078125 C 118.472656 195.097656 118.988281 192.128906 119.578125 189.175781 C 120.164062 186.222656 120.824219 183.28125 121.554688 180.359375 C 122.289062 177.4375 123.089844 174.535156 123.964844 171.652344 C 124.839844 168.769531 125.785156 165.910156 126.800781 163.074219 C 127.816406 160.238281 128.898438 157.429688 130.050781 154.644531 C 131.203125 151.863281 132.425781 149.109375 133.710938 146.386719 C 135 143.664062 136.355469 140.972656 137.773438 138.316406 C 139.195312 135.660156 140.679688 133.039062 142.226562 130.457031 C 143.777344 127.871094 145.386719 125.328125 147.0625 122.824219 C 148.734375 120.320312 150.46875 117.855469 152.261719 115.4375 C 154.058594 113.019531 155.910156 110.644531 157.820312 108.316406 C 159.730469 105.988281 161.699219 103.707031 163.722656 101.472656 C 165.746094 99.242188 167.820312 97.0625 169.953125 94.929688 C 172.082031 92.800781 174.261719 90.722656 176.496094 88.703125 C 178.726562 86.679688 181.007812 84.710938 183.335938 82.800781 C 185.664062 80.890625 188.039062 79.035156 190.457031 77.242188 C 192.878906 75.449219 195.339844 73.714844 197.84375 72.039062 C 200.347656 70.367188 202.894531 68.753906 205.476562 67.207031 C 208.0625 65.65625 210.679688 64.171875 213.335938 62.753906 C 215.996094 61.332031 218.683594 59.980469 221.40625 58.691406 C 224.128906 57.402344 226.882812 56.183594 229.667969 55.03125 C 232.449219 53.878906 235.257812 52.792969 238.097656 51.777344 C 240.933594 50.765625 243.792969 49.820312 246.675781 48.945312 C 249.558594 48.070312 252.460938 47.265625 255.382812 46.535156 C 258.304688 45.804688 261.242188 45.144531 264.195312 44.554688 C 267.152344 43.96875 270.117188 43.453125 273.097656 43.011719 C 276.078125 42.570312 279.066406 42.199219 282.0625 41.90625 C 285.0625 41.609375 288.066406 41.390625 291.074219 41.242188 C 294.082031 41.09375 297.09375 41.019531 300.105469 41.019531 C 303.117188 41.019531 306.128906 41.09375 309.136719 41.242188 C 312.144531 41.390625 315.148438 41.609375 318.148438 41.90625 C 321.144531 42.199219 324.132812 42.570312 327.113281 43.011719 C 330.09375 43.453125 333.0625 43.96875 336.015625 44.554688 C 338.96875 45.144531 341.90625 45.804688 344.828125 46.535156 C 347.753906 47.265625 350.65625 48.070312 353.535156 48.945312 C 356.417969 49.820312 359.277344 50.765625 362.117188 51.777344 C 364.953125 52.792969 367.761719 53.878906 370.542969 55.03125 C 373.328125 56.183594 376.082031 57.402344 378.804688 58.691406 C 381.527344 59.980469 384.21875 61.332031 386.875 62.753906 C 389.53125 64.171875 392.152344 65.65625 394.734375 67.207031 C 397.316406 68.753906 399.863281 70.367188 402.367188 72.039062 C 404.871094 73.714844 407.332031 75.449219 409.753906 77.242188 C 412.171875 79.035156 414.546875 80.890625 416.875 82.800781 C 419.203125 84.710938 421.484375 86.679688 423.714844 88.703125 C 425.949219 90.722656 428.128906 92.800781 430.257812 94.929688 C 432.390625 97.0625 434.464844 99.242188 436.488281 101.472656 C 438.511719 103.707031 440.480469 105.988281 442.390625 108.316406 C 444.300781 110.644531 446.152344 113.019531 447.949219 115.4375 C 449.742188 117.855469 451.476562 120.320312 453.152344 122.824219 C 454.824219 125.328125 456.433594 127.871094 457.984375 130.457031 C 459.53125 133.039062 461.015625 135.660156 462.4375 138.316406 C 463.855469 140.972656 465.210938 143.664062 466.5 146.386719 C 467.785156 149.109375 469.007812 151.863281 470.160156 154.644531 C 471.3125 157.429688 472.398438 160.238281 473.410156 163.074219 C 474.425781 165.910156 475.371094 168.769531 476.246094 171.652344 C 477.121094 174.535156 477.921875 177.4375 478.65625 180.359375 C 479.386719 183.28125 480.046875 186.222656 480.632812 189.175781 C 481.222656 192.128906 481.738281 195.097656 482.179688 198.078125 C 482.621094 201.058594 482.988281 204.046875 483.285156 207.042969 C 483.582031 210.042969 483.800781 213.042969 483.949219 216.054688 C 484.097656 219.0625 484.171875 222.074219 484.171875 225.085938 Z M 484.171875 225.085938 " fill-opacity="1" fill-rule="nonzero"/><g clip-path="url(#01512d6251)"><path fill="#ee826c" d="M 300.089844 431.335938 C 186.359375 431.335938 93.847656 338.808594 93.847656 225.089844 C 93.847656 111.363281 186.359375 18.847656 300.089844 18.847656 C 413.820312 18.847656 506.347656 111.363281 506.347656 225.089844 C 506.359375 338.808594 413.832031 431.335938 300.089844 431.335938 Z M 300.089844 32.984375 C 194.171875 32.984375 107.984375 119.164062 107.984375 225.089844 C 107.984375 331.023438 194.175781 417.199219 300.089844 417.199219 C 406.035156 417.199219 492.210938 331.019531 492.210938 225.089844 C 492.210938 119.164062 406.03125 32.984375 300.089844 32.984375 Z M 300.089844 32.984375 " fill-opacity="1" fill-rule="nonzero"/></g><path fill="#ffffff" d="M 285.015625 139.730469 C 273.65625 139.683594 265.195312 140.902344 259.660156 143.371094 C 254.113281 145.832031 249.96875 148.160156 247.210938 150.371094 C 249.527344 150.589844 252.097656 151.1875 254.914062 152.136719 C 257.714844 153.089844 260.3125 154.46875 262.683594 156.296875 C 265.054688 158.117188 267.03125 160.632812 268.617188 163.773438 C 270.21875 166.921875 271.003906 170.871094 270.976562 175.617188 C 270.949219 184.453125 267.761719 191.519531 261.398438 196.796875 C 255.019531 202.078125 245.71875 204.691406 233.445312 204.644531 C 227.59375 204.632812 222.015625 203.707031 216.714844 201.875 C 211.429688 200.019531 206.734375 197.25 202.664062 193.535156 C 198.59375 189.839844 195.371094 185.238281 193.011719 179.757812 C 190.667969 174.28125 189.492188 167.847656 189.519531 160.445312 C 189.546875 150.082031 192.171875 140.636719 197.402344 132.148438 C 202.621094 123.660156 210.085938 116.359375 219.832031 110.269531 C 229.5625 104.179688 241.339844 99.519531 255.15625 96.296875 C 268.992188 93.085938 284.488281 91.507812 301.71875 91.566406 C 315.960938 91.609375 329.992188 92.738281 343.789062 94.933594 C 357.597656 97.128906 369.835938 100.84375 380.535156 106.070312 C 391.234375 111.304688 399.847656 118.164062 406.390625 126.695312 C 412.9375 135.210938 416.191406 145.664062 416.136719 158.027344 C 416.078125 173.488281 411.46875 185.902344 402.277344 195.257812 C 393.082031 204.621094 379.199219 210.8125 360.644531 213.839844 L 360.632812 215.660156 C 379.183594 217.9375 394.148438 223.996094 405.566406 233.867188 C 416.96875 243.738281 422.613281 257.941406 422.554688 276.492188 C 422.527344 284.445312 420.414062 292.53125 416.191406 300.734375 C 411.953125 308.957031 405.054688 316.382812 395.40625 323.039062 C 385.78125 329.703125 373.179688 335.132812 357.578125 339.398438 C 342 343.664062 322.890625 345.746094 300.253906 345.675781 C 278.722656 345.589844 260.449219 343.273438 245.441406 338.691406 C 230.421875 334.125 218.246094 328.253906 208.890625 321.101562 C 199.535156 313.949219 192.753906 305.835938 188.582031 296.78125 C 184.414062 287.683594 182.359375 278.527344 182.398438 269.253906 C 182.414062 261.855469 183.574219 255.203125 185.839844 249.308594 C 188.128906 243.398438 191.277344 238.46875 195.253906 234.511719 C 199.242188 230.546875 203.878906 227.582031 209.191406 225.609375 C 214.492188 223.644531 220.085938 222.667969 225.9375 222.679688 C 233.433594 222.707031 239.746094 223.726562 244.824219 225.714844 C 249.875 227.714844 253.945312 230.269531 256.953125 233.375 C 259.972656 236.464844 262.171875 239.878906 263.554688 243.578125 C 264.933594 247.289062 265.609375 250.855469 265.597656 254.289062 C 265.566406 263.550781 262.753906 270.648438 257.160156 275.632812 C 251.558594 280.574219 245.398438 284.082031 238.652344 286.164062 C 249.667969 292.933594 264.558594 296.351562 283.332031 296.417969 C 298.792969 296.464844 310.140625 293.582031 317.402344 287.746094 C 324.664062 281.910156 328.296875 273.53125 328.320312 262.609375 C 328.332031 257.191406 327.296875 252.5625 325.132812 248.683594 C 322.992188 244.816406 320.148438 241.6875 316.644531 239.300781 C 313.113281 236.910156 309.089844 235.15625 304.566406 234.039062 C 300.035156 232.921875 295.511719 232.355469 290.980469 232.34375 L 279.214844 232.300781 L 279.339844 196.355469 L 291.105469 196.398438 C 302.03125 196.425781 310.21875 193.746094 315.644531 188.363281 C 321.070312 182.964844 323.792969 176.632812 323.816406 169.332031 C 323.828125 163.714844 322.765625 158.949219 320.613281 155.070312 C 318.472656 151.207031 315.671875 148.125 312.195312 145.851562 C 308.726562 143.585938 304.613281 142 299.882812 141.105469 C 295.171875 140.195312 290.21875 139.742188 285.015625 139.730469 Z M 285.015625 139.730469 " fill-opacity="1" fill-rule="nonzero"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
      </main>
    </div>
    <div id="x-teleport-target"></div>
    <script>
      window.addEventListener("DOMContentLoaded", () => Alpine.start());
    </script>
    <script>

        var options = {
            series: [{
                name: 'In',
                data: []
            }, {
                name: 'Out',
                data: []
            }],
            chart: {
                type: 'bar',
                height: 430
            },
            plotOptions: {
                bar: {
                    horizontal: true,
                    dataLabels: {
                        position: 'top',
                    },
                }
            },
            dataLabels: {
                enabled: true,
                offsetX: -6,
                style: {
                    fontSize: '12px',
                    colors: ['#fff']
                }
            },
            stroke: {
                show: true,
                width: 1,
                colors: ['#fff']
            },
            tooltip: {
                shared: true,
                intersect: false
            },
            title: {
                text: 'Daily In & Out',
                align: 'center',
                margin: 10,
                offsetX: 0,
                offsetY: 0,
                floating: false,
                style: {
                    fontSize:  '20px',
                    fontWeight:  'bold',
                    fontFamily:  'Helvetica Neue',
                    color:  '#0f3ee8'
                },
            },
            xaxis: {
                categories: ['Friday', 'Monday', 'Saturday', 'Sunday', 'Thursday','Tuesday', 'Wednesday'],
            },
        };

        // PHP-generated JSON data
        var vehicle_data = <?php echo $vehicle_json_data; ?>;

        // Iterate over the data and add it to the options object
        for (var i = 1; i < vehicle_data.length; i++) {
            options.series[0].data.push(vehicle_data[i][1]);
            options.series[1].data.push(vehicle_data[i][2]);
        }

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    </script>
    <script>
    var options = {
      series: [{
        name: 'Revenue',
        data: []
      }],
      chart: {
        type: 'bar',
        height: 430
      },
      plotOptions: {
        bar: {
          horizontal: true,
          dataLabels: {
            position: 'top',
          },
        }
      },
      dataLabels: {
        enabled: true,
        offsetX: -6,
        style: {
          fontSize: '12px',
          colors: ['#fff']
        }
      },
      stroke: {
        show: true,
        width: 1,
        colors: ['#fff']
      },
      tooltip: {
        shared: true,
        intersect: false
      },
      title: {
        text: 'Daily Revenue',
        align: 'center',
        margin: 10,
        offsetX: 0,
        offsetY: 0,
        floating: false,
        style: {
          fontSize: '20px',
          fontWeight: 'bold',
          fontFamily: 'Helvetica Neue',
          color: '#0f3ee8'
        },
      },
      xaxis: {
        categories: [],
      },
    };

    // JSON data
    var revenueData = <?php echo $vehicle_json_data1; ?>;

    // Iterate over the data and add it to the options object
    for (var i = 1; i < revenueData.length; i++) {
      options.xaxis.categories.push(revenueData[i][0]);
      options.series[0].data.push(revenueData[i][1]);
    }

    var chart = new ApexCharts(document.querySelector("#chart1"), options);
    chart.render();
    </script>

    <!-- Vehical In/Out entries table  -->
    <script>
      // Get the table body element
        var tableBody = document.querySelector("#vehicle-table tbody");

        // Function to parse CSV data
        function parseCSV(csvData) {
          // Split the CSV data into lines
          var lines = csvData.split("\n");
          
          // Iterate over the lines and extract the data
          var data = [];
          for (var i = 1; i < lines.length; i++) {
            var line = lines[i].trim();
            if (line) {
              var entry = line.split(",");
              data.push(entry);
            }
          }
          
          return data;
        }

        // Function to fetch and process the CSV file
        function loadCSV() {
          fetch("csv/vehicledata-slt.csv")
            .then(function(response) {
              return response.text();
            })
            .then(function(csvData) {
              var vehicleData = parseCSV(csvData);
              populateTable(vehicleData);
            })
            .catch(function(error) {
              console.error("Error loading CSV file:", error);
            });
        }

        // Function to populate the table with data
        function populateTable(vehicleData) {
          // Clear existing table rows
          tableBody.innerHTML = "";
          
          // Iterate over the vehicle entries and generate table rows
          for (var i = 0; i < vehicleData.length; i++) {
            var entry = vehicleData[i];
            
            // Create a new table row
            var row = document.createElement("tr");
            
            
            // Create table cells for each data element
            var dateCell = document.createElement("td");
            dateCell.textContent = entry[3];
            dateCell.setAttribute("class", "whitespace-nowrap px-4 py-3 sm:px-5");
            
            var vehicleNumberCell = document.createElement("td");
            vehicleNumberCell.textContent = entry[1];
            vehicleNumberCell.setAttribute("class", "whitespace-nowrap px-4 py-3 sm:px-5");
            
            var inOutCell = document.createElement("td");
            var status;
            if(entry[2] = i){
              status = "In";
            }
            else{
              status = "Out";
            }

            inOutCell.textContent = status;
            inOutCell.setAttribute("class", "whitespace-nowrap px-4 py-3 sm:px-5");
            
            
            
            // Append cells to the row
            row.appendChild(dateCell);
            row.appendChild(vehicleNumberCell);
            row.appendChild(inOutCell);
            
            // Append the row to the table body
            tableBody.appendChild(row);
          }
        }

        // Load the CSV data and populate the table
        loadCSV();

        //clear button
        function confirmDelete() {
            var result = confirm("When you select the 'OK' button, the data will be permanently deleted.");
            if (result) {
                // User clicked OK, proceed with the updates
                window.location.href = "clear.php";
                updateTables();
            } else {
                // User clicked Cancel, redirect to subha.php
                window.location.href = "test1.php";
            }
        }
    </script>
 </body>
</html>

<?php

if (isset($_SESSION['msg'])){
    echo '<script>swal("Welcome", "Login success.", "success");</script>';
    unset($_SESSION['msg']);
}

?>
