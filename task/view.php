<?php 


	$dsn = "mysql:host=localhost; dbname=task";
	$db_user = "root";
	$db_password = "";

	$conn = new PDO($dsn, $db_user, $db_password);
	// if($conn){
	// 	echo "connected";
	// }


	if (isset($_REQUEST['delete'])) {
		$sql = "DELETE FROM users WHERE id = :id";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':id', $_REQUEST['id']);
		$stmt->execute();
	}
?>
<html>
<head>
	<link href="style.css" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">
	<script src="script.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<title>View Users</title>
</head>


<body>
	<div class="outerV">
		<a href="index.php" style="text-decoration: none; color: black;">Home</a>
		<div class="viewDiv">

			<?php 
				$sql = "SELECT * FROM users";
				$result = $conn->query($sql);
				if ($result->rowCount() > 0) {
					echo '<table class="table">';
					echo "<thead>";
					echo "<tr>";
					echo "<th>ID</th>";
					echo "<th>Name</th>";
					echo "<th>Email id</th>";
					echo "<th>Mobile Number</th>";
					echo "<th>Address</th>";
					echo "<th>Status</th>";
					echo "<th>Action</th>";
					echo "</tr>";
					echo "</thead>";
					echo "<tbody>";

					while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
						echo "<tr>";
						echo "<td>" . $row["id"] . "</td>";
						echo "<td>" . $row["name"] . "</td>";
						echo "<td>" . $row["email"] . "</td>";
						echo "<td>" . $row["mobile"] . "</td>";
						echo "<td>" . $row["address"] . "</td>";
						if ($row['is_verified'] == 1) {
							echo '<td><button type="button" class="btn btn-xs btn-success" onclick="alert(\'Verified User!\')">Verified</button></td>';
						} else {
							echo '<td><button type="button" class="btn btn-xs btn-warning" onclick="alert(\'Check Email For Verification\')">Not Verified</button></td>';
						}
						echo '<td><form action="" method="POST"><input type="hidden" name="id" value="'. $row["id"] .'">
						<input type="submit" class="btn btn-xs btn-danger" name="delete" value="Delete"></form></td>'; 
						echo "</tr>";
					}
					echo "</tbody>";
					echo "</table>";	
				}
				else {
					echo '<h4 style="color:red">No User Data Available</h4>';
				}
			?>


        </div>
    </div>
</body>
</html>