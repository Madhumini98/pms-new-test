<?php
// session_start();

// if (!isset($_SESSION['login'])){
//   header("Location: ../loginform.php");
// }
// else{
//   if ($_SESSION['login'] == 'False'){
//     header("Location: ../loginform.php");
//   }
//   if ($_SESSION['role'] != 'sadmin'){
//     header("Location: ../loginform.php");
//   }
// }


// include 'conn.php';
// $sql = "SELECT * FROM `clients`;";
// $result = mysqli_query($link, $sql);
// $row = mysqli_fetch_all($result);
// $json = json_encode($row);

// connect to database
$dbname1 = 'pms-ml-clients';
$link1 = mysqli_connect('localhost', 'root', '', $dbname1);

// Check connection
if (!$link1) {
  die("Connection failed: " . mysqli_connect_error());
}

// get data from database
$sql1 = "SELECT * FROM `users`;";
$result1 = mysqli_query($link1, $sql1);
$row1 = mysqli_fetch_all($result1);
$json1 = json_encode($row1);


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
  <link href="./assets/css/style.css" rel="stylesheet" />
  <link rel="stylesheet" href="./css/app.css">

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





</head>

<body>


  <!-- Page Wrapper -->
  <div id="root" class="min-h-100vh flex grow bg-slate-50 dark:bg-navy-900 w-screen">
    <!-- Main Content Wrapper -->
    <main class="main-content w-full px-[var(--margin-x)] pb-8 relative z-[10000]>

      <div>
        <div x-teleport=" #x-teleport-target>
      <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5 border border-gray-300 rounded-lg" x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300" x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
        <div class="relative max-w-lg rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5" x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
          <svg xmlns="http://www.w3.org/2000/svg" class="inline h-28 w-28 text-warning" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2L2 22h20L12 2zm0 15.5v-3M12 16v-2" />
            <circle cx="12" cy="19" r="1.5" fill="currentColor" stroke="none" />
          </svg>


          <div class="mt-4">
            <h2 class="text-2xl text-slate-700 dark:text-navy-100">
              Are you sure for delete : <?php echo $_GET['uname']; ?>
            </h2>
            <a href="index.php"> <button @click="showModal = false" class="btn mt-6 bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                No
              </button></a>
            <a href="delete_company.php?uname=<?php echo $_GET['uname']; ?>"> <button @click="showModal = false" class="btn mt-6 bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                Delete
              </button></a>
          </div>
        </div>
      </div>
  </div>
  </div>
  </main>
  </div>

</body>

</html>