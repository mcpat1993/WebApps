<?php
	session_start();
	$classname ='';
	if(isset($_POST["classname"]))
	{
		$classname = $_POST["classname"];
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
	$sql = "SELECT `class1`,`class2`,`class3` FROM `users` WHERE `username`='" . $_SESSION["username"] . "'";
	$result = $conn->query($sql);
	$classarr = mysqli_fetch_assoc($result);
	echo "class arr: ". $classarr["class1"]. " ".$classarr["class2"]." ". $classarr["class3"];
	echo $sql . "<br>";
	if($classarr["class1"] === NULL or $classarr["class1"] === $classname)
	{//add to class 1
		$sql = "UPDATE `users` SET `class1`='" . $classname . "' WHERE `username`='" . $_SESSION["username"] . "'";
		$result = $conn->query($sql);
		$_SESSION["class1"] = $classname;
		echo $sql . "<br>";
	}else
	{
		$_SESSION["class1"] = $classarr["class1"];
		if($classarr["class2"] === NULL or $classarr["class2"] === $classname)
		{
			//add to class2
			$sql = "UPDATE `users` SET `class2`='" . $classname . "' WHERE `username`='" . $_SESSION["username"] . "'";
			$result = $conn->query($sql);
			$_SESSION["class2"] = $classname;
			echo $sql . "----------- " . $classname . " " .$classarr["class2"] . "<br>";
		}else
		{
			$_SESSION["class2"] = $classarr["class2"];
			if($classarr["class3"] === NULL or $classarr["class3"] === $classname)
			{
				//add to class3
				$sql = "UPDATE `users` SET `class3`='" . $classname . "' WHERE `username`='" . $_SESSION["username"] . "'";
				$result = $conn->query($sql);
				$_SESSION["class3"] = $classname;
				echo $sql . "<br>";
			}else
			{
				$_SESSION["class3"] = $classarr["class3"];
				$_SESSION["error"] = "You can't add any more classes!";
				header("Location: home.php");
				exit();
			}
		}
	}
	
	//sql to class entered already exists
	$sql = "UPDATE `classes` SET `curr_students`=`curr_students`+1 WHERE `name`='" . $classname . "'";
	$result = $conn->query($sql);
	$_SESSION["dbresult"] = "Class Added!";
	echo $sql . "<br>";
	echo $_SESSION["class1"] . "<br>";
	echo $_SESSION["class2"] . "<br>";
	echo $_SESSION["class3"] . "<br>";
	header("Location: home.php");
	exit();
?>