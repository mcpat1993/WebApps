<?php
	session_start();
	if(isset($_POST["username"]))
	{
		$username = $_POST["username"];
		echo "username: " . $username;
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
	$sql = "SELECT `class1`,`class2`,`class3` FROM `users` WHERE `username`='" . $username . "'";
	//echo $sql;
	$result = $conn->query($sql);
	//echo $result->num_rows . " is num rows in the result";
	$arr = mysqli_fetch_assoc($result);
	echo '{"class1":"' . $arr['class1'] . '", "class2":"' . $arr['class2'] . '", "class3":"' . $arr['class3'] . '"}';
	//$_SESSION["error"] = "Sorry this username is not on file. Please try again";
	//header("Location: login.php");
	//echo "should have redirected and not reached this line <br>";
	//exit();
	
	//echo $_SESSION["username"]."<br>";
	//echo $_SESSION["password"]."<br>";
	//fclose($usersfile);
?>