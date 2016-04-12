<?php
session_start();
session_unset();
$_SESSION["logoutmessage"]="You've been successfuly logged out.";
header("Location: login.php");
exit();
?>
