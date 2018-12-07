<?php session_start(); ?>
<!doctype html>
<html lang="en">
<!-- the head tag contains a link to an external css stylesheet -->
<head>
	<meta charset="utf-8" />
	<title>Beers</title>
	<meta name="viewport" content="initial-scale=1.0; maximum-scale=1.0; width=device-width;">
	<link rel="stylesheet" href="http://localhost/Projects/beer/user/styles/style.css">
</head>

<?php
	require_once '../conn.php';
	$uid = $_SESSION['id'];
	$bid = $_GET['id'];
	$sql = "INSERT INTO user_favorites (user_id, beer_id)
			VALUES ($uid, $bid)";
	if ($conn->query($sql) === TRUE) {
		header("location: http://localhost/Projects/beer/user/my_beers.php");
	}
	else {
		header("location: http://localhost/Projects/beer/user/user_beer.php");
	}

?>