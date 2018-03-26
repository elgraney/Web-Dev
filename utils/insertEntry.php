<?php


require "connection.php";

$name = $_REQUEST["name"];
$qty = $_REQUEST["qty"];
$sql ="INSERT INTO stock(name, quantity) VALUES ('$name', '$qty')";
$conn->query($sql);

$sql ="SELECT * FROM stock WHERE name = '$name' ";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()) {
        $id = $row['id'];
    }
echo $id;
$conn->close();
?>
