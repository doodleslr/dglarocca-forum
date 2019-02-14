<?php 
session_start();

//unset all the session variables
$_SESSION = array();

session_destroy();

header("location: login.php");
exit;
?>