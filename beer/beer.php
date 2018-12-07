<!doctype html>
<html lang="en">
<!-- the head tag contains a link to an external css stylesheet -->
<head>
	<meta charset="utf-8" />
	<title>Beers</title>
	<meta name="viewport" content="initial-scale=1.0; maximum-scale=1.0; width=device-width;">
	<link rel="stylesheet" href="http://localhost/Projects/beer/styles/style.css">
	<style>
		th, td {
			height: 32px;
			padding: 10px;
		}
    	tr:nth-of-type(odd) {
    	background-color:#ebad00;
    	}
    	tr:nth-of-type(even) {
    	background-color:#cc8000;
    	}
	</style>
</head>

<body>
<h1>Beer</h1>
<?php include_once('nav_bar.php'); ?>

<div class="table-title">
<h3 align="center">Beers</h3>
</div>
<table class="activeTable">
	<col width ="14%">
	<col width ="10%">
	<col width ="10%">
	<col width ="14%">
	<col width ="8%">
	<col width ="8%">
	<col width ="8%">
	<col width ="8%">
	<tr>
		<th class="text-left" align="left">Name</th>
		<th class="text-left" align="left">Type</th>
		<th class="text-left" align="left">Container</th>
		<th class="text-left" align="left">Manufacturer</th>
		<th class="text-left" align="left">ABV</th>
		<th class="text-left" align="left">Serving Size</th>
		<th class="text-left" align="left">Calories</th>
	</tr>

	<?php
	require_once "conn.php";
	// get data
	$query = "SELECT * FROM beer";
	$results = $conn-> query($query);

	if ($results-> num_rows > 0){
		while ($row = $results-> fetch_assoc()){
			echo "<tr> 
				<td align=\"left\">" . $row["beer_name"] . "</td>
				<td align=\"left\">" . $row["type"] . "</td>
				<td align=\"left\">" . $row["container"] . "</td>
				<td align=\"left\">" . $row["manufacturer"] . "</td>
				<td align=\"left\">" . $row["alcohol_content"] . "</td>
				<td align=\"left\">" . $row["serving_size"] . "</td>
				<td align=\"left\">" . $row["cals_per_serving"] . "</td>
			 </tr>";
		}
	}
	$conn->close();
	?>
</table>
  

</body>
</html>