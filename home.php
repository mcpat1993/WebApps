<?php
session_start();
if(!isset($_SESSION["loggedin"]))
{
  $_SESSION["error"] = "You have not logged in. Please log in first";
  header("Location: login.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="homestyle.css">
	<title>Document</title>
</head>
<body>
	<fieldset>
  		<h1>Welcome to My Signup, <?= $_SESSION["username"]?></h1>
 	</fieldset>
</body>
</html>