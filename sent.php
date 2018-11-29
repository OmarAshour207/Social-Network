<?php
	include("includes/database.php");
?>
<table width="600px" align="center">

<tr>
		<th> Receiver </th>
		<th> Subject </th>
		<th> Date </th>
		<th> Reply </th>
	</tr>


<?php

	$sel_msg = " SELECT * FROM messages WHERE sender='$user_id' AND status='unread' ORDER BY 1 DESC ";
	$run_msg = mysqli_query($con,$sel_msg);
	$count_msg = mysqli_num_rows($run_msg);

	while($row_msg = mysqli_fetch_array($run_msg))
	{
		$msg_id		 	= $row_msg['msg_id'];
		$msg_sender 	= $row_msg['sender'];
		$msg_receiver 	= $row_msg['receiver'];
		$msg_subject 	= $row_msg['msg_subject'];
		$msg_topic 		= $row_msg['msg_topic'];
		$msg_reply 		= $row_msg['reply'];
		$msg_date 		= $row_msg['msg_date'];
		
	

	$get_receiver = "SELECT * FROM `users` WHERE `user_id`='$msg_receiver' ";
	$run_receiver = mysqli_query($con,$get_receiver);
	$row_receiver = mysqli_fetch_array($run_receiver);

	$receiver_name = $row_receiver['user_name'];
?>

	<tr align="center">
		<td> <a href="user_profile.php?u_id=<?php echo $msg_receiver; ?>" target="blank"> 
		<?php echo $receiver_name; ?> </td>
		<td> <a href="my_messages.php?msg_id=<?php echo $msg_id ?>"> 
				<?php echo $msg_subject; ?> </td>
		<td> <?php echo $msg_date; 	  ?> </td>
		<td> <a href="my_messages.php?msg_id=<?php echo $msg_id ?>"> View reply </td>
	</tr>

<?php } ?>	
</table>

<?php
	if(isset($_GET['msg_id']))
	{
		$get_id = $_GET['msg_id'];

		$sel_message = " SELECT * FROM `messages` WHERE `msg_id` ='$get_id' ";
		$run_message = mysqli_query($con,$sel_message);
		$row_message = mysqli_fetch_array($run_message);
		
		$msg_subject   = $row_message['msg_subject'];
		$msg_topic     = $row_message['msg_topic'];
		$reply_content = $row_message['reply'];

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