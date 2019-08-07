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

require 'config.php';
      if((!isset($_GET['id']))||trim($_GET['id'])==""){
      echo "No post like that !";
      }else{

$del_id=$_GET['id'];

$sql = "DELETE FROM post WHERE id='$del_id'";

if ($db->query($sql) === TRUE) {
    echo "Record deleted successfully";
    echo '<script language="Javascript">';
        echo 'document.location.replace("./yourpost.php")'; // -->
        echo '</script>';
} else {
    echo "Error deleting record: " . $db->error;
}

}

?>