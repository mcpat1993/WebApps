<?php
	session_start();
	
	$servername = "localhost";
	$dbusername = "root";
	$dbpassword = "";
	$dbname = "webapps";
	
	$username = $_POST["username"];
	$password = $_POST["password"];
	
	//create connection with database
	$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
	//confirming that connection was made
	if($conn->connect_error)
	{
		die("God Damn connection failed: ". $conn->connect_error);
	}
	//sql to check if username and pw are correc
	$sql = "SELECT * FROM `users` WHERE `username` = '" . $username . "'";
	$result = $conn->query($sql);
	
	if($result->num_rows == 1)
	{
		$resultRow = $result->fetch_assoc();
		if($username==$resultRow["username"] and $password==$resultRow["password"])
		{
			$_SESSION["loggedin"] = 1;
			$_SESSION["username"] = $username;
			$_SESSION["password"] = $password;
			$_SESSION["user"] = $resultRow;
			if($resultRow["permission"] == 1)
			{
				//header("Location: hometeacher.php");
				//exit();
			}
			if($resultRow["permission"] == 0)
			{
				//header("Location: home.php");
				//exit();
			}
			$noerror = array('error' => 0);
			echo json_encode($noerror);
		}else
		{
			$wrongpw = array('error' => 1);
			echo json_encode($wrongpw);
		}
	}else{
		$nonexistentuser = array('error' => 2);
		echo json_encode($nonexistentuser);
	}
?>