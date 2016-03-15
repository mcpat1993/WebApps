<script src="myJS.js"></script>
</script>
<?php
session_start();
if(!isset($_SESSION["loggedin"]))
{
  $_SESSION["error"] = "You have not logged in. Please log in first";
  header("Location: login.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<div align="right" class="mainmenu" href="homestyle.css" onclick="logout();">
	Logout
</div>
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="homestyle.css">
	<title>Document</title>
</head>
<body>
	<fieldset>
  		<h1>Welcome to My Signup, <?= $_SESSION["firstname"]?> <?= $_SESSION["lastname"]?></h1>
		<p>You are a Student! You are signed up for the following courses.<br></p>
		<form action="" method="post">
			<?php
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
				$sql = "SELECT `class1`, `class2`, `class3` FROM `users` WHERE `username`='" . $_SESSION["username"] . "'";
				$result = $conn->query($sql);
				$classarr = mysqli_fetch_assoc($result);
				//echo "1: " . $classarr["class1"] . " 2: " . $classarr["class2"] . " 3: " . $classarr["class3"];
				if($classarr["class1"] !== NULL)
				{
					$_SESSION["class1"] = $classarr["class1"];
					?>
					<input type="checkbox" name=<?php echo $_SESSION["class1"];?> value=<?php echo $_SESSION["class1"];?> checked><?php echo $_SESSION["class1"];?><br>
					<?php
				}
				if($classarr["class2"] !== NULL)
				{
					$_SESSION["class2"] = $classarr["class2"];
					?>
					<input type="checkbox" name=<?php echo $_SESSION["class2"];?> value=<?php echo $_SESSION["class2"];?> checked="checked"><?php echo $_SESSION["class2"];?><br>
					<?php
				}		
				if($classarr["class3"] !== NULL)
				{
					$_SESSION["class3"] = $classarr["class3"];
					?>
					<input type="checkbox" name=<?php echo $_SESSION["class3"];?> value=<?php echo $_SESSION["class3"];?> checked="checked"><?php echo $_SESSION["class3"];?><br>
					<?php
				}
			?>
		</form>
		<br>
		<p>Existing classes.</p>
		<form action="addClass.php" method="post">
		<?php
			$sql = "SELECT * FROM `classes`";
			$result = $conn->query($sql);
			while($row = mysqli_fetch_array($result))
			{
				echo "<input type='radio' name='classname' value='" . $row['name'] . "'>" . $row['name'] . "<br>";
			}
		?>
			<input type="submit" value="Sign up!">
			<br>
			<?php 	if(isset($_SESSION["error"])){echo "<font color=\"red\">" . $_SESSION["error"] . "</font><br>";}
				if(isset($_SESSION["dbresult"])){echo "<font color=\"green\">" . $_SESSION["dbresult"] . "</font><br>";}
				unset($_SESSION["error"]);
				unset($_SESSION["dbresult"]);?>
		</form>
	</fieldset>
</body>
</html>