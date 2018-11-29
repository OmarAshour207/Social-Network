<?php
include("includes/database.php");
global $con;
if(isset($_POST['login']))
{
	$email = mysqli_real_escape_string($con,$_POST['mail']);
	$pass = mysqli_real_escape_string($con,$_POST['pass']);


	$get_user = "SELECT * FROM users WHERE user_email='$email' AND user_password='$pass' AND status='verified'";
	$run_user = mysqli_query($con , $get_user);
	$check = mysqli_num_rows($run_user);

	if($check == 1)
	{
		session_start();
		$_SESSION['user_email'] = $email;
		echo "<script> window.open('Home.php','_self') </script>";
	}
	else
	{
		echo "<script> alert('Password or E-mail is not correct!')</script>";
	}
}
?>