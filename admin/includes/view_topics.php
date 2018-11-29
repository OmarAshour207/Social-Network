<table width="800px" align="center" border="1px" bgcolor="skyblue">
	<tr>
		<th> S.N 		</th>
		<th> Topic  	</th>
		<th> Delete		</th>
		<th> Edit		</th>
	</tr>
	<?php
		include("includes/database.php");
		$sel_topic  = "SELECT * FROM `topics` ORDER BY 1 DESC";
		$run_topic  = mysqli_query($con, $sel_topic);

		while($row_topic = mysqli_fetch_array($run_topic))
		{
			$topic_id 		= $row_topic['topic_id'];
			$topic_title 	= $row_topic['topic_title'];
			
	?>
	<tr align="center">
		<td> <?php echo $topic_id; ?> 		</td>
		<td> <?php echo $topic_title; ?> 	</td>
		<td> <a href="index.php?view_topics&delete=<?php echo $topic_id; ?>"> Delete </a> </td>
		<td> <a href="index.php?view_topics&edit=<?php echo $topic_id; ?>"> Edit   </a> </td>
	</tr>
	<?php } ?>
</table>

<?php
	if(isset($_GET['edit']))
	{	
		include("includes/database.php");
		$edit_id   	  = $_GET['edit'];
		$sel_topic  = "SELECT * FROM `topics` WHERE `topic_id` = '$edit_id'";
		$run_topic  = mysqli_query($con, $sel_topic);
		$row_topic  = mysqli_fetch_array($run_topic);
		
		$topic_new_id  = $row_topic['topic_id'];
		$topic_title   = $row_topic['topic_title'];	
?>
				<form action="" method="post" id="f" enctype="multipart/form-data">
					<h2 style="padding:5px;"> Update the Topics </h2>
					<textarea cols="70" rows="4" name="content" ><?php echo $topic_title; ?></textarea><br>
					<input type="submit" name="update" value="Edit topic">
				</form>

<?php } ?>
<?php
	if(isset($_POST['update']))
	{
		$content 	= $_POST['content'];	
		
		$update = "UPDATE `topics` SET `topic_title` = '$content' WHERE 
		`topic_id` = '$topic_new_id' ";
		$run = mysqli_query($con,$update);

		if($run)
		{
			echo "<script> alert('Topic has been updated') </script>";
			echo "<script> window.open('index.php?view_topics','_self') </script>";
		}
	}

	if(isset($_GET['delete']))
	{
		$delete_id = $_GET['delete'];
		$delete    = "DELETE FROM `topics` WHERE `topic_id` = '$delete_id'";
		$run_del   = mysqli_query($con, $delete);

		if($run_del)
		{
			echo "<script> alert('Topic has been Deleted') </script>";
			echo "<script> window.open('index.php?view_topics','_self') </script>";	
		}
	}
?>

