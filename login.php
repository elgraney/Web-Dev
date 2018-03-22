<?php

session_start();


if ( isset($_SESSION['appuser']))
{
  header('Location: homepage.php');
}

else if ( isset($_SESSION['apperror'] ))
{
  $error = $_SESSION['apperror'] ;
  //Remove session variables
  session_unset();
  // destroy the session
  session_destroy();
}

 ?>


<!DOCTYPE html>
<html>
  <head>
    <link href="CSS/loginstyle.css" rel='stylesheet' type='text/css'/>
    <meta name="viewport" content="width=device-width, user-scalable=no"/>
    <title>Login Page</title>
  </head>

  <body>
    <center>

      <div class = "title">
        <div id = "head">Video Game Stock Viewer</div>
        <div id = "sub_head">Sign in to continue to the stock viewer</div>
      </div>

      <div id = "parent">
        <form id= "form_login" name="loginForm" action="/utils/auth.php" method="post">
          <input type="text" name="username" value="" placeholder = "Enter Username" required style= "width:270px; height:42px; border: solid 1px #c2c4c6; font-size:16px; padding-left:8px;">

          <input type="password" name="password" value="" placeholder = "Enter Password" required style= "width:270px; height:42px; border: solid 1px #c2c4c6; font-size:16px; padding-left:8px;">

          <input type="submit" id="submit_button" value="Submit">
        </form>
      </div>

      <div id = "new_account">
        <a href='placeholder'/>Create account</a>
      </div>

    </center>
  </body>
</html>


<?php

/*
//Password received from a user
$user_input = 'webApp01' ;

//Generate our randdom Salt
$rand = openssl_random_pseudo_bytes(36);
$salt = '$2a$10$1qAz2wSx3eDc4rFv5tGb5e4jVuld5/KF2Kpy.B8D2XoC031sReFGi' . strtr(base64_encode($rand), array('_' => '.', '~' => '/'));

//This is the hashed password which would be stored in our db
$hashed_password = crypt('webApp01', $salt);

//Check to see if our password is equal to our user input
if ($hashed_password === crypt($user_input, $hashed_password))
{
  echo "match" ;
}

else
{
  echo "no match" ;
}




function hash_equals($str1, $str2)
    {
        if(strlen($str1) != strlen($str2))
        {
            return false;
        }
        else
        {
            $res = $str1 ^ $str2;
            $ret = 0;
            for($i = strlen($res) - 1; $i >= 0; $i--)
            {
                $ret |= ord($res[$i]);
            }
            return !$ret;
        }
    }
    */
?>
