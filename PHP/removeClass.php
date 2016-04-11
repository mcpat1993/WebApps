<?php
	session_start();
	
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
	//delete class from classes table in db
	$classtodelete = $_POST["classtodelete"];
	$sql = "DELETE FROM `classes` WHERE `name`='" . $classtodelete . "'";
	$result = $conn->query($sql);
	
	$sql = "UPDATE `users` SET `class1`=NULL WHERE `class1`='" . $classtodelete . "'";
	$result = $conn->query($sql);
	
	$sql = "UPDATE `users` SET `class2`=NULL WHERE `class2`='" . $classtodelete . "'";
	$result = $conn->query($sql);
	
	$sql = "UPDATE `users` SET `class3`=NULL WHERE `class3`='" . $classtodelete . "'";
	$result = $conn->query($sql);
?>