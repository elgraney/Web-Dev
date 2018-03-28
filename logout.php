<?php
//simple script to end a session when the logout button is pressed
session_start();
session_destroy();
//returns to login page
header("Location: login.php");
exit;
?>
