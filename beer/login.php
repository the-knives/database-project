<?php
// initialize the session
session_start();

// check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
	header("location: http://localhost/Projects/beer/user/user_welcome.php");
	exit;
}

// include conn file
require_once "conn.php";

// define variables and initialize with empty values
$username = "";
$password = "";
$username_error = "";
$password_error = "";

// processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
	// Check if username is empty
    	if(empty(trim($_POST["username"]))) {
        	$username_error = "Please enter username.";
    	}
	else {
        	$username = trim($_POST["username"]);
    	}

    	// check if password is empty
    	if(empty(trim($_POST["password"]))) {
        	$password_error = "Please enter your password.";
    	}
	else {
        	$password = trim($_POST["password"]);
    	}

    // validate credentials
    	if(empty($username_error) && empty($password_error)) {
        	// prepare a select statement
					if ($_POST['type'] == "User") {
        		$sql = "SELECT id, user_name, pass_word FROM regular_user WHERE user_name = ?";
					}
					else if ($_POST['type'] == "Establishment") {
        		$sql = "SELECT id, user_name, pass_word FROM establishment WHERE user_name = ?";
					}
					else {
        		$sql = "SELECT id, user_name, pass_word FROM manufacturer WHERE user_name = ?";
					}
					
        	if($stmt = mysqli_prepare($conn, $sql)) {
            	// bind variables to the prepared statement as parameters
            	mysqli_stmt_bind_param($stmt, "s", $param_username);

            	// set parameters
            	$param_username = $username;

            	// attempt to execute the prepared statement
            	if(mysqli_stmt_execute($stmt)) {
                	// store result
                	mysqli_stmt_store_result($stmt);

                	// check if username exists, if yes then verify password
                	if(mysqli_stmt_num_rows($stmt) == 1) {
                    		// bind result variables
                    		mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    		if(mysqli_stmt_fetch($stmt)) {
                        		if(password_verify($password, $hashed_password)) {
                            			// password is correct, so start a new session
                            			session_start();

                            			// store data in session variables
                            			$_SESSION["loggedin"] = true;
                            			$_SESSION["id"] = $id;
                            			$_SESSION["username"] = $username;

                            			//redirect user to welcome page
																	if ($_POST['type'] == "User") {
																		header("location: http://localhost/Projects/beer/user/user_welcome.php");
																	}
                                  else if($_POST['type'] == "Establishment") {
                                    header("location: http://localhost/Projects/beer/establishment/establishment_welcome.php");
                                  }
                                  else {
                                    header("location: http://localhost/Projects/beer/manufacturer/manufacturer_welcome.php");
                                  }
                        		}
					else {
                            			// display an error message if password is not valid
                            			$password_error = "The password you entered was not valid.";
                        		}
                    		}
                	}
			else {
                    		// Display an error message if username doesn't exist
                    		$username_error = "No account found with that username.";
                	}
            	}
		else {
                	echo "Oops! Something went wrong. Please try again later.";
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
	<title>Login</title>
    	<link rel="stylesheet" href="http://localhost/Projects/beer/styles/style.css">
</head>
<body>
<div class="wrapper">
        	<h2>Login</h2>
        	<p>Please fill in your credentials to login.</p>
        	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
								<div class="form-group">
									<label>Account Type</label>
									<select name="type">
  									<option value="User">User</option>
  									<option value="Establishment">Establishment</option>
  									<option value="Manufacturer">Manufacturer</option>
									</select>
								</div>
            		<div class="form-group <?php echo (!empty($username_error)) ? 'has-error' : ''; ?>">
                		<label>Username</label>
                		<input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                		<span class="help-block"><?php echo $username_error; ?></span>
            		</div>
            		<div class="form-group <?php echo (!empty($password_error)) ? 'has-error' : ''; ?>">
                		<label>Password</label>
               			<input type="password" name="password" class="form-control">
               			<span class="help-block"><?php echo $password_error; ?></span>
            		</div>
           		<div class="form-group">
           			<input type="submit" class="btn btn-primary" value="Login">
          		</div>
            		<p>Don't have an account? <a href="http://localhost/Projects/beer/index.php">Sign up now</a></p>
        	</form>
    	</div>
</body>
</html>
