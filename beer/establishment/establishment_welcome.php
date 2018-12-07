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
<h1>Your Profile</h1>
<?php include_once('nav_bar_establishment.php'); ?>
<div class="wrapper">
		<h2>Update Information</h2>
		<div class="form-group">
				<label>New Name</label>
				<input type="text" name="new_name" class="form-control" value="<?php echo $new_name; ?>"><br>
				<label>New First Name</label>
				<input type="text" name="new_first" class="form-control" value="<?php echo $new_first; ?>"><br>
				<label>New Street</label>
				<input type="text" name="new_street" class="form-control" value="<?php echo $new_street; ?>"><br>
				<input type="submit" />
		</div>
</div>
		<?php include_once "../reset_password.php";?>
		<form>
			<input type="button" value="Click here to sign out of your account"
				onclick="window.location.href='http://localhost/Projects/beer/logout.php'" />
		</form>
</body>
</html>
