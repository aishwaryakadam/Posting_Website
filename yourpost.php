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
<?php
include 'config.php';
?>


<!DOCTYPE html>
<html>
<head>
	<title>Welcome to Quick Post</title>
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="design.css">
</head>
<body>
<?php
include 'menu.php';
?>
	<div class="header">
			<h1>....Welcome <?php echo $name ;?>....</h1>
		</div>
	<div class="container-news">
		
	<?php

		$sql = mysqli_query($db,"SELECT * FROM post WHERE user_id='$user_id'");
		$num_rows=mysqli_num_rows($sql);
		
		if ($num_rows==0) {
			echo "Let's start Posting.........!";
		}
		else{
			while ($rows=$sql->fetch_assoc()) {
				$id=$rows['id'];
				$title=$rows['title'];
			    $about=$rows['about'];
			    $picture=$rows['picture'];
			    $date=$rows['dateofpost'];
		?>
		
		
			<div class="news">
				<div class="title-news">
					<h2><?php echo $title ;?></h2>
				</div>
				<div class="news-img">
					<?php echo "<img src=data:image/jpg;base64,$picture>";?>
				</div>
				<div class="news-text">
					<p><?php echo substr( $about,0,200)."<br>";?></p>
				</div>
				<div class="news-footer">
					<p><a href="editpost.php?id=<?php echo $id; ?>">Edit...<i class="fa fa-eraser" aria-hidden="true"></i></a></p>
					<p><a href="deletepost.php?id=<?php echo $id; ?>">Delete...
					<i class="fa fa-trash" aria-hidden="true"></i></a></p>
				</div>
			</div>
		
	<?php
	}
}
?>
</div>

</body>
</html>