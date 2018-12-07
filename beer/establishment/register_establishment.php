<?php
// include connection file
require_once "../conn.php";

// define variables and initialize with empty values
$first_name = "";
$last_name = "";
$middle_initial = "";
$email = "";
$username = "";
$password = "";
$confirm_password = "";
$name = "";
$street = "";
$city = "";
$zip =  0;
$state = "";
$phone = 0;

$firstname_error = "";
$lastname_error = "";
$middle_initial_error = "";
$email_error = "";
$username_error = "";
$password_error = "";
$confirm_password_error = "";
$name_error = "";

// processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
	// validate username
	if(empty(trim($_POST["username"]))) {
		$username_error = "Please enter a username.";
	}
	else {
		// prepare a select statement
		$sql = "SELECT id FROM establishment WHERE user_name = ?";

		if($stmt = mysqli_prepare($conn, $sql)) {
			// bind variables to the prepared statement as parameters
			mysqli_stmt_bind_param($stmt, "s", $param_username);

			// set parameters
			$param_username = trim($_POST["username"]);
			// attempt to execute the prepared statement
			if(mysqli_stmt_execute($stmt)) {
				// store result
				mysqli_stmt_store_result($stmt);

				if(mysqli_stmt_num_rows($stmt) == 1) {
					$username_error = "This username is already taken.";
				}
				else {
					$username = trim($_POST["username"]);
				}
			}
			else {
				echo "Oops! Something went wrong. Please try again later.";
			}
		}
		// close statement
		mysqli_stmt_close($stmt);
	}

	// validate password
	if(empty(trim($_POST["password"]))) {
		$password_error = "Please enter a password.";
	}
	elseif(strlen(trim($_POST["password"])) < 6) {
		$password_error = "Password must have at least 6 characters.";
	}
	else {
		$password = trim($_POST["password"]);
	}

	// validate confirm password
	if(empty(trim($_POST["confirm_password"]))) {
		$confirm_password_error = "Please confirm password.";
	}
	else {
		$confirm_password = trim($_POST["confirm_password"]);
		if(empty($password_error) && ($password != $confirm_password)) {
			$confirm_password_error = "Passwords did not match";
		}
	}

	// Validate first name
	if(empty(trim($_POST["first_name"]))) {
		$firstname_error = "Please enter your first name.";
	}
	else {
		$first_name = trim($_POST["first_name"]);
		$param_first = $first_name;
	}

	// Validate last name
	if(empty(trim($_POST["last_name"]))) {
		$lastname_error = "Please enter your last name.";
	}
	else {
		$last_name = trim($_POST["last_name"]);
		$param_last = $last_name;
	}

	// Validate middle initial
	if(strlen(trim($_POST["middle_initial"])) > 3) {
		$middle_initial_error = "Middle intial must be less than 3 characters.";
	}
	else {
		$middle_initial = trim($_POST["middle_initial"]);
		$param_middle = $middle_initial;
	}

	// Validate email Address
	if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    $email = trim($_POST["email"]);
		$param_email = $email;
	}
	else {
		$email_error = "Invalid email address.";
	}

	// validate establishment name
	if(empty(trim($_POST["name"]))) {
		$name_error = "Please enter the establishment name.";
	}
	else {
		$name = trim($_POST['name']);
		$param_name = $name;
	}

	// validate street
	if(empty(trim($_POST["street"]))) {
		$street_error = "Please enter a street.";
	}
	else {
		$street = trim($_POST['street']);
		$param_street = $street;
	}

	// validate city
	if(empty(trim($_POST["city"]))) {
		$city_error = "Please enter a city.";
	}
	else {
		$city = trim($_POST['city']);
		$param_city = $city;
	}

	// validate zip
	if(empty(trim($_POST["zip"]))) {
		$zip_error = "Please enter a zip code.";
	}
	else {
		$zip = trim($_POST['zip']);
		$param_zip = $zip;
	}

	// validate state
	if(empty(trim($_POST["state"]))) {
		$state_error = "Please enter a state.";
	}
	else {
		$state = trim($_POST['state']);
		$param_state = $state;
	}

	// check input errors before inserting in database
	if(empty($username_error) && empty($password_error) && empty($confirm_password_error)
		&& empty($middle_initial_error) && empty($email_error) && empty($firstname_error)
			&& empty($lastname_error) && empty($name_error)) {
		// prepare an insert statement
		$sql = "INSERT INTO establishment(name, user_name, pass_word, street, city,
			state, zip, first_name, last_name, middle_initial, phone) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		if($stmt = mysqli_prepare($conn, $sql)) {
			// bind variables to the prepared statement as parameters
			mysqli_stmt_bind_param($stmt, "ssssssisssi", $param_name, $param_username,
				$param_password, $param_street, $param_city, $param_state, $param_zip,
					$param_first, $param_last, $param_middle, $param_phone);
			// set parameters
			$param_username = $username;
			// create password hash
			$param_password = password_hash($password, PASSWORD_DEFAULT);
			// attempt to execute the prepared statement
			if(mysqli_stmt_execute($stmt)) {
				// redirect login page
				header("location: http://localhost/Projects/beer/establishment/establishment_login.php");
			}
			else {
				echo "Something went wrong. Please try again later.";
			}
		}
		// close statement
		mysqli_stmt_close($stmt);
	}
	// close connection
	mysqli_close($conn);
}
?>

