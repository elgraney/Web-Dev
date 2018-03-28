<?php
session_start();

require('connection.php') ;

//check if username and password are set
if ( isset ($_POST["username"]) && isset($_POST["password"]))
{
  //take username and password from POST call and convert to htmlentities so they are treated purely as strings
  $username = htmlentities($_POST["username"]) ;
  $password = htmlentities($_POST["password"]) ;
  //check username and password are valid
  validateUser($dbConnection, $username, $password) ;

}
else
{
  //return to login page with error
  echo "You have not entered a valid username or password" ;
  header('Location: ../login.php');
}


function validateUser($dbConnection, $username, $password)
{
  //try to find matches with username in the database
  //Prepare statement to avoid SQL injection, even though it shouldn't be a problem with html entities
  $preparedStatement =$dbConnection->prepare('SELECT * FROM users WHERE username = :username ');
  $preparedStatement->execute(array('username'=>$username));

  $result = $preparedStatement->fetchAll();
  //check if any results are returned
  if($result){
    //loops through each result (should only be 1, because createUser prevents duplicated usernames)
    foreach ($result as $row)
    {
        //retrieves the hashed password from the database
        $hashed_password = $row["password"];
        if($row["salt"]){ //needed because test accounts don't have salts
			       $salt = $row["salt"];
             //prepend salt to password
             $password = ($salt . $password);

        }
        //stored password (already salted and hased) is equal to our user input combined with salt and hashed
        if ($hashed_password === md5($password))
        {
          $_SESSION["appuser"] = $username ; // Initializing Session
          //go to homepage
          header("Location: ../homepage.php");
          exit();
        }
        else
        {
          //return to login page with error
          $error = "Invalid Login credentials" ;
          $_SESSION["apperror"] = $error ;
          header("Location: ../login.php");
        }
    }
  }

    else{
      //return to login page with error
      $error = "Invalid Login credentials" ;
      $_SESSION["apperror"] = $error ;
		header("Location: ../login.php");
    }

  
}

?>
