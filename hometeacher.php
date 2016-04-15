<script src="myJS.js"></script>
</script>
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
<div align="right" class="mainmenu" href="CSS/homestyle.css" onclick="logout();">
	Logout
</div>
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="CSS/homestyle.css">
	<title>Document</title>
</head>
<body>
	<fieldset>
	<h1>Welcome to My Signup, <?= $_SESSION["username"]?></h1>
	<div id="displayCourses">Courses: <img src="img/add.ico" alt="Add" style="width:20px;height:20px;" onclick="javascript:showAddClassMenu()">
	<img src="img/drop.png" alt="Drop" style="width:20px;height:20px;" onclick="javascript:showDropClassMenu()">
		<ul id="classElements">
		</ul>
	</div>
	<div id="mainInfo">
	</div>
	</fieldset>
	<div id="notification" style="display: none;">
		<span class="dismiss"><a title="dismiss">X</a></span>
		<text id="text"></text>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script src="JS/professorPage.js"></script>
</body>
</html>

