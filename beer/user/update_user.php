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
$new_first_name = "";
$new_email = "";
$new_first_name_error = "";
$new_email_error = "";

// processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
        // validate new password
    if(empty(trim($_POST["new_first_name"]))){
            $new_first_name_error = "Please enter a new value";
        }
    else {
            $new_first_name = trim($_POST["new_first_name"]);
        }

    // validate confirm password
    if(empty(trim($_POST["new_email"]))) {
        $new_email_error = "Please enter a new value.";
    }
    else {
        $new_email = trim($_POST["new_email"]);
    }

    // check input errors before updating the database
    if(empty($new_first_name_error) && empty($new_email_error)) {

        $sql = "UPDATE regular_user SET first_name = ?, email = ? WHERE id = ?";

        if($stmt = mysqli_prepare($conn, $sql)) {
            // bind variables to the prepared statement as parameters

            mysqli_stmt_bind_param($stmt, "ssi", $param_first_name, $param_email, $param_id);

            // set parameters
            $param_first_name = $new_first_name;
            $param_email = $new_email;
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
            <h2>Update Information</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group <?php echo (!empty($new_first_name_error)) ? 'has-error' : ''; ?>">
                        <label>New First Name</label>
                        <input type="text" name="new_first_name" class="form-control" value="<?php echo $new_first_name; ?>">
                        <span class="help-block"><?php echo $new_first_name_error; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($new_email_error)) ? 'has-error' : ''; ?>">
                        <label>New Email</label>
                        <input type="text" name="new_email" class="form-control">
                        <span class="help-block"><?php echo $new_email_error; ?></span>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Update Information">
                    </div>
            </form>
        </div>
</body>
</html>
