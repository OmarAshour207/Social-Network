
<?php
session_start();
include("../includes/database.php");
include("functions.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title> Welcome User</title>
	<link rel="stylesheet" href="../style/Home_style.css" media="all"/>
</head>
<body>
	<div class="container">
		<!-- Head Wrap Starts -->
		<div id="head_wrap">
			<!-- Header starts -->
			<div id="header">
				<ul id="menu">
					<li><a href="../Home.php">Home </a> </li>
					<li><a href="../members.php">Members </a> </li>
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
				<form method="get" action="../result.php" id="form1">
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
						<center> <img src='../user/user_images/$user_image' width='200px' height='200px'/> </center>
						<div id='user_mention'>
						<p> <strong> Name: </strong> $user_name </p>
						<p> <strong> Last Login: </strong> $last_login </p>
						<p> <strong> Member Since: </strong> $register_date </p>

						<p> <a href='../my_messages.php?u_id=$user_id'> My Messages </a> </p>
						<p> <a href='../my_posts.php?u_id=$user_id'> My Posts ($posts) </a> </p>
						<p> <a href='../edit_profile.php?u_id=$user_id'> Edit My Account </a> </p>
						<p> <a href='../logout.php'> Log Out </a> </p>
						</div>

					";
				?>	
				</div>
			</div>
			<!-- User timeline ends -->
			<!-- content timeline starts -->
			<div id="content_timeline">
				<?php
					if(isset($_GET['post_id']))
					{
						$get_id = $_GET['post_id'];
						$select_post = "SELECT * FROM posts WHERE post_id='$get_id'";
						$run_post = mysqli_query($con,$select_post);
						$row = mysqli_fetch_array($run_post);

						$post_title = $row['post_title'];
						$post_con = $row['post_content'];

					}
				?>

				<form action="" method="post" id="f">
					<h2> Edit Your Post </h2>
					<input type="text" name="title" value="<?php echo $post_title; ?>" >  <br>
					<textarea cols="70" rows="4" name="content"> <?php echo $post_con; ?> </textarea><br>
					<select name="topic">
						<option> Select Topic </option>
						<?php
							getTopics();
						 ?>
					</select>
					<input type="submit" name="update_post" value="Update"/>
				</form>

				<?php
					// update_post();
					if(isset($_POST['update_post']))
						{
							$new_title = $_POST['title'];
							$new_con = $_POST['content'];
							$new_topic = $_POST['topic'];

							$new_post = "UPDATE posts SET post_title='$new_title' , post_content='$new_con' , topic_id='$new_topic' WHERE post_id='$get_id' ";
							$run_update = mysqli_query($con,$new_post);
							
							if($run_update)
							{
								echo "<script> alert('Post has been updated') </script>";
							    echo "<script> window.open('../Home.php','_self') </script>";
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
