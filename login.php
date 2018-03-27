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
    <link href="CSS/loginstyle1.css" rel='stylesheet' type='text/css'/>
    <link href="CSS/modal.css" rel='stylesheet' type='text/css'/>
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

			<?php
			if ( isset($error)){
				echo $error;
			}
			else {
				echo "<br><br>";
			}
			?>

		  <input type="submit" id="submit_button" value="Submit">

        </form>

      </div>



    </center>
  </body>
</html>
