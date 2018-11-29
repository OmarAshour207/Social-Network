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
					$user_image = $row['user_image'];
					$register_date = $row['register_date'];
					$last_login = $row['last_login'];

					$user_posts = "SELECT * FROM posts WHERE user_id='$user_id' ";
					$run_posts = mysqli_query($con,$user_posts);
					$posts = mysqli_num_rows($run_posts);

					echo "
						<center> <img src='user/user_images/$user_image' width='200px' height='200px'/> </center>
						<div id='user_mention'>
						<p> <strong> Name: </strong> $user_name </p>
						<p> <strong> Last Login: </strong> $last_login </p>
						<p> <strong> Member Since: </strong> $register_date </p>

						<p> <a href='my_messages.php?u_id=$user_id'> My Messages () </a> </p>
						<p> <a href='my_posts.php?u_id=$user_id'> My Posts ($posts) </a> </p>
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
				<?php
					if(isset($_GET['u_id']))
					{
						$u_id = $_GET['u_id'];
						
						$sel = "SELECT * FROM users WHERE user_id='$u_id' ";
						$run = mysqli_query($con,$sel);
						$row = mysqli_fetch_array($run);

						$user_name = $row['user_name'];
						$user_image = $row['user_image'];
						$register_date = $row['register_date'];
					}
				?>

				<h2> Send a Message to <span style="color: red;"> <?php echo $user_name; ?> </span> </h2>
				<form action="messages.php?u_id=<?php echo $u_id; ?>" method="post" id="f" >
					<input type="text" name="msg_title" placeholder="Message Subject..." size="49">
					<textarea name="msg" cols="50" rows="5"  placeholder="Message Topic..." ></textarea><br>	
					<input type="submit" name="message" value="Send Message">
				</form><br>
				<img src="user/user_images/<?php echo $user_image; ?>" style="border: 2px solid blue; border-radius: 5px; " width="100" height="100" >
				<p><strong> <?php echo $user_name; ?> </strong> is member of this site since: <?php echo $register_date; ?> </p>
			</div>

			<!-- Content Timeline Ends -->
			<?php
				if(isset($_POST['message']))
				{
					$msg_title = $_POST['msg_title'];
					$msg_content = $_POST['msg'];

					$insert = "INSERT INTO messages (sender,receiver,msg_subject,msg_topic,reply,status,msg_date) VALUES 
													('$user_id','$u_id','$msg_title','$msg_content','No_Reply','unread',NOW()) ";
					$run_insert = mysqli_query($con,$insert);
					
					if($run_insert)
					{
						echo "<center> <h2> Message was sent to ". $user_name . " Successfully </h2> </center>" ;
					}
					else
					{
						echo "<center> <h2> Message was not sent..! </h2> </center>";	
					}								
				}
			?>
		</div>

	    <!-- Content Area Ends -->
	    <div id="footer">
	    	<h2>&copy;2018-www.online.com</h2>
	    </div>
	</div> 
	   <!-- Container Ends -->  

</body>
</html>
