<?php
session_start();

require('connection.php') ;


if ( isset ($_POST["username"]) && isset($_POST["password"]))
{
  $username = htmlentities($_POST["username"]) ;
  $password = htmlentities($_POST["password"]) ;
  validateUser($conn, $username, $password) ;

}
else
{
  echo "You have not entered a valid username or password" ;
  header('Location: ../login.php');
}


function validateUser($conn, $username, $password)
{
  //Basic SQL protection
  $username = $conn->real_escape_string($username);

  $sql ="SELECT * FROM users WHERE username = '$username'";

  $result = $conn->query($sql);
  if ($result->num_rows > 0)
  {
    // output data of each row
    while($row = $result->fetch_assoc())
    {
        $hashed_password = $row["password"];

        //Check to see if our password is equal to our user input
        if ($hashed_password === hash("md5", $password))
        {
          $_SESSION["appuser"] = $username ; // Initializing Session
          //echo $_SESSION["appuser"] ;
          header("Location: ../homepage.php");
          exit();
        }
        else
        {
          $error = "Invalid Login credentials" ;
          $_SESSION["apperror"] = $error ;
          header("Location: ../login.php");
        }
    }

  }
  else
  {
    $error = "Invalid Login credentials";
    $_SESSION["apperror"] = $error ;
    header("Location: ../login.php");
  }
  $conn->close();
}

?>
