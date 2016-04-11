<?php
	session_start();
	$username ='';
	if(isset($_POST["username"]))
	{
		$username = $_POST["username"];
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
	//setting students class to the class name
	$sql = "SELECT `class1`,`class2`,`class3` FROM `users` WHERE `username`='" . $username . "'";
	$result = $conn->query($sql);
	$classarr = mysqli_fetch_assoc($result);
	$classname = $_POST["classtoadd"];
	if($classarr["class1"] === NULL)
	{//add to class 1
		$sql = "UPDATE `users` SET `class1`='" . $classname . "' WHERE `username`='" . $username . "'";
		$result = $conn->query($sql);
	}else
	{
		if($classarr["class2"] === NULL)
		{
			//add to class2
			$sql = "UPDATE `users` SET `class2`='" . $classname . "' WHERE `username`='" . $username . "'";
			$result = $conn->query($sql);
		}else
		{
			if($classarr["class3"] === NULL)
			{
				//add to class3
				$sql = "UPDATE `users` SET `class3`='" . $classname . "' WHERE `username`='" . $username . "'";
				$result = $conn->query($sql);
			}else
			{
				$error = array('error' => 'You cannot add any more classes!');
				echo json_encode($error);
			}
		}
	}
	
?>