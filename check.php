<?php
session_start();
$session = $_SESSION['appuser'] ;
if ( isset($session) && $session != '')
{
  $loggedIn = "<a href='logout.php'>Logout ". $session ."</a>" ;
}

else
{
header('Location: https://students.emps.ex.ac.uk/EnterYourUsername/workshop7/web_app/login.php');
}

 ?>
