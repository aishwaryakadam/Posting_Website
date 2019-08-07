

<!DOCTYPE html>
<html>
<head>
	<title>Information About post</title>
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
      	$user_id=$rows['user_id'];
		$title=$rows['title'];
	    $about=$rows['about'];
	    $picture=$rows['picture'];
	    $date=$rows['dateofpost'];
	    $q=mysqli_query($db,"SELECT username FROM user_register WHERE id='$user_id'");
				$num=mysqli_num_rows($q);
				if ($num>0) {
					while ($pic=$q->fetch_assoc()) {
						$username=$pic['username'];	

	   
      
  ?>

	<div class="display-container">
		<div class="back-btn">
  			<a href="main.php">Back</a>
 		</div><br>
		<div class="display-heading">
			<h1><?php echo $title; ?></h1>
		</div>
		<div class="display-image">
			<?php echo "<center><img src=data:image/jpg;base64,$picture></center>"; ?>
		</div>
		<div class="display-about">
			<?php echo $about; ?>
		</div>
		<div class="display-footer">
			<p>Posted By : <?php echo $username; ?></p>
			<p>Date of Post : <?php echo $date; ?></p>
		</div>
	</div>
	<?php
}
}
}
}
}
	?>
</body>
</html>