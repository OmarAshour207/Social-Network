<?php
include("includes/database.php");
if(isset($_POST['signup']))
	{

		$first_name = mysqli_real_escape_string($con,$_POST['fname']);
		$last_name = mysqli_real_escape_string($con,$_POST['lname']);
		$pass = mysqli_real_escape_string($con,md5($_POST['pass']));
		$E_mail = mysqli_real_escape_string($con,$_POST['mail']);
		$day = $_POST['day'];
		$month = mysqli_real_escape_string($con,$_POST['month']);
		$year = mysqli_real_escape_string($con,$_POST['year']);
		$gender = $_POST['Gender'];
		$statu = "unverified";
		$post = "No";

		$verfication_code = mt_rand();

		$get_email = "SELECT * FROM users WHERE user_email = '$E_mail'";
		$run_email = mysqli_query($con , $get_email);
		$check = mysqli_num_rows($run_email);


		if($check == 1)
		{
			echo "<script>alert(' This E-mail is already Registered ')</script>";
			exit();
		}
		// if(strlen($pass) < 8)
		// {
		// 	echo "<script> alert(' This Password is very Weak ')</script>";
		// 	exit();
		// }
		else
		{
            $full_name = $first_name . ' ' . $last_name;
            $full_date = $day.'-'.$month.'-'.$year;
            $insert_user = " INSERT INTO `users` (`user_name`, `user_password`, `user_email`, `user_gender`, `user_bitrhday`, `user_image`, `register_date`, `last_login`, `status`, `ver_code`, `posts`) VALUES ('$full_name', '$pass', '$E_mail', '$gender', '$full_date', 'default.jpg', NOW(), NOW(), '$statu', '$verfication_code',$post')";

			$run_insert = mysqli_query($con,$insert_user);
			if($run_insert)
			{
				$_SESSION['user_email'] = $E_mail;
				// header("Location:Home.php");
				echo "<h3> Hi $full_name , registration almost complete </h3> we have sent an email to $E_mail, please check your inbox";
				echo "<script> window.open('Home.php','_self') </script>";
			}
		}
		$full_name = $first_name . ' ' . $last_name;
		$to 		= $email;
		$subject	= "Verify your email address";
		$message 	= "
		<html>
			Hello <strong> $full_name </strong> you have created an account on www.social_network/verify.php.com, please verify your email by clicking the link below link: <a href='http://www.onlinetuting.com/social_network?code=$verfication_code'>Click to Verify your Email</a> </br>
			<strong> thank you for visiting us </strong>

		</html>
		";
		// Always set content-type when sending HTML email
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

		// More headers
		$headers .= 'From: <admin@social.com>' . "\r\n";
		
		mail($to,$subject,$message,$headers);
	}