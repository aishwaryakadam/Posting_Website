<?php
session_start();
include 'config.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>New Password</title>
	<link rel="stylesheet" type="text/css" href="design.css">
</head>
<body>
	<div class="forget">
		<div class="forget-form">
			<center><h1>!...Enter the details...!</h1></center>
			<form action="" method="Post" enctype="multipart/form-data">
				<label>Enter Your Email :</label>
				<input type="text" name="email" id="email">
				<label>What is your Birthdate:</label>
				<input type="date" name="bday" id="bday">
				<input type="submit" name="forget">
			</form>
		</div>
	</div>
	<?php
	if (isset($_POST['forget'])) {
		$email=addslashes($_POST['email']);
		$bday=addslashes($_POST['bday']);
		$result = mysqli_query($db, "SELECT email,birthdate FROM user_register WHERE email='$email' and birthdate='$bday'");
		$row = mysqli_num_rows($result);
		if ($row==0) {
			echo "This is not Right";
		}
		else{
			while($rows = mysqli_fetch_assoc($result)) {
		      	$email= $rows["email"];
		      	$password=$rows['password'];
				echo 'Right info';

				$to = $email;
				$subject = "Your Password is ".$password;
				$txt = "Hello world!";
				$headers = "From: kadamaish23@gmail.com" . "\r\n" .
				"CC: somebodyelse@example.com";

				if(mail($to,$subject,$txt,$headers)){
					echo "Mail is send to you";
				}else{
					echo "Mail is not send,Retry again.....";
				}
			}

		}
	}

	?>
</body>
</html>
