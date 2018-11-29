<table width="800px" align="center" border="1px" bgcolor="skyblue">
	<tr>
		<th> S.N 		</th>
		<th> Content 	</th>
		<th> Author		</th>
		<th> Date		</th>
		<th> Delete		</th>
		<th> Edit		</th>
	</tr>
	<?php
		include("includes/database.php");
		$sel_comment  = "SELECT * FROM `comment` ORDER BY 1 DESC";
		$run_comment  = mysqli_query($con, $sel_comment);

		while($row_comment = mysqli_fetch_array($run_comment))
		{
			$comment_id 		= $row_comment['comment_id'];
			$user_id 			= $row_comment['user_id'];
			$comment_content 	= $row_comment['comment_content'];
			$comment_author     = $row_comment['comment_author'];
			$comment_date 		= $row_comment['comment_date'];
			
	?>
	<tr align="center">
		<td> <?php echo $comment_id; ?> 		</td>
		<td> <?php echo $comment_content; ?> 	</td>
		<td> <?php echo $comment_author; ?>  	</td>
		<td> <?php echo $comment_date; ?> 		</td>
		<td> <a href="index.php?view_comments&delete=<?php echo $comment_id; ?>"> Delete </a> </td>
		<td> <a href="index.php?view_comments&edit=<?php echo $comment_id; ?>"> Edit   </a> </td>
	</tr>
	<?php } ?>
</table>

<?php
	if(isset($_GET['edit']))
	{	
		include("includes/database.php");
		$edit_id   	  = $_GET['edit'];
		$sel_comment  = "SELECT * FROM `comment` WHERE `comment_id` = '$edit_id'";
		$run_comment  = mysqli_query($con, $sel_comment);
		$row_comment  = mysqli_fetch_array($run_comment);
		
		$comment_new_id  = $row_comment['comment_id'];
		$comment_content = $row_comment['comment_content'];	
?>
				<form action="" method="post" id="f" enctype="multipart/form-data">
					<h2 style="padding:5px;"> Update the Comment </h2>
					<textarea cols="70" rows="4" name="content" ><?php echo $comment_content; ?></textarea><br>
					<input type="submit" name="update" value="Edit Comment">
				</form>

<?php } ?>
<?php
	if(isset($_POST['update']))
	{
		$content 	= $_POST['content'];	
		
		$update = "UPDATE `comment` SET `comment_content` = '$content' ,`comment_date` = NOW() WHERE 
		`comment_id` = '$comment_new_id' ";
		$run = mysqli_query($con,$update);

		if($run)
		{
			echo "<script> alert('Comment has been updated') </script>";
			echo "<script> window.open('index.php?view_comments','_self') </script>";
		}
	}

	if(isset($_GET['delete']))
	{
		$delete_id = $_GET['delete'];
		$delete    = "DELETE FROM `comment` WHERE `comment_id` = '$delete_id'";
		$run_del   = mysqli_query($con, $delete);

		if($run_del)
		{
			echo "<script> alert('Comment has been Deleted') </script>";
			echo "<script> window.open('index.php?view_comments','_self') </script>";	
		}
	}
?>

