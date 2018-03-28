<?php
//try to set up a connection to the database using PDO
try {
  $dbConnection = new PDO('mysql:dbname=videogamesdatabase;host=localhost;charset=utf8', 'root', '');
  //set up connection so that SQL statements can be prepared properly before execution
  $dbConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
//if the connection fails, return error
catch(PDOException $e)
    {
    die("Connection failed: " . $e->getMessage());
    }
 ?>
