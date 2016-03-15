<?php
	session_start();
	$username;
	$password;
	$firstname;
	$lastname;
	$permission;
	if(isset($_POST["username"]))
	{
		$username = $_POST["username"];
	}else
	{
		$_SESSION["registererror"]="No Username entered";
		header("Location: login.php");
		exit();
	}
	if(isset($_POST["password"]))
	{
		$password = $_POST["password"];
	}else
	{
		$_SESSION["registererror"]="No Password entered";
		header("Location: login.php");
		exit();
	}
	if(isset($_POST["firstname"]))
	{
		$firstname = $_POST["firstname"];
	}else
	{
		$_SESSION["registererror"]="No First Name entered";
		header("Location: login.php");
		exit();
	}
	if(isset($_POST["lastname"]))
	{
		$lastname = $_POST["lastname"];
	}else
	{
		$_SESSION["registererror"]="No Last Name entered";
		header("Location: login.php");
		exit();
	}
	if(isset($_POST["permission"]))
	{
		$permission = $_POST["permission"];
	}else
	{
		$_SESSION["registererror"]="No Permission value entered!";
		header("Location: login.php");
		exit();
	}
	echo $username . " " . $password . " " . $firstname . " " . $lastname . " " . $permission;
	$servername = "localhost";
	$dbusername = "root";
	$dbpassword = "";
	$dbname = "webapps";
	//create connection with database
	$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
	//confirming that connection was made
	if($conn->connect_error)
	{
		die("God Damn connection failed: ". $conn->connect_error);
	}
	//sql to check if username and pw are correc
	$sql = "INSERT INTO `users`(`firstname`, `lastname`, `username`, `password`, `class1`, `class2`, `class3`, `permission`) VALUES ('".$firstname."','".$lastname."','".$username."','".$password."',NULL,NULL,NULL,'".$permission."')";
	echo $sql;
	$result = $conn->query($sql);
	$_SESSION["registermessage"] = "New user registered!";
	header("Location: login.php");
	//echo "should have redirected and not reached this line <br>";
	exit();
?>