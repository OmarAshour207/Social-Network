<?php
session_start();
include("includes/database.php");
include("functions/functions.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title> Welcome User</title>
	<link rel="stylesheet" href="style/Home_style.css" media="all"/>
</head>
<body>
	<div class="container">
		<!-- Head Wrap Starts -->
		<div id="head_wrap">
			<!-- Header starts -->
			<div id="header">
				<ul id="menu">
					<li><a href="Home.php">Home </a> </li>
					<li><a href="members.php">Members </a> </li>
					<strong> Topics: </strong>
					<?php
						// getTopics();
					$get_topics = "SELECT * FROM topics";
					$run_topics = mysqli_query($con,$get_topics);

					while($row = mysqli_fetch_array($run_topics))
					{
						$topic_id = $row['topic_id'];
						$topic_title = $row['topic_title'];
						echo "<li> <a href='topics.php?topic=$topic_id'> $topic_title </a> </li> ";
					}
					?>

				</ul>
				<form method="get" action="result.php" id="form1">
					<input type="text" name="user_query" placeholder="Search a topic">
					<input type="submit" name="search" value="Search">
				</form>
			</div>
			<!-- Header Ends -->
		</div>
		<!-- Head Wrap ends -->

		<!-- Content Area starts -->
		<div class="content">
			<!-- User timeline starts -->
			<div id="user_timeline">
				<div id="user_details">
				<?php
					$user = $_SESSION['user_email'];
					$get_user = "SELECT * FROM users WHERE user_email = '$user'";
					$run_user = mysqli_query($con,$get_user);
					$row = mysqli_fetch_array($run_user);

					$user_id = $row['user_id'];

					$user_name = $row['user_name'];
					
					$name = explode(" ", $user_name);
					
					$user_email = $row['user_email'];
					
					$user_psswd = $row['user_password'];
					
					$gender = $row['user_gender'];
					
					$date = $row['user_bitrhday'];
					$dating = explode('-', $date);

					$user_image = $row['user_image'];
					$register_date = $row['register_date'];
					$last_login = $row['last_login'];

					echo "
						<center> <img src='user/user_images/$user_image' width='200' height='200'/> </center>
						<div id='user_mention'>
						<p> <strong> Name: </strong> $user_name </p>
						<p> <strong> Last Login: </strong> $last_login </p>
						<p> <strong> Member Since: </strong> $register_date </p>

						<p> <a href='my_messages.php?u_id=$user_id'> My Messages </a> </p>
						<p> <a href='my_posts.php?u_id=$user_id'> My Posts </a> </p>
						<p> <a href='edit_profile.php?u_id=$user_id'> Edit My Account </a> </p>
						<p> <a href='logout.php'> Log Out </a> </p>
						</div>

					";
				?>	
				</div>
			</div>
			<!-- User timeline ends -->
			<!-- content timeline starts -->
			<div id="content_timeline">
				<h2> Edit Your Profile </h2>
				<div class="signup">
		        
		        <form method="post" action="" id="f" class="ff" enctype="multipart/form-data">
		        	User Photo: <input type="file" name="u_image" value="Edit Image"><br>
		            First Name: <input type="text" id="first" name="fname" value="<?php echo $name[0]; ?>" ><br>
		            Last  Name: <input type="text" id="second" name="lname" value="<?php echo $name[1]; ?>" ><br>
		            User Email: <input type="email" id="mail" name="mail" value="<?php echo $user_email; ?>"><br>
		            Password :  <input type="password" name="pass" value="<?php echo $user_psswd; ?>"> <br>
		            <h3>Birthday </h3> 
		            <select name="day" disabled="disabled">
		            	<option> <?php echo $dating[2]; ?> </option>
		            	<?php
		            		for($Day = 1;$Day <= 31; $Day++)
		            		{
		            			echo "<option>" . $Day . "</option>";
		            		}
		            	 ?>
                    </select>
                    <select name="month" disabled="disabled">
                        <option> <?php echo $dating[1]; ?> </option>
                        <?php
                        	for($month = 1 ;$month < 13 ;$month++)
                        	{
                        		echo "<option>" . $month . "</option>";
                        	} 
                        ?>
                    </select>
                    <select name="year" disabled="disabled">
                        <option> <?php echo $dating[0]; ?> </option>
                        <?php
                        	for($year = 2018; $year >= 1900; $year--)
                        	{
                        		echo "<option>" . $year . "</option>";
                        	}
                        ?>
                    </select>
					<!-- <input type="date" name="u_birthday"> <br> -->
					<br>
					<select name='u_gender' >
						<option><?php echo $gender; ?> </option>
						<option> Male </option>
						<option> Female </option>
					</select><br>
		            <input type="submit" name="update" value="Update">
		            
		        </form>
		        <?php
		        	if(isset($_POST['update']))
		        	{
		        		$f_name = $_POST['fname'];
		        		$l_name = $_POST['lname'];
		        		$u_name = $f_name . ' ' . $l_name;
		        		$u_mail = $_POST['mail'];
		        		$u_pass = $_POST['pass'];
		        		$u_image = $_FILES['u_image']['name'];
		        		$image_tmp = $_FILES['u_image']['tmp_name'];
		        		$u_gender = $_POST['u_gender'];

		        		move_uploaded_file($image_tmp, "user/user_images/$u_image");

		        		$update = "UPDATE users SET user_name='$u_name', user_password='$u_pass', user_email='$u_mail', user_image='$u_image', user_gender='$u_gender' WHERE 
		        		user_id='$user_id' ";
		        		$run = mysqli_query($con,$update);

		        		if($run)
		        		{
		        			echo "<script> alert('Your Profile has been updated') </script>";
		        			echo "<script> window.open('Home.php','_self') </script>";
		        		}
		        	}
		        ?>
			</div>

			<!-- Content Timeline Ends -->
		</div>

	    <!-- Content Area Ends -->
	    <div id="footer">
	    	<h2>&copy;2018-www.online.com</h2>
	    </div>
	</div> 
	   <!-- Container Ends -->  

</body>
</html>
