<?php
 include("../functions/functions.php"); 
 session_start();

 if(!isset($_SESSION['admin_email']))
 {
 	header("Location: admin_login.php");
 }
 else {
 ?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Admin Panel</title>
	<link rel="stylesheet" type="text/css" href="admin_style.css" media="all">
</head>
<body>
	<div class="container">
		<div id="head">
			<a href="index.php"><img src="images/logo.png" alt="logo panel"> </a>
		</div>

		<div id="sidebar">
			<h2>Manage Content:</h2>
			<ul id="menu">
				<li><a href="index.php?view_users">    View Users 		</a> </li>
				<li><a href="index.php?view_posts">    View Posts 		</a> </li>
				<li><a href="index.php?view_comments"> View Comments 	</a> </li>
				<li><a href="index.php?view_topics">   View Topics 		</a> </li>
				<li><a href="index.php?add_topic"> 	   Add New Topic    </a> </li>
				<li><a href="admin_logout.php"> 	   Admin Logout 	</a> </li>
			</ul>
		</div>

		<div id="content">
			<h2 style="color: blue; text-align: center; padding: 5px;">
				Welcome Admin: Manage your Content
			</h2>
			<?php
				if(isset($_GET['view_users']))
				{
					include("includes/view_users.php");
				}
			if(isset($_GET['view_posts']))
				{
					include("includes/view_posts.php");
				}
			if(isset($_GET['view_comments']))
			{
				include("includes/view_comments.php");
			}	
			if(isset($_GET['view_topics']))
			{
				include("includes/view_topics.php");
			}
			if(isset($_GET['add_topic']))
			{
				include("includes/add_topic.php");
			}
			?>
		</div>

		<div id="foot">
			<h2 style="text-align: center; padding: 10px;">Copyrights 2018 by www.onlinecourse.com</h2>
		</div>
	</div>
</body>
</html>
<?php } ?>