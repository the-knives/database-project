<?php session_start(); ?>
<!doctype html>
<html lang="en">
<!-- the head tag contains a link to an external css stylesheet -->
<head>
	<meta charset="utf-8" />
	<title>Beers</title>
	<meta name="viewport" content="initial-scale=1.0; maximum-scale=1.0; width=device-width;">
	<link rel="stylesheet" href="http://localhost/Projects/beer/styles/style.css">
	<style>
	.link-btn {
		text-decoration: none; 
    	color: white;
    	background: blue;
    	padding: 5px 10px;
    	display: block;
    	margin: 8px 8px;
    	text-align: center;
    	text-transform: uppercase;
    	letter-spacing: 1px;
    	font-size: 13px;
	}
 
		.link-btn:hover {
    	background: #6ab8be;
		}

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

<body class="favbars">
<h1>My Bars</h1>
<?php include_once('user_nav_bar.php'); ?>

<div class="table-title">
<h3 align="center">Liked Bars</h3>
</div>
<table class="activeTable">
	<col width ="14%">
	<col width ="14%">
	<col width ="10%">
	<col width ="4%">
	<col width ="4%">
	<col width ="8%">
	<col width ="2%">
	<tr>
		<th class="text-left" align="left">Name</th>
		<th class="text-left" align="left">Street Address</th>
		<th class="text-left" align="left">City</th>
		<th class="text-left" align="left">State</th>
		<th class="text-left" align="left">Zip Code</th>
		<th class="text-left" align="left">Phone Number</th>
		<th class="text-left" align="center">Like/Unlike</th>
	</tr>

	<?php
	require_once "../conn.php";
	$uid = $_SESSION['id'];
	$sql = "SELECT * FROM establishment
			INNER JOIN user_bars
			ON establishment.id=user_bars.bar_id
			WHERE user_bars.user_id = '$uid'";
	$results = $conn-> query($sql);

	if (mysqli_num_rows($results) > 0){
		while ($row = mysqli_fetch_array($results)){
			echo "<tr>";
			echo "<td align='left'>$row[1]</td>";
			echo "<td align='left'>$row[4]</td>";
			echo "<td align='left'>$row[5]</td>";
			echo "<td align='left'>$row[6]</td>";
			echo "<td align='left'>$row[7]</td>";
			echo "<td align='left'>$row[11]</td>";
			print '<td> <center><a href="http://localhost/Projects/beer/user/bar_unlike.php?id='.$row['id'].'" class="link-btn">UNLIKE</a></center>';
			echo "</tr>";
		}
	}
	$conn->close();
	?>
</table>
</body>
</html>