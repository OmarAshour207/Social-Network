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

					$user_id 		= $row['user_id'];
					$user_name 		= $row['user_name'];
					$user_image 	= $row['user_image'];
					$register_date 	= $row['register_date'];
					$last_login 	= $row['last_login'];

					$user_posts = "SELECT * FROM posts WHERE user_id='$user_id' ";
					$run_posts  = mysqli_query($con,$user_posts);
					$posts 		= mysqli_num_rows($run_posts);

					$sel_msg 	= " SELECT * FROM messages WHERE receiver='$user_id' AND status='unread' ORDER BY 1 DESC ";
					$run_msg 	= mysqli_query($con,$sel_msg);
					$count_msg 	= mysqli_num_rows($run_msg);


					echo "
						<center> <img src='user/user_images/$user_image' width='200px' height='200px'/> </center>
						<div id='user_mention'>
						<p> <strong> Name: </strong> $user_name </p>
						<p> <strong> Last Login: </strong> $last_login </p>
						<p> <strong> Member Since: </strong> $register_date </p>

						<p> <a href='my_messages.php?inbox&u_id=$user_id'> My Messages ($count_msg) </a> </p>
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
			<div id="messages">
				<p align="center">
					<a href="my_messages.php?inbox">My Inbox </a> ||
					<a href="my_messages.php?sent"> Sent Items </a>
				</p>
				<?php if(isset($_GET['sent'])){
					include("sent.php");
				}  ?>
				<?php if(isset($_GET['inbox'])) { ?>
				<table width="600px" align="center">
					<tr>
						<th> Sender </th>
						<th> Subject </th>
						<th> Date </th>
						<th> Reply </th>
					</tr>

				<?php
					$sel_msg 		= " SELECT * FROM messages WHERE receiver='$user_id' ORDER BY 1 DESC ";
					$run_msg 		= mysqli_query($con, $sel_msg);
					$count_msg  	= mysqli_num_rows($run_msg);
					while($row_msg = mysqli_fetch_array($run_msg))
					{
						$msg_id		 	= $row_msg['msg_id'];
						$msg_sender 	= $row_msg['sender'];
						$msg_receiver 	= $row_msg['receiver'];
						$msg_subject 	= $row_msg['msg_subject'];
						$msg_topic 		= $row_msg['msg_topic'];
						$msg_reply 		= $row_msg['reply'];
						$msg_date 		= $row_msg['msg_date'];
						
					

					$get_sender = "SELECT * FROM `users` WHERE `user_id` = '$msg_sender' ";
					$run_sender = mysqli_query($con,$get_sender);
					$row_sender = mysqli_fetch_array($run_sender);
					$sender_name = $row_sender['user_name'];
				?>

					<tr align="center">
						<td> <a href="user_profile.php?u_id=<?php echo $msg_sender; ?>" target="blank"> 
						<?php echo $sender_name; ?> </td>
						<td> <a href="my_messages.php?inbox&msg_id=<?php echo $msg_id ?>"> 
								<?php echo $msg_subject; ?> </td>
						<td> <?php echo $msg_date; 	  ?> </td>
						<td> <a href="my_messages.php?inbox&msg_id=<?php echo $msg_id ?>"> View Reply </td>
					</tr>

			  <?php } ?>	
				</table>

				<?php
					if(isset($_GET['msg_id']))
					{
						$get_id = $_GET['msg_id'];

						$sel_message = " SELECT * FROM messages WHERE msg_id ='$get_id' ";
						$run_message = mysqli_query($con,$sel_message);
						$row_message = mysqli_fetch_array($run_message);
						
						$msg_subject   = $row_message['msg_subject'];
						$msg_topic     = $row_message['msg_topic'];
						$reply_content = $row_message['reply'];

						// Updating unread messages to read
						$update_unread = "UPDATE `messages` SET `status` = 'read' WHERE `msg_id`=$get_id";
						$run_update	   = mysqli_query($con, $update_unread);

						echo " <center> <br> 
						<h2> $msg_subject </h2> 
						<h3><b>Message: </b> $msg_topic </h3> 
						<p><b> My Reply: </b> $reply_content </p>

						<form action='' method='post'>
							<textarea cols='30' rows='5' name='reply' > </textarea> <br>
							<input type='submit' name='msg_reply' value='Reply To This'>
						</form>
						<center>
						";

					}

					if(isset($_POST['msg_reply']))
					{
						$user_reply = $_POST['reply'];

						if($reply_content != 'No_Reply')
						{
							echo "<h2 align='center'> Message was already Replied </h2>";
							exit();
						}
						else
						{
							$update_msg = "UPDATE messages SET reply='$user_reply' WHERE msg_id='$get_id' ";
							$run_update = mysqli_query($con,$update_msg);
							echo "<h2 align='center'> Message was Replied </h2>";
						}
					}
				?>
				<?php } ?>
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

