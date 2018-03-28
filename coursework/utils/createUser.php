<?php

require "connection.php";

//retrieves data passed by ajax POST call
$username = $_POST["username"];
$password = $_POST["psw"];
$repeatPassword =$_POST["psw-repeat"];

//immediately returns with error message if any of the ifs pass
//regular expressions to check for invalid usernames
if (preg_match("^[0-9A-Za-z_]+$^", $username) == 0) {
    echo "<p>Username contains invalid characters</p>";
    return;
}
if (preg_match("^[0-9A-Za-z_]+$^", $password) == 0) {
    echo "<p>Password contains invalid characters</p>";
    return;
}
//get all usernames from the database
$preparedStatement =$dbConnection->prepare('SELECT * FROM users ');
$preparedStatement->execute(array());

//check entered username does not match any existing usernames
foreach($preparedStatement as $row) {
  if($username === $row['username']){
    echo '<p>Username taken, please pick another</p>';
    return;
  }
}

if ($password != $repeatPassword ){
  echo "<p>Passwords do not match</p>";
  return;
}

//method for generating a salt string.
//generates a string of 32 character from the list of characters below (repeats allowed)
//limited to alphabetical and neumerical characters to avoid unexpected characters causing syntax errors
//still sufficient possibilties to be useful
$salt = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(32/strlen($x)) )),1,32);

//prepend the salt to the password then hash it
$password = md5($salt . $password);

//store username, password and salt in database in a new row
//Prepare then execute INSERT statement to avoid sql injection, even though invalid strings should've been caught. Can't be too careful
$preparedStatement = $dbConnection->prepare('INSERT INTO users (username, password, salt) VALUES (:username, :password , :salt)');
$preparedStatement->execute(array('username' => $username, 'password' =>$password, 'salt' => $salt));
?>