<!doctype html>
<head>
	<link rel="stylesheet" href="http://localhost/Projects/beer/styles/style.css">
</head>
<body>
<h1>Establishment Registration Form</h1>
<div class="wrapper">
	<h2>Sign Up</h2>
	<p>Please fill this form to create an account.</p>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
		<div class="form-group <?php echo (!empty($name_error)) ? 'has-error' : ''; ?>">
			<label>Establishment Name</label>
			<input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
			<span class="help-block"><?php echo $name_error; ?></span>
		</div>
		<div class="form-group <?php echo (!empty($firstname_error)) ? 'has-error' : ''; ?>">
			<label>First Name</label>
			<input type="text" name="first_name" class="form-control" value="<?php echo $first_name;?>">
			<span class="help-block"><?php echo $firstname_error; ?></span>
		<div class="form-group <?php echo (!empty($lastname_error)) ? 'has-error' : ''; ?>">
			<label>Last Name</label>
			<input type="text" name="last_name" class="form-control" value="<?php echo $last_name;?>">
			<span class="help-block"><?php echo $lastname_error; ?></span>
		<div class="form-group <?php echo (!empty($middle_initial_error)) ? 'has-error' : ''; ?>">
			<label>Middle Initial</label>
			<input type="text" name="middle_initial" class="form-control" value="<?php echo $middle_initial;?>">
			<span class="help-block"><?php echo $middle_initial_error; ?></span>
		<div class="form-group <?php echo (!empty($email_error)) ? 'has-error' : ''; ?>">
			<label>Email Address</label>
			<input type="email" name="email" class="form-control" value="<?php echo $email;?>">
			<span class="help-block"><?php echo $email_error; ?></span>
		<div class="form-group <?php echo (!empty($username_error)) ? 'has-error' : ''; ?>">
			<label>Username</label>
			<input type="text" name="username" class="form-control" value="<?php echo $username;?>">
			<span class="help-block"><?php echo $username_error; ?></span>
		</div>
		<div class="form-group <?php echo (!empty($password_error)) ? 'has-error' : ''; ?>">
			<label>Password</label>
			<input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
			<span class="help-block"><?php echo $password_error; ?></span>
		</div>
    <div class="form-group <?php echo (!empty($confirm_password_error)) ? 'has-error' : ''; ?>">
    	<label>Confirm Password</label>
      	<input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
        <span class="help-block"><?php echo $confirm_password_error; ?></span>
      </div>
      <div class="form-group">
      	<input type="submit" class="btn btn-primary" value="Submit">
      	<input type="reset" class="btn btn-default" value="Reset">
      </div>
            	<p>Don't have an account? <a href="http://localhost/Projects/beer/index.php">Sign up now</a>.</p>
        </form>
    	</div>
</body>
</html>
