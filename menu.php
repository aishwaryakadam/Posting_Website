<?php 
    include 'config.php';

?>
<?php

	$q=mysqli_query($db,"SELECT image FROM user_register WHERE id='$user_id'");
	$num=mysqli_num_rows($q);
	if ($num>0) {
	while ($pic=$q->fetch_assoc()) {
		$picture=$pic['image'];	

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="design.css">
</head>
<body>
	<ul>
  <li><a class="active" href="yourpost.php">Home</a></li>
  <li><a href="post.php">Make Post</a></li>
  <li><a href="editprofile.php">Edit Profile</a></li>
  <li><a href="logout.php">logout</a></li>
</ul>
<div class="right-dis"><?php echo "<img src=data:image/jpg;base64,$picture>";?></div>
<?php
}
}

?>
</body>
</html>