<?php


require "connection.php";

$name = $_REQUEST["name"];
$qty = $_REQUEST["qty"];


$preparedStatement = $dbConnection->prepare('INSERT INTO stock (name, quantity) VALUES (:name, :quantity)');
$preparedStatement->execute(array('name' => $name, 'quantity' =>$qty));


$preparedStatement =$dbConnection->prepare('SELECT * FROM stock WHERE name = :name ');
$preparedStatement->execute(array('name'=>$name));

foreach($preparedStatement as $row) {
        $id = $row['id'];
    }
echo $id;
$conn->close();
?>
