<?php
require "connection.php";

//get variables passed by ajax GET
$id = $_REQUEST["id"];
$qty = $_REQUEST["qty"];

//prepare then execute UPDATE statement to avoid SQL injection
$preparedStatement =$dbConnection->prepare('UPDATE stock SET quantity= :quantity WHERE id = :id');
$preparedStatement->execute(array('quantity'=>$qty, 'id'=>$id));


?>
