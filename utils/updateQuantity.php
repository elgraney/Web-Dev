<?php


require "connection.php";

$id = $_REQUEST["id"];
$qty = $_REQUEST["qty"];

$preparedStatement =$dbConnection->prepare('UPDATE stock SET quantity= :quantity WHERE id = :id');
$preparedStatement->execute(array('quantity'=>$qty, 'id'=>$id));


?>
