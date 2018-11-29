<?php
	include("includes/database.php");
	if(isset($_GET['code']))
	{
		$get_code 	= $_GET['code'];
		$get_user 	= "SELECT * FROM `users` WHERE `ver_code` = '$get_code'";
		$run_user 	= mysqli_query($con, $get_user);
		$check_user = mysqli_num_rows($run_user);
		$row_user   = mysqli_fetch_array($run_user);
		$user_id    = $row_user['user_id'];

		if($check_user == 1)
		{
			$update_status = "UPDATE `users` SET `status` = 'verified' WHERE `user_id` = '$user_id'";
			$run_update    = mysqli_query($con, $update_status);
			echo "<h2>Thanks, your Email is verified </h2> Please <a href='http://www.onlinetuting.com/social_network'> Login to our website</a>";
			header("Location: Home.php");
		}
		else
		{
			echo "<h2> sorry, Email not verified, try again </h2>";
		}
	}

?>