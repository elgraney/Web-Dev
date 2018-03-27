<?php
session_start();

require('connection.php') ;


if ( isset ($_POST["username"]) && isset($_POST["password"]))
{
  $username = htmlentities($_POST["username"]) ;
  $password = htmlentities($_POST["password"]) ;
  validateUser($dbConnection, $username, $password) ;

}
else
{
  echo "You have not entered a valid username or password" ;
  header('Location: ../login.php');
}


function validateUser($dbConnection, $username, $password)
{
  $preparedStatement =$dbConnection->prepare('SELECT * FROM users WHERE username = :username ');
  $preparedStatement->execute(array('username'=>$username));

  //SERIOUS BUG WITH WRONG USERNAMES NOT WORKING
  //die('pre if');
  if(!empty($preparedStatement)){
    //die('pass if');
    echo 'what?';
    foreach ($preparedStatement as $row)
    {

        $hashed_password = $row["password"];
        if($row["salt"]){
          $password = $row["salt"] . $password;
        }

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
    else{
      $error = "Invalid Login credentials" ;
      $_SESSION["apperror"] = $error ;

  }

}

?>
