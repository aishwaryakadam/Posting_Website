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
?>

<!DOCTYPE html>
<html>
<head>
	<title>Edit a Post</title>
	<link rel="stylesheet" type="text/css" href="design.css">
</head>
<body>

<?php
      include 'config.php';
      if((!isset($_GET['id']))||trim($_GET['id'])==""){
      echo "No post like that !";
      }else{

    $post_id = addslashes($_GET['id']);
      $result = mysqli_query($db, "SELECT * FROM post WHERE id = '$post_id'");
      $row = mysqli_num_rows($result);

      if($row>0){
        while($rows = mysqli_fetch_assoc($result)) {
      	$post_id= $rows["id"];
		$title=$rows['title'];
	    $about=$rows['about'];
	    $picture=$rows['picture'];
	    $date=$rows['dateofpost'];
	   
      
  ?>


	<div class="post">
		<div class="post-name">
			<div class="back-btn">
  					<a href="yourpost.php">Back</a>
 			</div><br>
			<center><h1>!...Edit Your Post...!</h1></center>
			<div class="post-edit">
				<div class="edit-profile">
					<center><?php echo "<h3>Uploaded Image</h3><img src=data:image/jpg;base64,$picture>"; ?></center>
				
				<form action="" method="Post" enctype="multipart/form-data">
					<label>Title of Your Post :</label>
					<input type="text" name="title" id="title" value="<?php echo $title; ?>">
					<label>SOmething about Your Post :</label>
					<textarea name="info" style="height: 100px;border-radius: 10px;width: 300px;" id="info" ><?php echo $about; ?></textarea> 
					<label>Image :</label>
					<input type="file" name="filetoedit" id="filetoedit">
					<input type="submit" name="edit">
				</form>
				</div>
			</div>
		</div>
	</div>
	<?php
}
}
}
if (isset($_POST['edit'])) {

	$title=addslashes($_POST['title']);
    $about=addslashes($_POST['info']);
	
	if (isset($_FILES['filetoedit'])) {
		$image_path = $_FILES["filetoedit"]["tmp_name"]; //this will be the physical path of your image
	    if($image_path!=""){
		    $img_binary = fread(fopen($image_path, "r"), filesize($image_path));
		    $picture = base64_encode($img_binary);

		    $q="UPDATE post SET title='$title',about ='$about',picture='$picture' WHERE id='$post_id'";
		}else{
			$q="UPDATE post SET title='$title',about ='$about' WHERE id='$post_id'";
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

	
	
	    
    
	?>
</body>
</html>
