<?php

		
		use PHPMailer\PHPMailer\PHPMailer;
		use PHPMailer\PHPMailer\SMTP;
		use PHPMailer\PHPMailer\Exception;


		$dsn = "mysql:host=localhost;dbname=task";
		$db_user = "root";
		$db_password = "";

		$conn = new PDO($dsn, $db_user, $db_password);

	    function sendMail($email,$v_code){

	    require ("emailverify/PHPMailer.php");
		require ("emailverify/SMTP.php");
		require ("emailverify/Exception.php");



		    $mail = new PHPMailer(true);


			try {
		    //Server settings
		                         
		    $mail->isSMTP();                                            //Send using SMTP
		    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
		    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
		    $mail->Username   = 'Youremail@gmail.com';                     //SMTP username
		    $mail->Password   = 'password';                               //SMTP password
		    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
		    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

		    //Recipients
		    $mail->setFrom('yourmail', 'Prateek');
		    $mail->addAddress($email);     //Add a recipient


		    //Content
		    $mail->isHTML(true);                                  //Set email format to HTML
		    $mail->Subject = 'Email Verification From Prateek';  //subject field
		    $mail->Body    = "Thanks For Verification <b>Click link</b>  <a href='http://localhost/task/verify.php?email=$email&v_code=$v_code'>Verify</a>";  
		 

		    $mail->send();
		      return true;
		    } 
		    catch (Exception $e) {
		    	return false;
			}






		}




		if (isset($_REQUEST['submit'])) {
		    if ($_REQUEST['name'] == "" || $_REQUEST['email'] == "" || $_REQUEST['mobile'] == "") {
		        echo "<small>Fill all Fields</small><hr>";
		    } else {
		        $name = $_REQUEST['name'];
		        $email = $_REQUEST['email'];
		        $mobile = $_REQUEST['mobile'];
		        $address = $_REQUEST['address'];
		        $v_code = bin2hex(random_bytes(16)); 

		        $sql = "INSERT INTO users (name, email, mobile, address, verification_code, is_verified) VALUES (?, ?, ?, ?, ?, '0')";

		        $add_user = $conn->prepare($sql);
		        $add_user->execute([$name, $email, $mobile, $address, $v_code]);


		        if ($add_user && sendMail($_REQUEST['email'], $v_code))
		        {
		        	echo "<script>
		        	    alert('Add user successfully! Check your Email for Verification');
		        	    window.location.href='index.php';
		        	    </script>";
		        }
		        else{
		        	echo "<script>
		        	    alert('Server');
		        	    window.location.href='index.php';
		        	    </script>";
		        }

		        


		    }
		}
?>





<html>
<head>
	<link href="style.css" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">
	<script>
		function ValidateEmail() {
  			if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(addform.email.value)) {
      			return true;
  			}
  			else{
     			alert("You have entered an invalid email address!");
     			return false;
    }
}
	</script>
	<title>Add User</title>
</head>
<body>
	<div class="outer">
		<h1 align="center" style="font-size: 70px; color:white;">
			Add Users <a href="index.php">Home</a>
		</h1>

		<div class="formDiv">
    		<form name="addform" action="#" onsubmit="return validateForm()" method="post">
			      <div class="input-box">
			        <input type="text" placeholder="Enter name" name="name" id="name" required/>
			      </div>

			      <div class="input-box">
			        <input type="text" placeholder="Enter email" name="email" id="email" required>
			      </div>

			      <div class="input-box">
			        <input type="number" placeholder="Enter mobile No" name="mobile" id="mobile" required>
			      </div>

			      <div class="input-box">
			        <input type="textarea" placeholder="Enter Address" name="address" id="address" required>
			      </div>

			      <div class="input-box button">
			        <input type="Submit" value="Add User" name="submit" onclick="return ValidateEmail()">
			      </div>

			      <div class="text">
			        <h3>Want to see Users? <a href="view.php">View Users</a></h3>
			      </div>
            </form>
		</div>
	</div>
</body>
</html>
<?php $conn = null;?>