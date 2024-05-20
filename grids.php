<?php
include 'conn.php';
$sql = "SELECT * FROM `tolls`;";
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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <link
          href="https://unpkg.com/gridjs/dist/theme/mermaid.min.css"
          rel="stylesheet"
  />
  <title>Grid.js Hello World</title>
</head>
<body>
<div id="wrapper"></div>

<script src="https://unpkg.com/gridjs/dist/gridjs.umd.js"></script>

<script>
  new gridjs.Grid({
    columns: ["Fee ID", "Fee"],
    search: true,
    sort: true,
    pagination: true,
    data: <?php echo $json; ?>
  }).render(document.getElementById("wrapper"));
</script>
</body>
</html>
