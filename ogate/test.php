<!DOCTYPE html>
<html>
<head>
  <title>Auto-Refresh Page Example</title>
  <script>
    // Function to refresh the page content
    function refreshPage() {
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          // Replace the current page content with the fetched content
          document.documentElement.innerHTML = this.responseText;
        }
      };
      xhttp.open("GET", window.location.href, true);
      xhttp.send();
    }
  
    // Set interval to refresh the page every 1 second (1000 milliseconds)
    setInterval(function() {
      refreshPage();
    }, 1000);
  </script>
</head>
<body>
  <h1>Auto-Refresh Page Exadsmple</h1>
  
  <!-- Page content -->
</body>
</html>
