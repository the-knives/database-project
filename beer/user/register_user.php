<?php
// include connection file
require_once "../conn.php";

// define variables and initialize with empty values
$first_name = "";
$last_name = "";
$middle_initial = "";
$email = "";
$gender = "";
$birth = "";
$username = "";
$password = "";
$confirm_password = "";

$firstname_error = "";
$lastname_error = "";
$middle_initial_error = "";
$email_error = "";
$gender_error = "";
$birth_error = "";
$username_error = "";
$password_error = "";
$confirm_password_error = "";

// processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
	// validate username
	if(empty(trim($_POST["username"]))) {
		$username_error = "Please enter a username.";
	}
	else {
		// prepare a select statement
		$sql = "SELECT id FROM regular_user WHERE user_name = ?";

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
	}

	// Validate last name
	if(empty(trim($_POST["last_name"]))) {
		$lastname_error = "Please enter your last name.";
	}
	else {
		$last_name = trim($_POST["last_name"]);
	}

	// Validate middle initial
	if(strlen(trim($_POST["middle_initial"])) > 3) {
		$middle_initial_error = "Middle intial must be less than 3 characters.";
	}
	else {
		$middle_initial = trim($_POST["middle_initial"]);
	}

	// Validate email Address
	if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    $email = trim($_POST["email"]);
	}
	else {
		$email_error = "Invalid email address.";
	}

	// Validate Gender
	if(isset($_POST['submit'])) {
		if($_POST['gender'] == 'male') {
			$gender = "Male";
		}
		else if($_POST['gender'] == 'female') {
			$gender = "Female";
		}
		else {
			$gender = "Other";
		}
	}

	// birth_date
	if(empty($_POST["year"]) && empty($_POST["month"]) && empty($_POST["day"])) {
		$birth_error = "Please enter your date of birth.";
	}
	else {
		$birth = trim($_POST["year"] . "-" . $_POST["month"] . "-" . $_POST["day"]);
	}


	// check input errors before inserting in database
	if(empty($username_error) && empty($password_error) && empty($confirm_password_error)
		&& empty($middle_initial_error) && empty($email_error) && empty($gender_error) &&
			empty($firstname_error) && empty($lastname_error) && empty($birth_error)) {
		// prepare an insert statement
		$sql = "INSERT INTO regular_user(first_name, last_name, user_name, pass_word, middle_initial,
			email, gender, birth_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
		if($stmt = mysqli_prepare($conn, $sql)) {
			// bind variables to the prepared statement as parameters
			mysqli_stmt_bind_param($stmt, "ssssssss", $param_first, $param_last, $param_username, $param_password, $param_middle,
				$param_email, $param_gender, $param_birth);
			// set parameters
			$param_email = $email;
			$param_username = $username;
			$param_middle = $middle_initial;
			$param_email = $email;
			$param_gender = $gender;
			$param_first = $first_name;
			$param_last = $last_name;
			$param_birth = $birth;
			// create password hash
			$param_password = password_hash($password, PASSWORD_DEFAULT);
			// attempt to execute the prepared statement
			if(mysqli_stmt_execute($stmt)) {
				// redirect login page
				header("location: http://localhost/Projects/beer/user/user_login.php");
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
<h1>Regular User Registration Form</h1>
<div class="wrapper">
	<h2>Sign Up</h2>
	<p>Please fill this form to create an account.</p>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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
			<label>Date of Birth</label>
			<select name="month">
				<option>Month</option>
					<?php for($month = 1; $month <= 12; $month++)
						echo"<option value = '".$month."'>".$month."</option>"; ?>
			</select>
			<select name="day">
				<option>Day</option>
					<?php for($day = 1; $day <= 31; $day++)
						echo"<option value='".$day."'>".$day."</option>"; ?>
			</select>
			<select name="year">
				<option>Year</option>
					<?php $y = date("Y", strtotime("+8 HOURS"));
					for($year = 1930; $y >= $year; $y--)
						echo"<option value='".$y."'>".$y."</option>"; ?>
			</select>
		<div class="form-group">
			<label>Gender</label>
			<input type="radio" name="gender" <?php if (isset($gender) && $gender=="male")
				echo "checked";?> value="male">Male
			<input type="radio" name="gender" <?php if(isset($gender) && $gender=="female")
				echo "checked";?> value="female">Female
			<input type="radio" name="gender" <?php if (isset($gender) && $gender=="other")
				echo "checked";?> value="other">Other
            	<div class="form-group">
                	<input type="submit" class="btn btn-primary" value="Submit">
                	<input type="reset" class="btn btn-default" value="Reset">
            	</div>
							<p>Already have an Account? <a href="http://localhost/Projects/beer/user/user_login.php">Log in Now</a></p>
        </form>
    	</div>
</body>
</html>
