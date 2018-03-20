<html>

<head>
<title>Video Games Database</title>
</head>

<body>
<?php

$user = "admin"; 
$password = "pass"; 

if($_POST["name"]==$user) {
	if($_POST["pass"]==$password) {
		#If username and password is correct
		//echo "Logged in as <b>$user!</b>";
		header("Location: homepage.html");
		exit();
	 }else{
		#If username is correct but password isn't
		echo "The password you entered was <b>invalid!</b>";
	}
 }else{
	if($_POST["pass"]==$password) {
		#The username was wrong but the password wasn't
		echo "The username you provided was <b>invalid!</b>";
	 }else{
		#The username and password were both wrong
		echo "The username and password you provided was <b>invalid!</b>";
	}
}

?>


</body>

</html>