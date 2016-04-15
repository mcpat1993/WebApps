<?php
	session_start();
	$classname = $_POST["classname"];
	$username= $_SESSION["username"];
	
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
	//This portion will check to make sure that the class isn't full
	$sql = "SELECT * FROM `users` WHERE `class1`='" . $classname . "' OR `class2`='" . $classname . "' OR `class3`='" . $classname . "'";
	$result = $conn->query($sql);
	$currentTotal = $result->num_rows - 1;
	$sql = "SELECT `max_students` FROM `classes` WHERE `name`='" . $classname . "'";
	$result = $conn->query($sql);
	$max = mysqli_fetch_assoc($result)["max_students"];
	if($currentTotal<$max)
	{
		//update teachers classes in db
		$sql = "SELECT `class1` FROM `users` WHERE `username`='" . $username . "'";
		$result = $conn->query($sql);
		if(mysqli_fetch_assoc($result)["class1"] === NULL)
		{//add to class 1
			$sql = "UPDATE `users` SET `class1`='" . $classname . "' WHERE `username`='" . $username . "'";
			$result = $conn->query($sql);
			$returnarr = array('result' => 'Class added!');
			echo json_encode($returnarr);
		}else
		{
			$_SESSION["class1"] = mysqli_fetch_assoc($result)["class1"];
			$sql = "SELECT `class2` FROM `users` WHERE `username`='" . $username . "'";
			$result = $conn->query($sql);
			if(mysqli_fetch_assoc($result)["class2"] === NULL)
			{
				//add to class2
				$sql = "UPDATE `users` SET `class2`='" . $classname . "' WHERE `username`='" . $username . "'";
				$result = $conn->query($sql);
				$returnarr = array('result' => 'Class added!');
				echo json_encode($returnarr);
			}else
			{
				$_SESSION["class2"] = mysqli_fetch_assoc($result)["class2"];
				$sql = "SELECT `class3` FROM `users` WHERE `username`='" . $username . "'";
				$result = $conn->query($sql);
				if(mysqli_fetch_assoc($result)["class3"] === NULL)
				{
					//add to class3
					$sql = "UPDATE `users` SET `class3`='" . $classname . "' WHERE `username`='" . $username . "'";
					$result = $conn->query($sql);
					$returnarr = array('result' => 'Class added!');
					echo json_encode($returnarr);
				}else
				{
					$somevar = 'You cannot add any more classes!';
					$returnarr = array('result' => 'You cannot add any more classes!');
					echo json_encode($returnarr);
				}
			}
		}
	}else
	{
		$returnarr = array('result' => 'Class is already too full for your ass!');
		echo json_encode($returnarr);
	}
?>