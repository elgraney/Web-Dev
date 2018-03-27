<?php

require "connection.php";

$username = $_REQUEST["username"];
$password = $_REQUEST["psw"];
$repeatPassword =$_REQUEST["psw-repeat"];
if (preg_match("^[0-9A-Za-z_]+$^", $username) == 0) {
    echo "<p>Username contains invalid characters</p>";
    return;
}
if (preg_match("^[0-9A-Za-z_]+$^", $password) == 0) {
    echo "<p>Password contains invalid characters</p>";
    return;
}
if ($password != $repeatPassword ){
  echo "<p>Passwords do not match</p>";
  return;
}

$salt = random_bytes ( 10 );
$password = $password;

$password = md5($salt . $password);

$preparedStatement = $dbConnection->prepare('INSERT INTO users (username, password, salt) VALUES (:username, :password , :salt)');
$preparedStatement->execute(array('username' => $username, 'password' =>$password, 'salt' => $salt));


?>
