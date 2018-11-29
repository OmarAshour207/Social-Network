<table width="800px" align="center" border="1px" bgcolor="skyblue">
	<tr>
		<th> S.N 	</th>
		<th> Name 	</th>
		<th> Email	</th>
		<th> Gender	</th>
		<th> Image  </th>
		<th> Delete	</th>
		<th> Edit	</th>
	</tr>
	<?php
		include("includes/database.php");
		$sel_users  = "SELECT * FROM `users` ORDER BY 1 DESC";
		$run_users = mysqli_query($con, $sel_users);

		$i = 0;
		while($row_users = mysqli_fetch_array($run_users))
		{
			$user_id 	 	= $row_users['user_id'];
			$user_name   	= $row_users['user_name'];
			$user_email  	= $row_users['user_email'];
			$user_image  	= $row_users['user_image'];
			$user_gender 	= $row_users['user_gender'];
			$user_reg_date  = $row_users['register_date'];
			$i++;
	?>
	<tr align="center">
		<td> <?php echo $user_id; ?> 	 </td>
		<td> <?php echo $user_name; ?> 	 </td>
		<td> <?php echo $user_email; ?>  </td>
		<td> <?php echo $user_gender; ?> </td>
		<td><img src="../user/user_images/<?php echo $user_image;?>" width='50' height='50'/> </td>
		<td> <a href="delete_user.php?delete=<?php echo $user_id; ?>"> Delete </a> </td>
		<td> <a href="index.php?view_users&edit=<?php echo $user_id; ?>"> Edit   </a> </td>
	</tr>
	<?php } ?>
</table>

<?php
	if(isset($_GET['edit']))
	{
		include("includes/database.php");
		$edit_id = $_GET['edit'];
		$sel_users  = "SELECT * FROM `users` WHERE `user_id` = '$edit_id'";
		$run_users = mysqli_query($con, $sel_users);
		$row_users = mysqli_fetch_array($run_users);
	
		$user_id 	 	= $row_users['user_id'];
		$user_name 		= $row_users['user_name'];
		$name 			= explode(" ", $user_name);
		$user_email  	= $row_users['user_email'];
		$user_image  	= $row_users['user_image'];
		$user_psswd     = $row_users['user_password'];
		$user_gender 	= $row_users['user_gender'];
		$date 			= $row_users['user_bitrhday'];
		$dating 		= explode('-', $date);
		$user_reg_date  = $row_users['register_date'];
?>

<form method="post" action="" id="f" class="ff" enctype="multipart/form-data" align="center">
	<h2 align="center"> Edit User</h2>
	User Photo: <input type="file" name="u_image" value="Edit Image"><br>
    First Name: <input type="text" id="first" name="fname" value="<?php echo $name[0]; ?>" ><br>
    Last  Name: <input type="text" id="second" name="lname" value="<?php echo $name[1]; ?>" ><br>
    User Email: <input type="email" id="mail" name="mail" value="<?php echo $user_email; ?>"><br>
    Password :  <input type="password" name="pass" value="" placeholder="New Password"> <br>
    <h3>Birthday </h3> 
    <select name="day">
    	<option> <?php echo $dating[2]; ?> </option>
    	<?php
    		for($Day = 1;$Day <= 31; $Day++)
    		{
    			echo "<option>" . $Day . "</option>";
    		}
    	 ?>
    </select>
    <select name="month">
        <option> <?php echo $dating[1]; ?> </option>
        <?php
        	for($month = 1 ;$month < 13 ;$month++)
        	{
        		echo "<option>" . $month . "</option>";
        	} 
        ?>
    </select>
    <select name="year">
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
		<p>Gender</p><option><?php echo $user_gender; ?> </option>
		<option> Male </option>
		<option> Female </option>
	</select><br>
    <input type="submit" name="update" value="Update">
    
</form>
<?php } ?>
<?php
	if(isset($_POST['update']))
	{
		$f_name 	= $_POST['fname'];
		$l_name 	= $_POST['lname'];
		$u_name 	= $f_name . ' ' . $l_name;
		$u_mail 	= $_POST['mail'];
		$u_pass 	= $_POST['pass'];
		$u_image 	= $_FILES['u_image']['name'];
		$image_tmp 	= $_FILES['u_image']['tmp_name'];
		$u_gender 	= $_POST['u_gender'];

		move_uploaded_file($image_tmp, "user/user_images/$u_image");

		$update = "UPDATE `users` SET user_name='$u_name', user_password='$u_pass', user_email='$u_mail', user_image='$u_image', user_gender='$u_gender' WHERE 
		user_id='$edit_id' ";
		$run = mysqli_query($con,$update);

		if($run)
		{
			echo "<script> alert('User has been updated') </script>";
			echo "<script> window.open('index.php?view_users','_self') </script>";
		}
	}
?>

