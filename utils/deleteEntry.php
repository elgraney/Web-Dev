<?php


require "connection.php";

$id = $_REQUEST["id"];

$preparedStatement =$dbConnection->prepare('DELETE FROM stock WHERE id = :id ');
$preparedStatement->execute(array('id'=>$id));

?>
