<?php
	session_start();
	$username='';
	if(isset($_POST["username"]))
	{
		$username = $_POST["username"];
	}
	$password='';
	if(isset($_POST["username"]))
	{
		$password = $_POST["password"];
	}
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
	}
	
	$_SESSION["error"] = "Sorry this username is not on file. Please try again";
	header("Location: login.php");
	echo "should have redirected and not reached this line <br>";
	exit();
	
	//echo $_SESSION["username"]."<br>";
	//echo $_SESSION["password"]."<br>";
	fclose($usersfile);
?>