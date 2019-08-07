<?php

include 'connection.php';
?>

<!DOCTYPE html>
<html>
<head>
	<title>Sign Up</title>
	<link rel="stylesheet" type="text/css" href="design.css">
</head>
<body>
	<div class="register">
		<div class="signup-text">
			<center><h1>Sign Up</h1></center><br>
			<div class="signup-form">
			    <form action="" method="post" accept="image/*" enctype="multipart/form-data" onsubmit="return validation()">
			    	<label>Enter your Name :</label>
			    	<input type="text" name="name" id="name"/>
			    	<label>Enter your Address:</label>
			    	<input type="text" name="address" id="address"/>
			    	<label>Enter your Birthdath</label>
			    	<input type="date" name="bday" id="bday"/>
			    	<label>Choose Your Profile Photo</label>
			    	<input type="file" name="profileimage" id="profileimage" required/>
			    	<label>Enter your Mobile No.:</label>
			    	<input type="text" name="mobile" id="mobile"/>
			    	<label>Enter your Email:</label>
			    	<input type="text" name="email" id="email"/>
			    	<label>Password :</label>
			    	<input type="password" name="password1" id="password1"/>
			    	<label>Confirm Password :</label>
			    	<input type="password" name="password2" id="password2"/>
			    	<input type="submit" name="signup"/>
			    </form>
			</div>
		</div>
	</div>


	<?php
error_reporting(E_ALL);
//ini_set('display_errors', 1);
if(isset($_POST['signup'])){// When user click on a button
    $name=$_POST['name'];
    $address=$_POST['address'];
    $bday=$_POST['bday'];
    $mobile=$_POST['mobile'];
    $email=$_POST['email'];
    $password1=$_POST['password1'];

	if(isset($_FILES['profileimage']['name']) && !empty($_FILES['profileimage']['name'])) {
        //Allowed file type
        $allowed_extensions = array("jpg","jpeg","png","gif");
    
        //File extension
        $ext = strtolower(pathinfo($_FILES['profileimage']['name'], PATHINFO_EXTENSION));
    
        //Check extension
        if(in_array($ext, $allowed_extensions)) {
           //Convert image to base64
        $encoded_image = base64_encode(file_get_contents($_FILES['profileimage']['tmp_name']));
        $encoded_image = 'data:image/' . $ext . ';base64,' . $encoded_image;
      $password=md5($password1);
      echo $encoded_image;
	  	
	  	$q=mysqli_query($db, "INSERT INTO User (name,address,bday,picture,mobileno,email,password) VALUES ('$name','$address','$bday','$encoded_image','$mobile','$email','$password')");

	  	if ($q) {
	  		echo "string";
	  	}
	  	echo $password;
	  }
	}
}
?>
	<script type="text/javascript">
		function validation(){ 

		var name=document.getElementById('name').value;
		var address=document.getElementById('address').value;
		var mobile=document.getElementById('mobile').value;
		var email=document.getElementById('email').value;	 
		var password1=document.getElementById('password1').value;
		var password2=document.getElementById('password2').value;

		var formData = new FormData();
		var atposition=email.indexOf("@");  
		var dotposition=email.lastIndexOf("."); 

		if (name==null || name==""){  
		 alert("Name can't be blank");  
		 return false;  
		}if (address==null || address==""){  
		 alert("Address can't be blank");  
		 return false;  
		}else if (mobile==null || mobile==""){  
		 alert("Mobile number can't be blank");  
		 return false;  
		}else if(mobile.length<10){  
		 alert("mobile must be at least 10 characters long.");  
		 return false; 
		}else if (atposition<1 || dotposition<atposition+2 || dotposition+2>=email.length){
		 alert("Please enter a valid e-mail address");  
		 return false;  
		}else if(password1!=password2){    
		alert("password must be same!");  
		return false;  
		}else if(password1.length<6){  
		 alert("Password must be at least 6 characters long.");  
		 return false; 
		} 
		//Image validation
		var file = document.getElementById("fileToUpload").files[0];

		   formData.append("Filedata", file);
		   var t = file.type.split('/').pop().toLowerCase();
		   if (t != "jpeg" && t != "jpg" && t != "png" && t != "bmp" && t != "gif") {
		       alert('Please select a valid image file');
		       document.getElementById("fileToUpload").value = '';
		       return false;
		   }
		   if (file.size > 300000) {
		       alert('Max Upload size is 300KB only');
		       document.getElementById("fileToUpload").value = '';
		       return false;
		   }
		   return true;

		}  
		</script>
</body>
</html>