<?php
session_start();
if (!isset($_SESSION['login'])){
  header("Location: ../loginform.php");
}
else{
  if ($_SESSION['login'] == 'False'){
    header("Location: ../loginform.php");
  }
  if ($_SESSION['role'] != 'ssadmin'){
    header("Location: ../loginform.php");
  }
}
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
    <link rel="icon" type="image/png" href="../images/iPMS.svg">

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
                <img class="h-16 w-16 transition-transform duration-500 ease-in-out hover:rotate-[360deg]" src="../images/logos/iPMS.svg" alt="iPMS">
              </a>
            </div>

            <!-- Main Sections Links -->
            <div class="is-scrollbar-hidden flex grow flex-col space-y-4 overflow-y-auto pt-6">
              
              <!-- Clients -->
              <a href="index.php" class="flex h-11 w-11 items-center justify-center rounded-lg outline-none transition-colors duration-200 hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25" x-tooltip.placement.right="'Clients'">
                <svg version="1.0" xmlns="http://www.w3.org/2000/svg"
              width="512.000000pt" height="512.000000pt" viewBox="0 0 512.000000 512.000000"
              preserveAspectRatio="xMidYMid meet">

              <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
              fill="#000000" stroke="none">
              <path d="M3586 5090 c-219 -139 -386 -161 -771 -100 -110 17 -241 34 -291 37
              -171 11 -306 -32 -404 -127 -42 -41 -57 -49 -102 -55 -186 -25 -325 -120 -399
              -270 -60 -125 -72 -195 -77 -471 l-4 -250 -56 -12 c-151 -31 -240 -130 -250
              -277 -8 -128 43 -241 143 -317 50 -38 155 -78 204 -78 24 0 32 -8 61 -62 17
              -35 53 -94 78 -132 50 -76 206 -244 271 -291 l41 -30 -3 -145 -2 -144 -75 -18
              c-41 -10 -221 -52 -400 -94 -180 -42 -345 -87 -371 -99 -154 -78 -324 -307
              -399 -536 l-22 -66 -73 -5 c-131 -9 -226 -75 -284 -197 l-26 -56 0 -520 0
              -520 33 -67 c36 -73 87 -124 161 -160 l46 -23 1945 0 1945 0 57 28 c67 33 121
              90 157 166 l26 56 0 520 0 520 -26 56 c-57 121 -154 188 -283 197 l-72 4 -23
              67 c-82 238 -247 458 -400 536 -48 24 -76 31 -556 143 l-290 68 -2 145 -3 144
              41 30 c65 47 221 215 271 291 25 38 61 97 78 132 29 54 37 62 61 62 49 0 154
              40 204 78 116 88 172 249 135 384 -16 55 -70 129 -118 161 l-43 29 41 44 c55
              59 106 142 141 227 33 78 32 117 -3 141 -19 14 -20 19 -9 79 6 35 11 77 11 94
              0 24 5 32 25 37 52 13 60 86 25 235 -36 150 -128 313 -230 405 -49 44 -72 45
              -134 6z m-1336 -1142 c251 -123 570 -197 985 -228 83 -7 161 -14 173 -16 l24
              -5 -4 -162 c-4 -144 -7 -171 -31 -242 -125 -365 -518 -685 -841 -685 -215 0
              -481 154 -667 388 -72 89 -122 178 -162 285 -28 77 -31 93 -35 249 -4 186 -11
              169 73 183 107 18 243 118 320 234 22 33 42 59 45 58 3 -1 57 -28 120 -59z
              m-706 -575 c4 -24 5 -43 1 -43 -16 0 -83 41 -107 67 -96 101 -67 260 52 290
              l35 9 6 -140 c3 -78 9 -160 13 -183z m2144 284 c93 -86 56 -243 -71 -309 -22
              -10 -41 -18 -43 -15 -2 2 0 37 6 78 5 41 10 122 10 181 l0 106 38 -10 c20 -5
              48 -20 60 -31z m-1448 -1127 c21 -11 78 -31 127 -46 161 -48 324 -34 503 41
              33 14 62 25 65 25 3 0 5 -46 5 -102 l-1 -103 -189 -138 -190 -139 -190 139
              -189 138 -1 103 c0 64 4 102 10 102 6 0 28 -9 50 -20z m17 -426 c87 -64 159
              -117 160 -118 7 -6 -251 -137 -261 -133 -7 3 -69 77 -139 166 -125 159 -126
              161 -99 167 15 3 50 12 77 19 91 24 92 23 262 -101z m881 97 c41 -11 76 -22
              79 -25 6 -6 -236 -316 -253 -323 -9 -3 -268 128 -261 133 156 117 326 234 342
              234 11 0 53 -9 93 -19z m-471 -738 c3 -10 15 -28 26 -40 l20 -23 872 0 872 0
              44 -23 c27 -15 52 -38 66 -63 23 -39 23 -40 23 -538 0 -496 0 -498 -22 -538
              -12 -21 -38 -49 -58 -61 l-35 -22 -1904 -3 -1904 -2 -44 21 c-23 11 -53 35
              -65 52 l-23 32 0 520 0 520 23 32 c12 17 42 41 65 52 43 21 52 21 921 21 l877
              0 24 25 c14 13 25 31 25 40 0 12 16 15 95 15 82 0 97 -2 102 -17z"/>
              <path d="M2100 3563 c-19 -24 -21 -38 -18 -97 3 -57 8 -72 27 -87 30 -25 76
              -24 101 1 28 28 29 168 2 193 -30 27 -87 22 -112 -10z"/>
              <path d="M2907 3572 c-26 -29 -24 -165 3 -192 25 -25 71 -26 101 -1 19 15 24
              30 27 87 3 59 1 73 -18 97 -26 33 -87 38 -113 9z"/>
              <path d="M2396 3049 c-32 -25 -36 -79 -7 -108 54 -54 222 -67 308 -22 63 32
              73 96 20 135 -27 20 -29 20 -76 3 -60 -21 -107 -22 -154 -2 -48 20 -59 19 -91
              -6z"/>
              <path d="M3155 1115 l-25 -24 0 -316 0 -316 25 -24 c31 -32 74 -33 103 -2 20
              21 22 34 24 204 l3 181 125 -181 c69 -100 133 -189 143 -199 27 -29 91 -24
              116 8 20 26 21 38 21 336 l0 309 -25 24 c-31 32 -74 33 -103 2 -20 -21 -22
              -34 -24 -209 l-3 -186 -135 195 c-74 108 -144 202 -155 209 -29 21 -63 17 -90
              -11z"/>
              <path d="M1032 1119 c-76 -13 -142 -50 -200 -113 -63 -70 -87 -134 -87 -237 0
              -65 5 -85 33 -141 18 -36 51 -83 73 -103 127 -114 318 -125 432 -25 25 22 49
              50 52 61 14 43 -31 99 -80 99 -8 0 -29 -13 -48 -30 -65 -57 -125 -64 -203 -25
              -112 56 -144 193 -68 293 54 70 168 94 247 52 52 -28 91 -26 116 6 42 54 21
              98 -66 136 -69 30 -129 38 -201 27z"/>
              <path d="M1603 1115 c-16 -7 -33 -20 -37 -30 -3 -9 -6 -149 -6 -311 l0 -295
              25 -24 c23 -24 30 -25 143 -25 106 0 122 2 146 21 34 27 36 77 3 107 -19 18
              -35 22 -95 22 l-72 0 0 246 c0 141 -4 253 -10 264 -15 28 -61 40 -97 25z"/>
              <path d="M3980 1123 c-34 -13 -50 -37 -50 -73 0 -49 26 -72 90 -78 l50 -5 0
              -221 c0 -122 4 -236 10 -255 14 -51 56 -73 105 -55 39 15 45 53 45 297 l0 234
              52 5 c40 4 57 11 75 32 29 34 29 58 -1 93 l-24 28 -169 2 c-92 1 -175 -1 -183
              -4z"/>
              <path d="M2141 1094 c-20 -26 -21 -38 -21 -319 0 -281 1 -293 21 -319 26 -33
              79 -36 109 -6 19 19 20 33 20 325 0 292 -1 306 -20 325 -30 30 -83 27 -109 -6z"/>
              <path d="M2542 1113 c-7 -3 -19 -18 -27 -33 -12 -24 -15 -81 -15 -305 0 -288
              5 -323 45 -339 9 -3 78 -6 154 -6 131 0 139 1 159 23 29 31 29 77 -1 105 -20
              19 -35 22 -110 22 l-87 0 0 60 0 60 74 0 c90 0 102 4 122 42 13 25 13 35 3 59
              -16 41 -36 49 -123 49 l-76 0 0 60 0 60 88 0 c80 0 91 2 110 23 29 31 29 77
              -1 105 -22 21 -33 22 -163 21 -76 0 -145 -3 -152 -6z"/>
              </g>
              </svg>

              </a>

              <!-- API -->
              <a href="api.php" class="flex h-11 w-11 items-center justify-center rounded-lg outline-none transition-colors duration-200 hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25" x-tooltip.placement.right="'API And Device ID'">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6">
                <rect x="3" y="4" width="18" height="16" rx="2" ry="2"></rect>
                <line x1="8" y1="12" x2="16" y2="12"></line>
                <line x1="9" y1="8" x2="9" y2="16"></line>
                <line x1="15" y1="8" x2="15" y2="16"></line>
              </svg>

              </a>
              
              <!-- Add new Accounts -->
              <a href="addnew.php" class="flex h-11 w-11 items-center justify-center rounded-lg bg-primary/10 text-primary outline-none transition-colors duration-200 hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:bg-navy-600 dark:text-accent-light dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90" x-tooltip.placement.right="'Add New Client'">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
              </a>

              <!-- Available Slots -->
              <a href="available_slots.php" class="flex h-11 w-11 items-center justify-center rounded-lg outline-none transition-colors duration-200 hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25" x-tooltip.placement.right="'Available Slots'">
              <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M14.5 19.9815C16.0728 19.9415 17.1771 19.815 18 19.4151V20.9999C18 21.5522 17.5523 21.9999 17 21.9999H15.5C14.9477 21.9999 14.5 21.5522 14.5 20.9999V19.9815Z" fill="#1C274C"></path> <path d="M6 19.415C6.82289 19.815 7.9272 19.9415 9.5 19.9815V20.9999C9.5 21.5522 9.05228 21.9999 8.5 21.9999H7C6.44772 21.9999 6 21.5522 6 20.9999V19.415Z" fill="#1C274C"></path> <path opacity="0.5" fill-rule="evenodd" clip-rule="evenodd" d="M5.17157 3.17157C6.34315 2 8.22876 2 12 2C15.7712 2 17.6569 2 18.8284 3.17157C19.8915 4.23467 19.99 5.8857 19.9991 9L20 13C19.9909 16.1143 19.8915 17.7653 18.8284 18.8284C18.5862 19.0706 18.3136 19.2627 18 19.4151C17.1771 19.8151 16.0728 19.9415 14.5 19.9815C13.7729 19.9999 12.9458 20 12 20C11.0542 20 10.2271 20 9.5 19.9815C7.9272 19.9415 6.82289 19.815 6 19.415C5.68645 19.2626 5.41375 19.0706 5.17157 18.8284C4.10848 17.7653 4.00911 16.1143 4 13L4.00093 9C4.01004 5.8857 4.10848 4.23467 5.17157 3.17157Z" fill="#1C274C"></path> <path d="M17.75 16C17.75 15.5858 17.4142 15.25 17 15.25H15.5C15.0858 15.25 14.75 15.5858 14.75 16C14.75 16.4142 15.0858 16.75 15.5 16.75H17C17.4142 16.75 17.75 16.4142 17.75 16Z" fill="#1C274C"></path> <path d="M6.25 16C6.25 15.5858 6.58579 15.25 7 15.25H8.5C8.91421 15.25 9.25 15.5858 9.25 16C9.25 16.4142 8.91421 16.75 8.5 16.75H7C6.58579 16.75 6.25 16.4142 6.25 16Z" fill="#1C274C"></path> <path d="M5.5 9.5C5.5 10.9142 5.5 11.6213 5.93934 12.0607C6.37868 12.5 7.08579 12.5 8.5 12.5H15.5C16.9142 12.5 17.6213 12.5 18.0607 12.0607C18.5 11.6213 18.5 10.9142 18.5 9.5V6.99998C18.5 5.58578 18.5 4.87868 18.0607 4.43934C17.6213 4 16.9142 4 15.5 4H8.5C7.08579 4 6.37868 4 5.93934 4.43934C5.5 4.87868 5.5 5.58579 5.5 7V9.5Z" fill="#1C274C"></path> <path d="M2.4 11.8L4 13L4.00093 9H3C2.44772 9 2 9.44772 2 10V11C2 11.3148 2.14819 11.6111 2.4 11.8Z" fill="#1C274C"></path> <path d="M21 9H19.999L20 13L21.6 11.8C21.8518 11.6111 22 11.3148 22 11V10C22 9.44772 21.5522 9 21 9Z" fill="#1C274C"></path> </g></svg>  
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
                        <a href="../logout.php"> <button class="btn h-9 w-full space-x-2 bg-primary text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
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
                <img class="rounded-full" src="../images/logos/iPMS.svg" alt="avatar">
                <span class="absolute right-0 h-3.5 w-3.5 rounded-full border-2 border-white bg-success dark:border-navy-700"></span>
              </button>
            </div>

          </div>
        </div>
      </nav>
      <!-- Main Content Wrapper -->
      <main @click="$store.global.isSidebarExpanded = false" class="main-content w-full px-[var(--margin-x)] pb-8">
        <div class="py-5 text-center lg:py-6">
          <h3 class="mt-1 text-xl font-semibold text-slate-600 dark:text-navy-100">
            Add New API
          </h3>
        </div>
        <div class="ol-span-12 grid lg:col-span-8">
          <div class="card">
            <div class="border-b border-slate-200 p-4 dark:border-navy-500 sm:px-5">
              <div class="flex items-center space-x-2">
                <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-primary/10 p-1 text-primary dark:bg-accent-light/10 dark:text-accent-light">
                  <i class="fa-solid fa-layer-group"></i>
                </div>
                <h4 class="text-lg font-medium text-slate-700 dark:text-navy-100">
                  Client
                </h4>
              </div>
            </div>
            <div class="space-y-4 p-4 sm:p-5">
              <form action="apiadd.php" method="post">
                <label class="block">
                  <span>Client Name:</span>
                  <input
                          id="spotid-input"
                          class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                          placeholder="SLT"
                          type="text"
                          name="client"
                          value = "<?php echo $_GET['id']; ?>"
                          required
                  />
                </label>
                <br>
                <label class="block">
                  <span>API Key: <a href="https://generate-random.org/api-key-generator?count=1&length=64&type=mixed-numbers&prefix=" target="_blank"> Genarate API Key </a> </span>
                  <input
                          id="spotid-input"
                          class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                          placeholder="xxxxx"
                          type="text"
                          name="api"
                          required
                  />
                </label>
                <br>
                <div class="flex justify-center space-x-2" bis_skin_checked="1">
                  <button type="reset" class="btn min-w-[7rem] rounded-full border border-slate-300 font-medium text-slate-700 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-100 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                  <a href="index.php">Cancel </a> 
                  </button>
                  <button type="submit" class="btn min-w-[7rem] rounded-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                    Save
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </main>
    </div>
    <div id="x-teleport-target"></div>
    <script>
      window.addEventListener("DOMContentLoaded", () => Alpine.start());
    </script>
  </body>
</html>
