<?php
session_start();
if(isset($_SESSION["error"]))
{
	echo $_SESSION["error"];
}
unset($_SESSION["error"]);
//session_start();
?>
<!DOCTYPE html>
<html5>

<head>
	<link rel="stylesheet" type="text/css" href="homestyle.css">
  	<title>Better Pitt Course Signup System</title>
</head>

<body>
  <fieldset>
  <h1>Welcome to My Signup Home</h1>
 	Please Log in
  	<form action="process.php" method="post">
      	Username: <input type="text" name="username"><br>
      	Password: <input type="text" name="password"><br>
    	<input type="submit" value="Login">
  	</form>
  </fieldset>
</body>
</html>