<?php

$servername = "localhost";
$username = "root";
$password = "Hello There";
$database = "videogamesdatabase" ;

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error)
{
    die("Connection failed: " . $conn->connect_error);
}
else
{
  //echo "Connected successfully <br />";
}


?>
