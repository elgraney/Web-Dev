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
        <title>Home</title>
    </head>
    <body class = "bg">
        <a class = "button" href = "logout.php">Logout</a>
        <h1>Welcome</h1>
        <h2>Made by Joe Brett</h2>
        <ul class = "nav">
            <li><a class = ".activepage" href="homepage.php">Home</a></li>
            <li><a href="database.html">Database</a></li>
        </ul>    
        </p>
        
    </body>
</html>
