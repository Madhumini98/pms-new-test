<?php
include 'sesion_start.php';
include 'req.php';
include 'connStat.php';
$_SESSION['client'] = $client;


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
  while ($row = mysqli_fetch_assoc($result)) {
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
  while ($row = mysqli_fetch_assoc($result)) {
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


  <!-- <script>
        fetch('server_log/parking_system.log')  // Replace with the correct path to your log file
            .then(response => response.text())
            .then(logContent => {
                console.log(logContent);
            })
            .catch(error => {
                console.error('Error fetching and logging the log file:', error);
            });
    </script> -->
  <script>
    // Use JavaScript to log the PHP variable to the browser's console
    console.log("<?php echo $client; ?>");
  </script>
  <script src="https://unpkg.com/gridjs/dist/gridjs.umd.js"></script>

  <script>
    new gridjs.Grid({
      columns: [
        "Email", "Role", "User Name", "Password",
        {
          name: "Reset Password",
          formatter: (_, row) =>
            gridjs.html(
              `<a href="edituser.php?uname=${row.cells[2].data}&role=${row.cells[1].data}" target="_blank"> <button type="button" class="btn btn-secondary">
                        <i class="fas fa-edit"></i>
                        </button></a>`
            ),
        },
        {
          name: "Remove Account",
            formatter: (_, row) =>
            gridjs.html(
              `<a href="confirm_delete.php?uname=${row.cells[2].data}"> <button type="button" class="btn btn-secondary">
                    <i class="fas fa-trash-alt"></i>
                    </button></a>`
            ),
        }
      ],
      sort: true,
      search: false,
      pagination: true,
      data: <?php echo $json_acc; ?>,
      style: {
        th: {
          "text-align": "center",
        },
        td: {
          "text-align": "center",
        },
      },
    }).render(document.getElementById("wrapper"));
  </script>


</body>

</html>

<?php

if (isset($_SESSION['msg'])) {
  echo '<script>swal("Welcome", "Login success.", "success");</script>';
  unset($_SESSION['msg']);
}

if (isset($_SESSION['reset_user_pass'])) {
  if ($_SESSION['reset_user_pass'] == 'success') {
    echo '<script>swal("Success", "Password Reset success.", "success");</script>';
  }
  if ($_SESSION['reset_user_pass'] == 'error') {
    echo '<script>swal("Fail", "Password Reset fail.", "error");</script>';
  }
  unset($_SESSION['reset_user_pass']);
}
