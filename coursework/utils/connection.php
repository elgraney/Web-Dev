<?php
//try to set up a connection to the database using PDO
try {
  $dbConnection = new PDO('mysql:dbname=mac234;host=emps-sql.ex.ac.uk;charset=utf8', 'mac234', 'mac234');
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
