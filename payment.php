<?php
include 'sesion_start.php';
include 'req.php';


$client = $_SESSION['client']; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {  
      
    // Connect to the iPMS-clients database
    $dbname = 'iPMS-clients';
    $link = mysqli_connect('localhost', 'root', '', $dbname);

    

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
  
  </head>

  <body x-data="" class="is-header-blur" x-bind="$store.global.documentBody">       
             
             
      <!-- Main Content Wrapper -->
      <main @click="$store.global.isSidebarExpanded = false" class="main-content w-full px-[var(--margin-x)] pb-8">
               
        <diV style="display: flex; justify-content: center; align-items: center; height: 100vh;">
           
            <div class="form-container">
              <h2>Payment Section</h2>
              <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="form-group">
                 <!-- <label for="vehicleNumber">Vehicle Number</label>
                  <input type="text" class="form-control" id="vehicleNumber" name="vehicleNumber" placeholder="Enter vehicle number">-->
                </div>
                <div class="form-group">
                  <label for="disable">Select Payment Option</label>
                  <select class="form-control" id="disable" name="disable">
                    <option value="enable">Enable</option>
                    <option value="disable">Disable</option>
                  </select>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Submit</button>
              </form>
            </div>
        </div> 
      </main>
    </div>
    <div id="x-teleport-target"></div>
    <script>
      window.addEventListener("DOMContentLoaded", () => Alpine.start());
    </script> 
    
    <script>
    if (<?php echo isset($_SESSION['edit']) ? 'true' : 'false'; ?>) {
        <?php if (isset($_SESSION['edit']) && $_SESSION['edit'] == 'success'): ?>
        swal("Success", "Payment mode updated successfully.", "success");
        <?php elseif (isset($_SESSION['edit']) && $_SESSION['edit'] == 'error'): ?>
        swal("Error", "Failed to update payment mode.", "error");
        <?php endif; ?>
        <?php unset($_SESSION['edit']); ?>
    }
    </script>

    
  </body>
</html>


<?php
if (isset($_SESSION['edit'])){
    if ($_SESSION['edit'] == 'success') {
        echo '<script>swal("Success", "Work success.", "success");</script>';

    }    
    if ($_SESSION['edit'] == 'Error') {
        echo '<script>swal("Error", "Something wrong please try again.", "error");</script>';

    }
    unset($_SESSION['edit']);
}
?>



