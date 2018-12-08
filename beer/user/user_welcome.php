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

<table style="width:40%; margin-left:auto; margin-right:auto">
	<?php
		require_once "../conn.php";
		$uid = $_SESSION['id'];
		$sql = "SELECT * FROM regular_user WHERE id = '$uid'";

		$results = $conn->query($sql);
		if (mysqli_num_rows($results) > 0) {
			while ($row = mysqli_fetch_array($results)) {
				echo "<tr><th>Username</th><td>$row[4]</td></tr>";
				echo "<tr><th>Email</th><td>$row[6]</td></tr>";
				echo "<tr><th>First Name</th><td>$row[1]</td></tr>";
				echo "<tr><th>Middle Initial</th><td>$row[3]</td></tr>";
				echo "<tr><th>Last Name</th><td>$row[2]</td></tr>";
				echo "<tr><th>Gender</th><td>$row[7]</td></tr>";
				echo "<tr><th>Date of Birth</th><td>$row[8]</td></tr>";
			}
		}
	?>
</table>

<form>
	<input type="button" value="Click here to update your information"
		onclick="window.location.href='http://localhost/Projects/beer/user/update_user.php'" />
</form>
<form>
	<input type="button" value="Click here to reset your password"
		onclick="window.location.href='http://localhost/Projects/beer/user/user_reset.php'" />
</form>
		<form>
			<input type="button" value="Click here to sign out of your account"
				onclick="window.location.href='http://localhost/Projects/beer/logout.php'" />
		</form>
</body>
</html>
