<?php
require 'connection.php';

//Prepare then execute SELECT statement to avoid SQL injection
$preparedStatement =$dbConnection->prepare('SELECT * FROM stock ');
$preparedStatement->execute(array());

$nameData = array();
$qtyData = array();
//Takes useful data from SELECT statement and puts it in relevant array
foreach($preparedStatement as $row) {
        array_push($nameData, $row['name']);
        array_push($qtyData, $row['quantity']);
    }
//combine both lists to pass back in single echo. Will be unpacked in calling function
$combinedData = array_merge($nameData, $qtyData);
//JSON encoded so can be returned easily as an array
echo json_encode($combinedData ) ;

?>
