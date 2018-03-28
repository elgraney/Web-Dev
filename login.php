<?php
//starts a session
session_start();

//if someone is already logged in
if ( isset($_SESSION['appuser']))
{ //go straight to the main page
  header('Location: homepage.php');
}

//nobody is logged in
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

    <link href="CSS/loginstyle2.css" rel='stylesheet' type='text/css'/>
    <link href="CSS/modal.css" rel='stylesheet' type='text/css'/>
    <meta name="viewport" content="width=device-width, user-scalable=no"/>

    <title>Login Page</title>
  </head>

  <body>
    <!-- Sets up login window based on google's gmail login page. -->
    <center>
      <!-- Sets the headings at the top of the page. -->
      <div class = "title">
        <div id = "head">Video Game Stock Viewer</div>
        <div id = "sub_head">Sign in to continue to the stock viewer</div>
      </div>


      <!-- form asks for username and password user inputs. -->
      <div id = "parent">
        <form id= "form_login" name="loginForm" action="/utils/auth.php" method="post">
          <!-- Form is fixed size, with fixed style input boxes. -->
          <input type="text" name="username" value="" placeholder = "Enter Username" required style= "width:270px; height:42px; border: solid 1px #c2c4c6; font-size:16px; padding-left:8px;">

          <input type="password" name="password" value="" placeholder = "Enter Password" required style= "width:270px; height:42px; border: solid 1px #c2c4c6; font-size:16px; padding-left:8px;">

			<?php
      //if an error has been returned form auth.php
			if ( isset($error)){
        //display error below input boxes
				echo $error;
			}
			else {
        //display new line so that container height does not change if an input is displayed
				echo "<br><br>";
			}
			?>

		  <input type="submit" id="submit_button" value="Submit">

        </form>
      </div>
    </center>
  </body>
</html>
