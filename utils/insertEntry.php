<?php


require "connection.php";

$name = $_REQUEST["name"];
$qty = $_REQUEST["qty"];
$sql ="INSERT INTO stock(name, quantity) VALUES ('$name', '$qty')";
$result = $conn->query($sql);
$conn->close();

?>
