<?php
	session_start();
	$user = $_SESSION["user"];
	if($user["permission"])
	{
		exit(header("Location: ../hometeacher.php"));
	}else
	{
		exit(header("Location: ../home.php"));
	}
?>