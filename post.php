<?php
session_start();
$user_id = $_SESSION['user_id']; 
$name=$_SESSION["name"];
$email=$_SESSION['email'];
//- if no value in $dir go to login page
if($user_id=="" && $email==""){
    echo '<script language="Javascript">';
    echo 'document.location.replace("./main.php")'; // -->
    echo '</script>';
}
?>
<?php
include 'config.php';
?>

<!DOCTYPE html>
<html>
<head>
	<title>Make a Post</title>
	<link rel="stylesheet" type="text/css" href="design.css">
</head>
<body>

	<div class="status">
		<div class="status-name">
			<center><h1>!...Make Your Own Posts...!</h1></center>
			<div class="status-content">
				<form action="" method="Post" enctype="multipart/form-data" onsubmit="return validation()">
					<label>Title of Your Post :</label>
					<input type="text" name="title" id="title">
					<label>SOmething about Your Post :</label>
					<input type="textarea" name="about" id="about" style="height: 200px;">
					<label>Image :</label>
					<input type="file" name="filetoupload" id="filetoupload">
					<input type="submit" name="insert">
				</form>
			</div>
		</div>
	</div>

	<?php
	error_reporting(E_ALL);
	if (isset($_POST['insert'])) {

	$title=addslashes($_POST['title']);
    $about=addslashes($_POST['about']);
	
	if(isset($_FILES['filetoupload'])){
      //------- convert image to base64_encode------------------
		
      $image_path = $_FILES["filetoupload"]["tmp_name"]; //this will be the physical path of your image
      if($image_path!=""){
      $img_binary = fread(fopen($image_path, "r"), filesize($image_path));
      $picture = base64_encode($img_binary);
      
	echo $email;	    
	  		$q="INSERT INTO post (user_id,title,about,picture) VALUES ('$user_id','$title','$about','$picture')";
		     	if($db->query($q)==true){
		     		echo"inserted successfully";
		     		echo '<script language="Javascript">';
			        echo 'document.location.replace("./yourpost.php")'; // -->
			        echo '</script>';
		     	}
		     	else{
		     		echo $db->error;
		     	}
	  		}
	  	}
	}

	
 			


?>

<script type="text/javascript">
	function validation(){
		var formData = new FormData();
		var file = document.getElementById("filetoupload").files[0];

			   formData.append("Filedata", file);
			   var t = file.type.split('/').pop().toLowerCase();
			   	if (t != "jpeg" && t != "jpg" && t != "png" && t != "bmp" && t != "gif") {
			       alert('Please select a valid image file');
			       document.getElementById("filetoupload").value = '';
			       return false;
			   	}
			  	if (file.size > 300000) {
			       alert('Max Upload size is 300kB only');
			       document.getElementById("filetoupload").value = '';
			       return false;
			   	}if(file && file.style) {
				    file.style.height = '100px';
				    file.style.width = '200px';
				}
			   return true;

			} 

</script>

</body>
</html>