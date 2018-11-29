		<!-- Content Area starts -->
		<div id="content">
			<div class="inside">
	        	<h3>Et3lm helps you learn and share your knowledge with the people.</h3>
	        	<img src="img/fb.png"/>
	        </div>
	    
		    <div class="signup">
		        <h1>Create an Account</h1>
		        <h3>It's free and always will be</h3>
		        <form method="post" action="">
		            <input type="text" id="first" name="fname" placeholder="Enter First name">
		            <input type="text" id="second" name="lname" placeholder="Enter Last name">
		            <input type="email" id="mail" name="mail" placeholder="Email">
		            <input type="password" name="pass" placeholder="Password"> 
		            <input type="password" name="repassword" placeholder="Renter Password">
		            <h3>Birthday </h3> 
		            <select name="day">
		            	<option>Day</option>
		            	<?php
		            		for($Day = 1;$Day <= 31; $Day++)
		            		{
		            			echo "<option>" . $Day . "</option>";
		            		}
		            	 ?>
                    </select>
                    <select name="month">
                        <option>Month</option>
                        <?php
                        	for($month = 1 ;$month < 13 ;$month++)
                        	{
                        		echo "<option>" . $month . "</option>";
                        	} 
                        ?>
                    </select>
                    <select name="year">
                        <option>Year</option>
                        <?php
                        	for($year = 2018; $year >= 1900; $year--)
                        	{
                        		echo "<option>" . $year . "</option>";
                        	}
                        ?>
                    </select>
					<!-- <input type="date" name="u_birthday"> <br> -->
					<br>
		            <input type="radio" name="Gender" value="Female">Female<input type="radio" name="Gender" value="Male">Male <br>
		            <input type="submit" name="signup" value="SignUp">
		            
		        </form>
		        <?php include("user_insert.php"); ?>
		    </div>
	    </div>
	    <!-- Content Area Ends -->