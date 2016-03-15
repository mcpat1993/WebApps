<?php
	session_start();
	if(isset($_POST["username"]))
	{
		$username = $_POST["username"];
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
	//sql to check if username and pw are correc
	$sql = "SELECT * FROM `users` WHERE `username` = '" . $username . "' AND `password` = '" . $password . "'";
	echo $sql;
	$result = $conn->query($sql);
	//sql to create another table
	/*$sql = "CREATE TABLE Users (
	firstname VARCHAR(30),
	lastname VARCHAR(30),
	username VARCHAR(50)NOT NULL,
	password VARCHAR(50)NOT NULL,
	class1 VARCHAR(50),
	class2 VARCHAR(50),
	class3 VARCHAR(50),
	permission INT(1)NOT NULL
	)";*/
	if($result->num_rows == 1)
	{
		$resultRow = $result->fetch_assoc();
		if($username==$resultRow["username"] and $password==$resultRow["password"])
		{
			echo "FOUND USERNAME AND PASSWORD LOG IN<br>";
			$_SESSION["loggedin"] = 1;
			$_SESSION["username"] = $username;
			$_SESSION["password"] = $password;
			$_SESSION["firstname"] = $resultRow["firstname"];
			$_SESSION["lastname"] = $resultRow["lastname"];
			$_SESSION["class1"] = $resultRow["class1"];
			$_SESSION["class2"] = $resultRow["class2"];
			$_SESSION["class3"] = $resultRow["class3"];
			
			if($resultRow["permission"] == 1)
			{
				header("Location: hometeacher.php");
				exit();
			}
			if($resultRow["permission"] == 0)
			{
				header("Location: home.php");
				exit();
			}
			die("There was an invalid permission for this user");
		}else
		{
			if($username==$curruser[0])
			{
				$_SESSION["error"] = "Your password is incorrect. Please try again";
				header("Location: login.php");
				exit();
			}
		}
	}
	/*
	if($result->num_rows == 1)
	{
		
		$resultRow = $result->fetch_assoc();
		echo "We found one row with permission:" . $resultRow["permission"];
		if($resultRow["permission"] == 1)
		{
			header("Location: hometeacher.php");
		}
		if($resultRow["permission"] == 0)
		{
			header("Location: home.php");
		}
		echo $resultRow["firstname"] . " " . $resultRow["lastname"] . " is name";
	}else
	{
		echo "We found permission ! 1";
	}
	*/
	
	/*$conn->close();

	
	
	
	$usersfile = fopen("users.txt", "r") or die("Unable to open users.txt!!!!!");
	$found = 0;
	while(!feof($usersfile)) 
	{
	  $curruser = explode(":", fgets($usersfile), 2);
	  $curruser[0] = trim($curruser[0]);
	  $curruser[1] = trim($curruser[1]);
	  echo "curruser: ".$curruser[0]." pw: ->".$curruser[1]."<-<br>";
	  echo "Searching for curruser: ".$username." pw: ".$password."<br>";
	  if($username==$curruser[0] and $password==$curruser[1])
	  {
	  	echo "FOUND USERNAME AND PASSWORD LOG IN<br>";
	  	$_SESSION["loggedin"] = 1;
	  	$_SESSION["username"] = $username;
	  	$_SESSION["password"] = $password;
	  	header("Location: home.php");
	  	exit();
	  }else
	  {
	  	if($username==$curruser[0])
	  	{
	  		$_SESSION["error"] = "Your password is incorrect. Please try again";
	  		header("Location: login.php");
	  		echo "should have redirected and not reached this line <br>";
	  		exit();
	  	}
	  }
	}*/
	
	$_SESSION["error"] = "Sorry this username is not on file. Please try again";
	header("Location: login.php");
	echo "should have redirected and not reached this line <br>";
	exit();
	
	//echo $_SESSION["username"]."<br>";
	//echo $_SESSION["password"]."<br>";
	//fclose($usersfile);
?>