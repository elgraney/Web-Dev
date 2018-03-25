<?php


require "connection.php";

$id = $_REQUEST["id"];
$qty = $_REQUEST["qty"];
$sql ="UPDATE stock SET quantity= $qty WHERE id = $id";
$result = $conn->query($sql);
$conn->close();

?>
