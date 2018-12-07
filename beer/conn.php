<?php
$user = 'root';
$password = 'root';
$db = 'fbdb';
$host = 'localhost';
$port = 3306;


$conn = new mysqli(
   $host,
   $user,
   $password,
   $db
);

if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

?>
