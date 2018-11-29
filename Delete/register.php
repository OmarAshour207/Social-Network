<!DOCTYPE html>
<html>
<head>
	<title>Registration</title>
	<link rel="stylesheet" href="style/style.css">
</head>
<body>
	<div class="signup">
		<form action="" method="post" style="color: white">
			<h2>Sign Up Here</h2>
			<input type="text" name="fname" id="first" placeholder="Enter Firstname" required="required">
			<input type="text" name="lname" id="second" placeholder="Enter Lastname" required="required">
			<input type="email" name="email" id="mail" placeholder="Enter E-mail" required="required"> <br>
			<input type="password" name="pass" placeholder="Enter Password" required="required"><br>
			<input type="password" name="Cpass" placeholder="Renter Password" required="required"><br>
			<h3>Birthday </h3> 
			<input type="date" name="u_birthday"> <br>
			<select name="Gender">
				<option>Select a Gender</option>
				<option>Male</option>
				<option>Female</option>d
			</select>
			<!-- <input type="radio" name="Gender">Male <input type="radio" name="Gender">Female <br> -->
			<input type="submit" name="sign_up" value="Register" class="Login-btn">
			<a href="slogin.php">Already Member </a>
				
		</form>
		<?php include("user_insert.php"); ?>
	</div>

</body>
</html>