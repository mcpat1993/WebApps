<?php
	session_start();
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
	//sql to check if username and pw are correc
	$sql = "SELECT `class1`,`class2`,`class3` FROM `users` WHERE `username`='" . $username . "'";
	$result = $conn->query($sql);
	while($data = mysqli_fetch_assoc($result))
	{
		$row = $data;
	}
	echo json_encode($row);
?>