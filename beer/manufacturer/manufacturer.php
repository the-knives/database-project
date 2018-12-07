<?php
// include connection file
require_once "conn.php";

// define variables and initialize with empty values
$beer_name = "";
$type = "";
$container = "";
$manufacturer = "";
$alcohol_content = "";
$serving_size = "";
$cals_per_serving = "";

$beer_name_error = "";
$type_error = "";
$container_error = "";
$manufacturer_error = "";
$alcohol_content_error = "";
$serving_size_error = "";
$cals_per_serving_error = "";

// processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
	// validate beer_name
	if(empty(trim($_POST["beer_name"]))) {
		$beer_name_error = "Please enter name for your beer.";
	}
	else {
		// prepare a select statement
		$sql = "SELECT id FROM beer WHERE beer_name = ?";

		if($stmt = mysqli_prepare($conn, $sql)) {
			// bind variables to the prepared statement as parameters
			mysqli_stmt_bind_param($stmt, "s", $param_beer_name);

			// set parameters
			$param_beer_name = trim($_POST["beer_name"]);
			// attempt to execute the prepared statement
			if(mysqli_stmt_execute($stmt)) {
				// store result
				mysqli_stmt_store_result($stmt);

				if(mysqli_stmt_num_rows($stmt) == 1) {
					$beer_name_error = "This beer is already registered.";
				}
				else {
					$beer_name = trim($_POST["beer_name"]);
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
	if(empty(trim($_POST["type"]))) {
		$type_error = "Please enter a type for your beer.";
	}
	else {
		$type = trim($_POST["type"]);
	}


		// validate password
	if(empty(trim($_POST["container"]))) {
		$container_error = "Please enter a type of container.";
	}
	else {
		$container = trim($_POST["container"]);
	}


	if(empty(trim($_POST["manufacturer"]))) {
		$manufacturer_error = "Please enter the name of the manufacturer.";
	}
	else {
		$manufacturer = trim($_POST["manufacturer"]);
	}

	$alcohol_content = trim($_POST["alcohol_content"]);
	$serving_size = trim($_POST["serving_size"]);
	$cals_per_serving = trim($_POST["cals_per_serving"]);

	// check input errors before inserting in database
	if(empty($beer_name_error) && empty($type_error) && empty($container_error) && empty($manufacturer_error)) {
		$sql = "INSERT INTO beer (id, beer_name, type, container, manufacturer, alcohol_content, serving_size, cals_per_serving)
				VALUES (NULL, '$beer_name', '$type', '$container', '$manufacturer', '$alcohol_content', '$serving_size', '$cals_per_serving')";

		if ($conn->query($sql) === TRUE) {
			header("location: http://localhost/Projects/beer/beer.php");
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}
	mysqli_close($conn);
}
?>

<?php
$table_name = "beer";
$column_name = "type";
$query = "SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS
    	  WHERE TABLE_NAME = '$table_name' AND COLUMN_NAME = '$column_name'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_array($result);
$typeList = explode(",", str_replace("'", "", substr($row['COLUMN_TYPE'], 5, (strlen($row['COLUMN_TYPE'])-6))));
?>

<?php
$table_name = "beer";
$column_name = "container";
$query = "SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS
    	  WHERE TABLE_NAME = '$table_name' AND COLUMN_NAME = '$column_name'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_array($result);
$containerList = explode(",", str_replace("'", "", substr($row['COLUMN_TYPE'], 5, (strlen($row['COLUMN_TYPE'])-6))));
?>


<!doctype html>
<head>
	<link rel="stylesheet" href="http://localhost/Projects/beer/styles/style.css">
</head>
<body>
<h1>Register</h1>
<?php include_once('nav_bar.php'); ?>
<div class="wrapper">
	<h2>Sign Up</h2>
	<p>Please fill this form to register your beer.</p>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

		<div class="form-group <?php echo (!empty($beer_name_error)) ? 'has-error' : ''; ?>">
			<label>Name of Beer</label>
			<input type="text" name="beer_name" class="form-control" value="<?php echo $beer_name;?>">
			<span class="help-block"><?php echo $beer_name_error; ?></span>

		<div class="form-group">
			<label>Type of Beer</label>
			<select name="type">
				<option>Beer Type</option>
					<?php foreach($typeList as $value)
						echo "<option value =\"$value\">$value</option>"; ?>
			</select>
		</div>

		<div class="form-group">
			<label>Type of Container</label>
			<select name="container">
				<option>Container Type</option>
					<?php foreach($containerList as $value)
						echo "<option value =\"$value\">$value</option>"; ?>
			</select>
		</div>

		<div class="form-group <?php echo (!empty($manufacturer_error)) ? 'has-error' : ''; ?>">
			<label>Manufactured By</label>
			<input type="text" name="manufacturer" class="form-control" value="<?php echo $manufacturer;?>">
			<span class="help-block"><?php echo $manufacturer_error; ?></span>

		<div class="form-group <?php echo (!empty($alcohol_content_error)) ? 'has-error' : ''; ?>">
			<label>Alcohol Content</label>
			<input type="decimal" name="alcohol_content" class="form-control" value="<?php echo $alcohol_content;?>">
			<span class="help-block"><?php echo $alcohol_content_error; ?></span>

		<div class="form-group <?php echo (!empty($serving_size_error)) ? 'has-error' : ''; ?>">
			<label>Serving Size</label>
			<input type="decimal" name="serving_size" class="form-control" value="<?php echo $serving_size; ?>">
			<span class="help-block"><?php echo $serving_size_error; ?></span>	

		<div class="form-group <?php echo (!empty($cals_per_serving_error)) ? 'has-error' : ''; ?>">
			<label>Calories</label>
			<input type="decimal" name="cals_per_serving" class="form-control" value="<?php echo $cals_per_serving; ?>">
			<span class="help-block"><?php echo $cals_per_serving_error; ?></span>

		</div>

		<div class="form-group">
            <input type="submit" class="btn btn-primary" value="Submit">
            <input type="reset" class="btn btn-default" value="Reset">
        </div>

		
    </form>
</div>
</body>
</html>
