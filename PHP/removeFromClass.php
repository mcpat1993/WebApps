<?php
	session_start();
	$classname = $_POST["classname"];
	$username = $_SESSION["username"];
	
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
	
	$sql = "UPDATE `users` SET `class1`=NULL WHERE `class1`='" . $classname . "' AND `username`='" . $username . "'";
	$result = $conn->query($sql);
	
	$sql = "UPDATE `users` SET `class2`=NULL WHERE `class2`='" . $classname . "' AND `username`='" . $username . "'";
	$result = $conn->query($sql);
	
	$sql = "UPDATE `users` SET `class3`=NULL WHERE `class3`='" . $classname . "' AND `username`='" . $username . "'";
	$result = $conn->query($sql);
?>