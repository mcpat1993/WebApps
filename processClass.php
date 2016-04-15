<?php
	session_start();
	$classname = $_POST["classname"];
	$classsize= $_POST["classsize"];
	$classdescription = $_POST["classdescription"];
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
	//sql to class entered already exists
	$sql = "SELECT * FROM `classes` WHERE `name` = '" . $classname . "'";
	$result = $conn->query($sql);
	$returnar;
	if($result->num_rows > 0)
	{
		//there already exists the class trying to be made
		$returnarr = array('result' => 'This class already exists');
		echo json_encode($returnarr);
	}else
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
			//class doesn't exist yet so ADD it
			$sql = "INSERT INTO `classes` (`name`, `max_students`, `teacher`, `description`) VALUES ('" . $classname . "', '" . $classsize . "', '" . $username . "', '" . $classdescription . "')";
			$result = $conn->query($sql);
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
				//class doesn't exist yet so ADD it
				$sql = "INSERT INTO `classes` (`name`, `max_students`, `teacher`, `description`) VALUES ('" . $classname . "', '" . $classsize . "', '" . $username . "', '" . $classdescription . "')";
				$result = $conn->query($sql);
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
					//class doesn't exist yet so ADD it
					$sql = "INSERT INTO `classes` (`name`, `max_students`, `teacher`, `description`) VALUES ('" . $classname . "', '" . $classsize . "', '" . $username . "', '" . $classdescription . "')";
					$result = $conn->query($sql);
				}else
				{
					$somevar = 'You cannot add any more classes!';
					$returnarr = array('result' => 'You cannot add any more classes!');
					echo json_encode($returnarr);
				}
			}
		}
	}
?>