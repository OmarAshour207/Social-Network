<?php
session_start();
include("includes/database.php");
include("functions/functions.php");
// if(!isset($_SESSION['user_email']))
// {
// 	header("location: index.php");
// }
// else
// {

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
				<form method="post" action="result.php" id="form1">
					<input type="text" name="search_box" placeholder="Search a topic">
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

					echo "
						<center> <img src='user/user_images/$user_image' width='200px' height='200px'/> </center>
						<div id='user_mention'>
						<p> <strong> Name: </strong> $user_name </p>
						<p> <strong> Last Login: </strong> $last_login </p>
						<p> <strong> Member Since: </strong> $register_date </p>

						<p> <a href='my_messages.php'> Messages </a> </p>
						<p> <a href='my_posts.php'> Posts </a> </p>
						<p> <a href='edit_profile.php'> Edit My Account </a> </p>
						<p> <a href='logout.php'> Log Out </a> </p>
						</div>

					";
				?>	
				</div>
			</div>
			<!-- User timeline ends -->
			<!-- content timeline starts -->
			<div id="content_timeline">
				<form action="Home.php?id=<?php echo $user_id ; ?>" method="post" id="f">
					<h2> What's in your mind </h2>
					<input type="text" name="title" placeholder="Write Title!"> <br>
					<textarea cols="70" rows="4" name="content" placeholder="Write here"></textarea><br>
					<select name="topic">
						<option> Select Topic </option>
						<?php
							getTopics();
						 ?>
					</select>
					<input type="submit" name="post" value="Post">
				</form>
				<?php
					InsertPosts();
				?>
				
				<h3> All Posts in this category </h3>
				<?php get_cats(); ?>
				
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
