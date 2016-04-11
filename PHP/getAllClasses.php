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
	$sql = "SELECT * FROM `classes`";
	$result = $conn->query($sql);
	$classes = [];
	for($x=0;$x<$result->num_rows;$x++)
	{
		array_push($classes, mysqli_fetch_assoc($result));
	}
	echo json_encode($classes);
?>