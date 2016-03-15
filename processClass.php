<?php
	session_start();
	$classname ='';
	if(isset($_POST["classname"]))
	{
		if(empty($_POST["classname"]))
		{
			$_SESSION["error"] = "Class Name was not entered";
			echo "classname empty <br>";
			header("Location: hometeacher.php");
			exit();
		}
		$classname = $_POST["classname"];
	}
	$classsize='';
	if(isset($_POST["classsize"]))
	{
		if(empty($_POST["classsize"]))
		{
			$_SESSION["error"] = "Max Class Size was not entered";
			echo "classsize empty <br>";
			header("Location: hometeacher.php");
			exit();
		}
		$classsize = $_POST["classsize"];
	}
	echo "name: " . $_POST["classname"];
	echo "<br>size: " . $_POST["classsize"] . "<br>";
	unset($_SESSION["error"]);
	//$_SESSION["error"] = "...".$classname."..."; 
	//header("Location: hometeacher.php");
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
	if($result->num_rows > 0)
	{
		//there already exists the class trying to be made
		$_SESSION["error"] = "This class already exists. Please try again";
		header("Location: hometeacher.php");
		exit();
	}else
	{
		//class doesn't exist yet so ADD it
		$sql = "INSERT INTO `classes` (`name`, `max_students`, `curr_students`, `teacher`) VALUES ('" . $classname . "', '" . $classsize . "', '0', '" . $_SESSION["lastname"] . "')";
		$result = $conn->query($sql);
		//update teachers classes in db
		$sql = "SELECT `class1` FROM `users` WHERE `username`='" . $_SESSION["username"] . "'";
		$result = $conn->query($sql);
		if(mysqli_fetch_assoc($result)["class1"] === NULL)
		{//add to class 1
			$sql = "UPDATE `users` SET `class1`='" . $classname . "' WHERE `username`='" . $_SESSION["username"] . "'";
			$result = $conn->query($sql);
			$_SESSION["class1"] = $classname;
		}else
		{
			$_SESSION["class1"] = mysqli_fetch_assoc($result)["class1"];
			$sql = "SELECT `class2` FROM `users` WHERE `username`='" . $_SESSION["username"] . "'";
			$result = $conn->query($sql);
			if(mysqli_fetch_assoc($result)["class2"] === NULL)
			{
				//add to class2
				$sql = "UPDATE `users` SET `class2`='" . $classname . "' WHERE `username`='" . $_SESSION["username"] . "'";
				$result = $conn->query($sql);
				$_SESSION["class2"] = $classname;
			}else
			{
				$_SESSION["class2"] = mysqli_fetch_assoc($result)["class2"];
				$sql = "SELECT `class3` FROM `users` WHERE `username`='" . $_SESSION["username"] . "'";
				$result = $conn->query($sql);
				if(mysqli_fetch_assoc($result)["class3"] === NULL)
				{
					//add to class3
					$sql = "UPDATE `users` SET `class3`='" . $classname . "' WHERE `username`='" . $_SESSION["username"] . "'";
					$result = $conn->query($sql);
					$_SESSION["class3"] = $classname;
				}else
				{
					$_SESSION["class3"] = mysqli_fetch_assoc($result)["class3"];
					$_SESSION["error"] = "You can't add any more classes!";
					header("Location: hometeacher.php");
					exit();
				}
			}
		}
		$result = $conn->query($sql);
		$_SESSION["dbresult"] = "New class added!";
		header("Location: hometeacher.php");
		exit();
	}
	$conn->close();
?>