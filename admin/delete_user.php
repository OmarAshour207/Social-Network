<?php
	include("includes/database.php");
	if(isset($_GET['delete']))
	{
		$user_id     = $_GET['delete'];

		$delete_user = "DELETE FROM `users` WHERE `user_id` = '$user_id'";
		$run_delete  = mysqli_query($con, $delete_user);

		$delete_post = "DELETE FROM `posts` WHERE `user_id` = '$user_id'";
		$run_post	 = mysqli_query($con, $delete_post);

		echo "<script> alert('User Deleted!') </script>";
		echo "<script> window.open('index.php?view_users','_self')</script>";	
	}


?>