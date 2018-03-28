<?php


require "connection.php";

//get id from ajax GET call
$id = $_REQUEST["id"];

//Prepare then execute DELETE statement to avoid SQL injection
$preparedStatement =$dbConnection->prepare('DELETE FROM stock WHERE id = :id ');
$preparedStatement->execute(array('id'=>$id));

?>
