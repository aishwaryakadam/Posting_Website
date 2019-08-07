<?php
include 'config.php';
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
			<center><h1>Sign Up</h1></center>
			<div class="signup-form">
			    <form action="" method="post" accept="image/*" enctype="multipart/form-data" onsubmit="return validation()">
			    	<label>Choose Your Profile Photo</label>
			    	<input type="file" name="fileToUpload" id="fileToUpload"/>
			    	<label>Enter your Name :</label>
			    	<input type="text" name="name" id="name"/>
			    	<label>Enter your Address:</label>
			    	<input type="text" name="address" id="address"/>
			    	<label>Enter your Birthdath</label>
			    	<input type="date" name="bday" id="bday"/>
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
	    if (file.size > 3000000) {
	        alert('Max Upload size is 2MB only');
	        document.getElementById("fileToUpload").value = '';
	        return false;
	    }
	    return true;

	}  
	</script>

	<?php
error_reporting(E_ALL);
	if (isset($_POST['signup'])) {

	$name=$_POST['name'];
	$address=$_POST['address'];
	$birthdate=$_POST['bday'];
	$mobileno=$_POST['mobile'];
    $emailid=$_POST['email'];
	$password=$_POST['password1'];
	
	if(isset($_FILES['fileToUpload'])){
      //------- convert image to base64_encode------------------
      $image_path = $_FILES["fileToUpload"]["tmp_name"]; //this will be the physical path of your image
      if($image_path!=""){
      $img_binary = fread(fopen($image_path, "r"), filesize($image_path));
      $picture = base64_encode($img_binary);

       $result = $db->query("SELECT email FROM user_register WHERE email='$emailid'");
  			if (($result->num_rows)>0) {
		  	  echo "Sorry... email already taken"; 	
		  	}else
	  		{

		      $q="INSERT INTO user_register (username,address,birthdate,image,mobileno,email,password) VALUES ('$name','$address','$birthdate','$picture','$mobileno','$emailid','$password')";
		     	if($db->query($q)==true){
		     		echo"inserted successfully";
		     		echo '<script language="Javascript">';
			        echo 'document.location.replace("./main.php")'; // -->
			        echo '</script>';

		     	}
		     	else{
		     		echo $db->error;
		     	}
	  		}
	  	}

	}
}



?>
</body>
</html>