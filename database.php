<?php
session_start();
if (!isset($_SESSION['appuser'])) {
    header("Location: login.php");
    die();
}

?>

<!DOCTYPE html>
<html>
    <link rel="stylesheet" type="text/css" href="CSS/mystyle.css">
    <head>
        <title>Database</title>
    </head>
    <body class = "bg">
        <a class = "button" href = "logout.php">Logout</a>
        <h3 class = "shadow">Database</h3>
        <ul class = "nav">
            <li><a href="homepage.php">Home</a></li>
            <li><a class = ".activepage" href="database.html">Database</a></li>
 
        </ul>
    </body>
</html>