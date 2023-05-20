<?php 
	$dsn = "mysql:host=localhost;dbname=task";
	$db_user = "root";
	$db_password = "";

	$conn = new PDO($dsn, $db_user, $db_password);
   
   if (isset($_GET['email']) && isset($_GET['v_code'])) {
   	$email = $_GET['email'];
   	$v_code = $_GET['v_code'];

   	$query = "SELECT * FROM users WHERE email = :email AND verification_code = :v_code";
   	$stmt = $conn->prepare($query);
   	$stmt->bindParam(':email', $email);
   	$stmt->bindParam(':v_code', $v_code);
   	$stmt->execute();

   	if ($stmt->rowCount() == 1) {
   		$result_fetch = $stmt->fetch(PDO::FETCH_ASSOC);
   		if ($result_fetch['is_verified'] == 0) {
   			$update = "UPDATE users SET is_verified = '1' WHERE email = :email"; 
   			$stmt_update = $conn->prepare($update);
   			$stmt_update->bindParam(':email', $result_fetch['email']);
   			if ($stmt_update->execute()) {
   				echo "<script>
				    alert('Verify Successful');
				    window.location.href='index.php';
				    </script>";
   			}
   			else {
   				echo "<script>
				    alert('Not Run');
				    window.location.href='index.php';
				    </script>";
   			}
   		}
   	}
   	else {
   		echo "<script>
		    alert('Not Run');
		    window.location.href='index.php';
		    </script>";
   	}
}
?>
