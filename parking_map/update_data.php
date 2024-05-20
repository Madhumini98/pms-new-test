<!DOCTYPE html>
<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            setInterval(function() {
                $("#loadData").load("index-copy.php");
            }, 30000);
        });
    </script>
</head>
<body>
    <div id="loadData"></div>
</body>
</html>





         


</body>



</html>