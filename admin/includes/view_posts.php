<table width="800px" align="center" border="1px" bgcolor="skyblue">
	<tr>
		<th> S.N 	</th>
		<th> Title 	</th>
		<th> Author	</th>
		<th> Date	</th>
		<th> Delete	</th>
		<th> Edit	</th>
	</tr>
	<?php
		include("includes/database.php");
		$sel_post  = "SELECT * FROM `posts` ORDER BY 1 DESC";
		$run_post  = mysqli_query($con, $sel_post);

		$i = 0;
		while($row_post = mysqli_fetch_array($run_post))
		{
			$post_id 	= $row_post['post_id'];
			$user_id 	= $row_post['user_id'];
			$post_title = $row_post['post_title'];
			$post_date 	= $row_post['post_date'];
			$i++;

			$sel_user = "SELECT * FROM `users` WHERE `user_id` = '$user_id'";
			$run_user = mysqli_query($con, $sel_user);	
			while($row_user = mysqli_fetch_array($run_user))
			{
				$user_name 	= $row_user['user_name'];
	?>
	<tr align="center">
		<td> <?php echo $user_id; ?> 		</td>
		<td> <?php echo $post_title; ?> 	</td>
		<td> <?php echo $user_name; ?>  	</td>
		<td> <?php echo $post_date; ?> 		</td>
		<td> <a href="index.php?view_posts&delete=<?php echo $post_id; ?>"> Delete </a> </td>
		<td> <a href="index.php?view_posts&edit=<?php echo $post_id; ?>"> Edit   </a> </td>
	</tr>
	<?php } }?>
</table>

<?php
	if(isset($_GET['edit']))
	{
		include("includes/database.php");
		$edit_id   = $_GET['edit'];
		$sel_post  = "SELECT * FROM `posts` WHERE `post_id` = '$edit_id'";
		$run_post  = mysqli_query($con, $sel_post);
		$row_post  = mysqli_fetch_array($run_post);
		
		$post_new_id  = $row_post['post_id'];
		$post_title   = $row_post['post_title'];
		$post_content = $row_post['post_content'];	
?>
				<form action="" method="post" id="f" enctype="multipart/form-data">
					<h2 style="padding:5px;"> Update the post </h2>
					<input type="text" name="title" value="<?php echo $post_title; ?>"> <br>
					<textarea cols="70" rows="4" name="content" ><?php echo $post_content; ?></textarea><br>
					<select name="topic">
						<option> Select Topic </option>
						<?php
							getTopics();
						 ?>
					</select>
					<input type="submit" name="update" value="Update Post">
				</form>

<?php } ?>
<?php
	if(isset($_POST['update']))
	{
		$title 		= $_POST['title'];
		$content 	= $_POST['content'];
		$topic 		= $_POST['topic'];
		
		$update = "UPDATE `posts` SET `post_title` = '$title', `post_content` = '$content', `topic_id` = '$topic', `post_date` = NOW() WHERE 
		`post_id` = '$post_new_id' ";
		$run = mysqli_query($con,$update);

		if($run)
		{
			echo "<script> alert('Post has been updated') </script>";
			echo "<script> window.open('index.php?view_posts','_self') </script>";
		}
	}

	if(isset($_GET['delete']))
	{
		$delete_id = $_GET['delete'];
		$delete    = "DELETE FROM `posts` WHERE `post_id` = '$delete_id'";
		$run_del   = mysqli_query($con, $delete);

		if($run_del)
		{
			echo "<script> alert('Post has been Deleted') </script>";
			echo "<script> window.open('index.php?view_posts','_self') </script>";	
		}
	}
?>

