<?php
session_start();

$user = $_SESSION['client'];

$database = 'pms-ml-' . $user;

$conn = mysqli_connect("localhost", "root", "", $database);

$sql = "SELECT * FROM `vehicle_logs` ";

$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_all($result);

if ($result->num_rows > 0) {
  $row = mysqli_fetch_assoc($result);
  $vehicle = $row['vehicle_number']; 
} else {
  $vehicle = "No";
}
echo $vehicle; // Output the latest vehicle

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

            <!-- Profile || ADD Clear button-->
            <div x-data="usePopper({placement:'right-end',offset:12})" @click.outside="isShowPopper && (isShowPopper = false)" class="flex">
              <button @click="isShowPopper = !isShowPopper" x-ref="popperRef" class="avatar h-12 w-12">
                <img class="rounded-full" src="../images/logos/iPMS.svg" alt="avatar">
                <span class="absolute right-0 h-3.5 w-3.5 rounded-full border-2 border-white bg-success dark:border-navy-700"></span>
              </button>
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