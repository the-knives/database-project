<?php
// initialize the session
session_start();

// check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
	header("location: login.php");
	exit;
}

// include connection file
require_once "../conn.php";
	//echo "here1";
// define variables and initialize with empty values
$new_first = "";
$new_email = "";
// processing form data when form is submitted
if(isset($POST["submit"])) {
	// form validation goes here
  // prepare an update statement
	echo "here";
  $sql = "UPDATE regular_user SET first_name = ? WHERE id = ?";
	if($stmt = mysqli_prepare($conn, $sql)) {
  	// bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "s", $param_new_first);
		// set parameters
    $param_new_first = $_SESSION["new_first"];
    $param_id = $_SESSION["id"];
		echo "we got here";
		// attempt to execute the prepared statement
    if(mysqli_stmt_execute($stmt)){
			echo "success";
			printf("records updated: %d\n", mysql_affected_rows());
    	// updated successfully. Destroy the session, and redirect to login page
    	session_destroy();
    	header("location: user_welcome.php");
    	exit();
    }
		else {
    	echo "Oops! Something went wrong. Please try again later.";
    }
  }
	// Close statement
  mysqli_stmt_close($stmt);
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
        	<h2>Update Information</h2>
        	<form action="user_welcome.php" method="post">
                		<label>New First Name</label>
                		<input type="text" name="new_first_name" class="form-control">
            		</div>
                		<label>New Email</label>
                		<input type="text" name="new_email" class="form-control">
            		</div>
            		<div class="form-group">
                		<input type="submit" class="btn btn-primary" value="submit">
            		</div>
        	</form>
    	</div>
</body>
</html>
