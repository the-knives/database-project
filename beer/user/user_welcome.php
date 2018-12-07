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
<h1>Account</h1>
<?php include_once('user_nav_bar.php'); ?>
</div>
<form>
	<input type="button" value="Click here to update your information"
		onclick="window.location.href='http://localhost/Projects/beer/user/update_user.php'" />
</form>
<form>
	<input type="button" value="Click here to reset your password"
		onclick="window.location.href='http://localhost/Projects/beer/reset_password.php'" />
</form>
		<form>
			<input type="button" value="Click here to sign out of your account"
				onclick="window.location.href='http://localhost/Projects/beer/logout.php'" />
		</form>
</body>
</html>
