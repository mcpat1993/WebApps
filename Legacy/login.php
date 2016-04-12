<?php
session_start();
//if(isset($_SESSION["error"]))
//{
//	echo $_SESSION["error"];
//}
//unset($_SESSION["error"]);
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
	<?php	if(isset($_SESSION["logoutmessage"])){
				echo "<font color=\"green\">" . $_SESSION["logoutmessage"] . "</font><br>";
			}
			unset($_SESSION["logoutmessage"]);
			?>
	<h1>Welcome to My Signup Home</h1>
	Please Log in
	<form action="process.php" method="post">
    	Username: <input type="text" name="username"><br>
    	Password: <input type="text" name="password"><br>
		<?php
		if(isset($_SESSION["error"])){
			echo "<font color='red'>" . $_SESSION["error"] . "</font><br>";
		}
		unset($_SESSION["error"]);?>
    	<input type="submit" value="Login">
	</form><br><br>
	Register
	<form action="register.php" method="post">
		Username: <input type="text" name="username"><br>
		Password: <input type="text" name="password"><br>
		First Name: <input type="text" name="firstname"><br>
		Last Name: <input type="text" name="lastname"><br>
		Teacher: <input type="radio" name="permission" value="1">
		Student: <input type="radio" name="permission" value="0"><br>
		<?php
		if(isset($_SESSION["registererror"])){
			echo "<font color='red'>" . $_SESSION["registererror"] . "</font><br>";
		}
		unset($_SESSION["registererror"]);
		if(isset($_SESSION["registermessage"])){
			echo "<font color='green'>" . $_SESSION["registermessage"] . "</font><br>";
		}
		unset($_SESSION["registermessage"]);?>
    	<input type="submit" value="Register User">
	</form>
	</fieldset>
</body>
</html>