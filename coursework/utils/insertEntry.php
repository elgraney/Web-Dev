<?php


require "connection.php";

//get arguments from ajax GET call
$name = $_REQUEST["name"];
$qty = $_REQUEST["qty"];

//Prepare then execute INSERT statement to avoid SQL injection
$preparedStatement = $dbConnection->prepare('INSERT INTO stock (name, quantity) VALUES (:name, :quantity)');
$preparedStatement->execute(array('name' => $name, 'quantity' =>$qty));

//Database autoincrements id, so id must be retrieved using known data
$preparedStatement =$dbConnection->prepare('SELECT * FROM stock WHERE name = :name ');
$preparedStatement->execute(array('name'=>$name));

//loops through every returned row.
//guaranteed to get the right id, even if there are multiple entries with the same name because the item we are looking for was entered most recently
foreach($preparedStatement as $row) {
        //overwrites id until $id is the id of the last matching row
        $id = $row['id'];
    }
echo $id;

?>
