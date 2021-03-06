<?php
// initialize the session
session_start();

// check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
	header("location: user_login.php");
	exit;
}

// include connection file
require_once "../conn.php";

// define variables and initialize with empty values
$new_password = "";
$confirm_password = "";
$new_password_error = "";
$confirm_password_error = "";

// processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
    	// validate new password
	if(empty(trim($_POST["new_password"]))){
        	$new_password_error = "Please enter the new password.";
    	}
	elseif(strlen(trim($_POST["new_password"])) < 6) {
        	$new_password_error = "Password must have atleast 6 characters.";
    	}
	else {
        	$new_password = trim($_POST["new_password"]);
    	}

    	// validate confirm password
    	if(empty(trim($_POST["confirm_password"]))) {
        	$confirm_password_error = "Please confirm the password.";
    	}
	else {
        	$confirm_password = trim($_POST["confirm_password"]);
        	if(empty($new_password_error) && ($new_password != $confirm_password)) {
        		$confirm_password_error = "Password did not match.";
        	}
    	}

    	// check input errors before updating the database
    	if(empty($new_password_error) && empty($confirm_password_error)) {
        	// prepare an update statement
        	$sql = "UPDATE regular_user SET pass_word = ? WHERE id = ?";

        	if($stmt = mysqli_prepare($conn, $sql)) {
           		// bind variables to the prepared statement as parameters
            		mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);

            		// set parameters
            		$param_password = password_hash($new_password, PASSWORD_DEFAULT);
            		$param_id = $_SESSION["id"];

           		// attempt to execute the prepared statement
            		if(mysqli_stmt_execute($stmt)){
                		// password updated successfully. Destroy the session, and redirect to login page
                		session_destroy();
                		header("location: user_login.php");
                		exit();
     	 	      	}
                    else {
                		echo "Oops! Something went wrong. Please try again later.";
            		}
        	   }

        	// Close statement
        	mysqli_stmt_close($stmt);
    	}

    	// Close connection
    	mysqli_close($conn);
}
?>

<!DOCTYPE html>
<head>
	<link rel="stylesheet" href="http://localhost/Projects/beer/styles/style.css">
</head>
<body>
<div class="wrapper">
        	<h2>Reset Password</h2>
        	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            		<div class="form-group <?php echo (!empty($new_password_error)) ? 'has-error' : ''; ?>">
                		<label>New Password</label>
                		<input type="password" name="new_password" class="form-control" value="<?php echo $new_password; ?>">
                		<span class="help-block"><?php echo $new_password_error; ?></span>
            		</div>
            		<div class="form-group <?php echo (!empty($confirm_password_error)) ? 'has-error' : ''; ?>">
                		<label>Confirm Password</label>
                		<input type="password" name="confirm_password" class="form-control">
                		<span class="help-block"><?php echo $confirm_password_error; ?></span>
            		</div>
            		<div class="form-group">
                		<input type="submit" class="btn btn-primary" value="Submit">
            		</div>
        	</form>
    	</div>
</body>
</html>
