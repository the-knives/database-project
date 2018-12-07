<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$servername = 'localhost';
$username = 'root';
$password = 'password';
$database = 'fbdb';

// create a connection
$conn = mysqli_connect($servername, $username, $password, $database);

// check connection
if(!$conn) {
	die('Connection failed: ' . mysqli_connect_error());
}
echo "Connected Successfully";
?>
