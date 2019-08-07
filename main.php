<?php
@ob_start();
session_start();

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
	<div class="heading">
		<div class="login">
			<button id="myBtn">Sign In</button>
			<div id="myModal" class="modal" style="height: 50%;">
				<span class="close">&times;</span>
				<div class="modal-content">
				    <form action="" method="post">
				    	<label>Enter your Email:</label>
				    	<input type="text" name="email" id="email">
				    	<label>Password :</label>
				    	<input type="password" name="password" id="password">
				    	<input type="submit" name="signin">
				    	<a href="forgetpass.php">forget password?</a>
				    	<p>If you don't have account</p>
				    	<button id="myBtn"><a href="signup.php">Sign Up</a></button>
				    </form>
				</div>
			</div>
		</div>
		<div class="header">
			<h1>....WHat'S NeW ToDaY....</h1>
		</div>
		<div class="container-news">
		<?php
		$perpage=6;
		if (isset($_GET['page'])) {
			$page=intval($_GET['page']);
		}else{
			$page=1;
		}
		$calc=$perpage*$page;
		$start=$calc-$perpage;


		$sql = mysqli_query($db,"SELECT * FROM post ORDER BY dateofpost DESC LIMIT $start,$perpage");
		$num_rows=mysqli_num_rows($sql);
		
		if ($num_rows==0) {
			echo "No post ....!";
		}
		else{
			$i=0;
			while ($rows=$sql->fetch_assoc()) {
				$id=$rows['id'];
				$user_id=$rows['user_id'];
				$title=$rows['title'];
			    $about=$rows['about'];
			    $picture=$rows['picture'];
			    $date=$rows['dateofpost'];
				$q=mysqli_query($db,"SELECT username FROM user_register WHERE id='$user_id'");
				$num=mysqli_num_rows($q);
					if ($num>0) {
						while ($pic=$q->fetch_assoc()) {
							$name=$pic['username'];	

		?>
			<div class="news">
				<div class="title-news">
					<h2><?php echo $title ;?></h2>
				</div>
				<div class="news-img">
					<?php echo "<img src=data:image/jpg;base64,$picture>";?>
				</div>
				<div class="news-text">
					<p><?php echo substr($about,0,100);?><br><a href="display.php?id=<?php echo $id; ?>"> read more ....</a></p>
				</div>
				<div class="news-footer">
					<p>posted by:<?php echo $name ;?></p>
					<p>date:<?php echo $date ;?></p>
				</div>
			</div>
		
			<?php
			}
		}
	}
}
?>
</div>
</div>

<?php
	error_reporting(E_ALL);
		if(isset($_POST["signin"]))
		{
		 
		if(count($_POST)>0) 
		{
		 
		$emailid = $_POST["email"];

		$password = $_POST["password"];
		//$sql="SELECT * FROM user_register WHERE address='$email' and password='$password'";
		$result = mysqli_query($db,"SELECT * FROM user_register WHERE email='$emailid' and password='$password'");

		$num_rows=mysqli_num_rows($result);
		echo $num_rows;
			if ($num_rows>0) {
				echo $num_rows;
				while ($rows=$result->fetch_assoc()) {
					$user_id=$rows['id'];
					$name=$rows['username'];
					$email=$rows['email'];
		     		echo $name;
		     		
			        $_SESSION["user_id"] = $user_id;
					$_SESSION["name"] = $name;
					$_SESSION["email"] = $email;
					echo "Valide User Login.";
					echo $name;
			        echo '<script language="Javascript">';
			        echo 'document.location.replace("./yourpost.php")'; // -->
			        echo '</script>';

			    }
			}
	     	else{
	     		echo $db->error;
	     	}

		}
	}
	if (isset($page)) {
		$result=mysqli_query($db,"SELECT Count(*) AS Total FROM post");
		$rows=mysqli_num_rows($result);
		if ($rows) {
			$rs=mysqli_fetch_assoc($result);
			$total=$rs["Total"];
		}
		$totalPages=ceil($total/$perpage);
		echo "<center>";
		echo "<div class='pagenation'>";
		if($page<=1){
			//echo "something";
		}else{
			$j=$page-1;
			echo "<a href='main.php?page=$j'>&laquo;</a>";
		}
		for ($i=1; $i <=$totalPages ; $i++) { 
			if ($i<>$page) {
				echo "<a href='main.php?page=$i'>$i</a>";
			}else{
				echo "<a class='disnum' href='main.php?page=$i' class='active'>$i</a>";
			}
		}
		if ($page==$totalPages) {
			//echo "somethonfg";
		}else{
			$j=$page+1;
			echo "<a href='main.php?page=$j'>&raquo;</a>";
			echo "</div>";
		}
		echo "</center>";

	}
?>




	<script>
		// Get the modal
		var modal = document.getElementById("myModal");

		// Get the button that opens the modal
		var btn = document.getElementById("myBtn");

		// Get the <span> element that closes the modal
		var span = document.getElementsByClassName("close")[0];

		// When the user clicks the button, open the modal 
		btn.onclick = function() {
		  modal.style.display = "block";
		}

		// When the user clicks on <span> (x), close the modal
		span.onclick = function() {
		  modal.style.display = "none";
		}

		// When the user clicks anywhere outside of the modal, close it
		window.onclick = function(event) {
		  if (event.target == modal) {
		    modal.style.display = "none";
		  }
		}
</script>

</body>
</html>