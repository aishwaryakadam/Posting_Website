<?php
session_start();
$user_id = $_SESSION['user_id']; 
$name=$_SESSION["name"];
$email=$_SESSION['email'];
//- if no value in $dir go to login page
if($user_id=="" && $name=="" && $email==""){
    echo '<script language="Javascript">';
    echo 'document.location.replace("./main.php")'; // -->
    echo '</script>';
}

include 'config.php';
?>

<!DOCTYPE html>
<html>
<head>
	<title>Edit your Profile</title>
	<link rel="stylesheet" type="text/css" href="design.css">
</head>
<body>
	<?php

      $result = mysqli_query($db, "SELECT * FROM user_register WHERE id = '$user_id'");
      $row = mysqli_num_rows($result);
      if($row>0){
        while($rows = mysqli_fetch_assoc($result)) {
      	$user_id= $rows["id"];
      	$username=$rows['username'];
		$address=$rows['address'];
	    $bday=$rows['birthdate'];
	    $picture=$rows['image'];
	    $mobile=$rows['mobileno'];
	   
?>
	<div class="edit-profile">
		<div class="back-btn1">
  			<button id="myBtn1">Want to Change Account Details...?</button>
  			<a href="yourpost.php">Back</a>
			<div id="myModal1" class="modal1">
				<span class="close">&times;</span>
				<div class="modal-content1">
				    <form action="" method="post">
				    	<label>Your new Email :</label>
				    	<input type="text" name="email" id="email">
				    	<label>Enter your New Password :</label>
				    	<input type="password" name="password1" id="password1">
				    	<label>COnfirm Password :</label>
				    	<input type="password" name="password2" id="password2">
				    	<input type="submit" name="editpass">
				    </form>
				</div>
			</div>
 		</div><br><br>
		<div class="edit-own">
			<center><h1>Edit Your Profile</h1></center>
			<div class="edit-form">
				<div class="edit-img">
					<center><?php echo "<h3>Uploaded Image</h3><img src=data:image/jpg;base64,$picture>"; ?></center>
				</div>
				<form action="" method="post" enctype="multipart/form-data" onsubmit="return validation()">
					<label>Choose Your Profile Photo</label>
			    	<input type="file" name="filetoedit" id="filetoedit">
			    	<label>Enter your Name :</label>
			    	<input type="text" name="name" id="name" value="<?php echo $username; ?>">
			    	<label>Enter your Address:</label>
			    	<input type="text" name="address" id="address" value="<?php echo $address; ?>">
			    	<label>Enter your Birthdath</label>
			    	<input type="date" name="bday" id="bday" value="<?php echo $bday; ?>">
			    	<label>Enter your Mobile No.:</label>
			    	<input type="number" name="mobile" id="mobile" value="<?php echo $mobile; ?>">
			    	<input type="submit" name="editpro">
				</form>
			</div>
		</div>
	</div>
	<?php
}
}
if (isset($_POST['editpro'])) {
	echo "string";
	$name=$_POST['name'];
	$address=$_POST['address'];
    $bday=$_POST['bday'];
    $mobile=$_POST['mobile'];


	if (isset($_FILES['filetoedit'])) {
		$image_path = $_FILES["filetoedit"]["tmp_name"]; //this will be the physical path of your image
	    if($image_path!=""){
		    $img_binary = fread(fopen($image_path, "r"), filesize($image_path));
		    $picture = base64_encode($img_binary);

		    $q="UPDATE user_register SET username='$name',address ='$address' ,birthdate='$bday',image='$picture',mobileno='$mobile' WHERE id='$user_id'";
		}else{

			$q="UPDATE user_register SET username='$name',address ='$address' ,birthdate='$bday',mobileno='$mobile' WHERE id='$user_id'";
		}
		     	if($db->query($q)==true){

		     		echo "inserted successfully";
		     		echo '<script language="Javascript">';
			        echo 'document.location.replace("./yourpost.php")'; // -->
			        echo '</script>';
		     	}
		     	else{
		     		echo $db->error;
		     	}
		    }
		}
	if (isset($_POST['editpass'])) {
	$email=$_POST['email'];
	$password=$_POST['password1'];


	 $pass="UPDATE user_register SET email='$email',password='$password' WHERE id='$user_id'";
	 if($db->query($pass)==true){
	 		echo "inserted successfully";
	 		echo '<script language="Javascript">';
	        echo 'document.location.replace("./logout.php")'; // -->
	        echo '</script>';
	 	}
	 	else{
	 		echo $db->error;
	 	}

	}

	?>
	<script type="text/javascript">
		function validation(){ 
		var password1=document.getElementById('password1').value;
		var password2=document.getElementById('password2').value;
		var email=document.getElementById('email').value;

		var atposition=email.indexOf("@");  
		var dotposition=email.lastIndexOf("."); 	 

		if (atposition<1 || dotposition<atposition+2 || dotposition+2>=email.length){  
		alert("Please enter a valid e-mail address");  
		 return false;  
		}elseif(password1!=password2){    
		alert("password must be same!");  
		return false;  
		}else if(password1.length<6){  
		 alert("Password must be at least 6 characters long.");  
		 return false; 
		} 
	}
</script>
<script type="text/javascript">
		// Get the modal
		var modal1 = document.getElementById("myModal1");

		// Get the button that opens the modal
		var btn = document.getElementById("myBtn1");

		// Get the <span> element that closes the modal
		var span = document.getElementsByClassName("close")[0];

		// When the user clicks the button, open the modal 
		btn.onclick = function() {
		  modal1.style.display = "block";
		}

		// When the user clicks on <span> (x), close the modal
		span.onclick = function() {
		  modal1.style.display = "none";
		}

		// When the user clicks anywhere outside of the modal, close it
		window.onclick = function(event) {
		  if (event.target == modal1) {
		    modal1.style.display = "none";
		  }
		}
	</script>
</body>
</html>