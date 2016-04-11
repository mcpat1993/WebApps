<?php
	session_start();
	if(isset($_POST["username"]))
	{
		$username = $_POST["username"];
		//echo "username: " . $username;
	}
	$password='';
	if(isset($_POST["password"]))
	{
		$password = $_POST["password"];
	}
	
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
	$selectedClass = $_POST["selectedClass"];
	
	$returnarr = array();
	
	$sql = "SELECT `description` FROM `classes` WHERE `name`='" . $selectedClass . "'";
	$result = $conn->query($sql);
	$description = mysqli_fetch_assoc($result);
	array_push($returnarr, $description);
	
	//query to get all students who have the couse name in at least one of their slots
	$sql = "SELECT * FROM `users` WHERE (`class1`='" . $selectedClass . "' OR `class2`='" . $selectedClass . "' OR `class3`='" . $selectedClass . "') AND `permission`!='1'";
	$result = $conn->query($sql);
	
	while( $row = mysqli_fetch_assoc( $result)){
		array_push($returnarr, $row); // Inside while loop
	}
	echo json_encode($returnarr);
	//echo '{"numStudents":'. $result->num_rows . ', ';
	/*for($x=0;$x<$result->num_rows;$x++)
	{
		$arr = mysqli_fetch_assoc($result);
		echo '"' . $x . 'f": "' . $arr['firstname'] . '", "' . $x . 'l": "' . $arr['lastname'] . '"';
		//if($x !== $result->num_rows - 1)
		//{
		//	echo ",";
		//}
		echo ",";
	}*/
	/*$sql = "SELECT `description` FROM `classes` WHERE `name`='" . $selectedClass . "'";
	$result = $conn->query($sql);
	$arr = mysqli_fetch_assoc($result);
	echo '"description":"' . $arr["description"] . '"}';*/
?>