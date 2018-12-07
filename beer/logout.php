<?php
// initialize session
session_start();

//unset all session variables
$_SESSION = array();

unset($_SESSION["username"]);

// destroy the session
session_destroy();

// redirect to login page
header("location: http://localhost/Projects/beer/index.php");
exit;
?>
