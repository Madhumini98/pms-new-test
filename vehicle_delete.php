<?php
include 'conn.php';
$sql = "SELECT `vehicle_num`, `vehicle_class`, `owner`, `phone`, `nic`, `image` FROM `vehicle`;";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_all($result);
$json = json_encode($row);
?>

<?php
include 'req.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
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

   
      #chart {

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
    <script src="https://unpkg.com/gridjs/dist/gridjs.production.min.js"></script>
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

              <!-- Add new Accounts -->
              <a href="addnew.php" class="flex h-11 w-11 items-center justify-center rounded-lg outline-none transition-colors duration-200 hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25" x-tooltip.placement.right="'Add New Accounts'">
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
              <a href="vehicle.php" class="flex h-11 w-11 items-center justify-center rounded-lg bg-primary/10 text-primary outline-none transition-colors duration-200 hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:bg-navy-600 dark:text-accent-light dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90" x-tooltip.placement.right="'Vehicles'">
                <svg class="h-7 w-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <path fill="currentColor" d="M2.5 9.5V6.05A1.55 1.55 0 0 1 4.05 4.5h8.9a1.55 1.55 0 0 1 1.55 1.55V9.5H2.5Z"></path>
                  <path fill="currentColor" d="M2.5 14.5v3.45a1.55 1.55 0 0 0 1.55 1.55h8.9a1.55 1.55 0 0 0 1.55-1.55V14.5H2.5Z"></path>
                  <path fill="currentColor" d="M4.05 4.5h8.9a1.55 1.55 0 0 1 1.55 1.55v9.45a1.55 1.55 0 0 1-1.55 1.55h-8.9a1.55 1.55 0 0 1-1.55-1.55V6.05A1.55 1.55 0 0 1 4.05 4.5Z"></path>
                  <path fill="currentColor" d="M15.5 9.5v5h2.5V9.5h-2.5Z"></path>
                  <path fill="currentColor" d="M6.5 9.5V7.75h2.5V9.5H6.5Z"></path>
                  <path fill="currentColor" d="M13 7.75h2.5V9.5H13V7.75Z"></path>
                  <path fill="currentColor" d="M13 12.75h2.5V14.5H13v-1.75Z"></path>
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
                        <a href="logout.php"> <button class="btn h-9 w-full space-x-2 bg-primary text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewbox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
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
            <div class="mt-4 grid grid-cols-1 gap-4 sm:mt-5 sm:gap-5 lg:mt-6 lg:gap-6">
                <div class="card pb-4">
                    <div>
                        <div id="wrapper"></div>
                    </div>
                </div>
            </div>
            <div x-data="{showModal:true}">
                <template x-teleport="#x-teleport-target">
                    <div
                            class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
                            x-show="showModal"
                            role="dialog"
                            @keydown.window.escape="showModal = false"
                    >
                        <div
                                class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
                                x-show="showModal"
                                x-transition:enter="ease-out"
                                x-transition:enter-start="opacity-0"
                                x-transition:enter-end="opacity-100"
                                x-transition:leave="ease-in"
                                x-transition:leave-start="opacity-100"
                                x-transition:leave-end="opacity-0"
                        ></div>
                        <div
                                class="relative max-w-lg rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
                                x-show="showModal"
                                x-transition:enter="ease-out"
                                x-transition:enter-start="opacity-0"
                                x-transition:enter-end="opacity-100"
                                x-transition:leave="ease-in"
                                x-transition:leave-start="opacity-100"
                                x-transition:leave-end="opacity-0"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="inline h-28 w-28 text-warning" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2L2 22h20L12 2zm0 15.5v-3M12 16v-2"/>
                                <circle cx="12" cy="19" r="1.5" fill="currentColor" stroke="none"/>
                            </svg>


                            <div class="mt-4">
                                <h2 class="text-2xl text-slate-700 dark:text-navy-100">
                                    Are you sure for delete : <?php echo $_GET['id']; ?>
                                </h2>
                                <a href="vehicle.php" > <button
                                        @click="showModal = false"
                                        class="btn mt-6 bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90"
                                >
                                    No
                                </button></a>
                                <a href="delete.php?id=<?php echo $_GET['id']; ?>"> <button
                                        @click="showModal = false"
                                        class="btn mt-6 bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90"
                                >
                                    Delete
                                </button></a>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </main>
    </div>
    <div id="x-teleport-target"></div>
    <script>
      window.addEventListener("DOMContentLoaded", () => Alpine.start());
    </script>
    <script src="https://unpkg.com/gridjs/dist/gridjs.umd.js"></script>
    <script>
        new gridjs.Grid({
            columns: ["Vehicle Num", "Vehicle Class", "Owner", "Phone", "NIC", {
                name: 'IMG',
                formatter: (cell) => gridjs.html(`<img style="width: 50px;" height="50px" src="images/slt/${cell}">`)
            },
                {
                    name: 'Action',
                    formatter: (_,row) => gridjs.html(`<a href="vehicledelete.php?id=${row.cells[0].data}" target="_blank"> <button type="button" class="btn btn-secondary">
                        <i style="color: red" class="fas fa-remove"></i>
                        </button></a>`)
                }],
            search: true,
            sort: true,
            pagination: true,
            data: <?php echo $json; ?>,
            style:{
                th:{

                }
            }
        }).render(document.getElementById("wrapper"));
    </script>
  </body>
</html>
