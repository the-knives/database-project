<?php
// initialize the session
session_start();

// check if user is loggin in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
	header("location: http://localhost/Projects/beer/login.php");
	exit;
}
?>

<!doctype html>
<head>
	<link rel="stylesheet" href="http://localhost/Projects/beer/styles/style.css">
</head>
<body>
<h1>Welcome</h1>
<?php include_once('nav_bar.php'); ?>
<div class="page-header">
		<h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1>
	</div>
	<p>
		<a href="http://localhost/Projects/beer/reset_password.php" class="btn btn-warning">Reset your password</a><br>
		<a href="http://localhost/Projects/beer/logout.php" class="btn btn-danger">Sign out of your account</a>
	</p>
</body>
</html>
