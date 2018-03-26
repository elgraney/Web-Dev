<?php


require "connection.php";

$id = $_REQUEST["id"];

$sql ="DELETE FROM stock WHERE id = $id";
$result = $conn->query($sql);
$conn->close();

?>
